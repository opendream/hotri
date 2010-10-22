<?php
class CsvImport {
  function importFromCsv($file) {
    // Get uploaded file
    $path = $file['tmp_name'];
    
    // Validations
    if (!is_uploaded_file($path)) {
      return array('error'=>'invalid upload files');
    }
    if ($file['size'] <= 0 || $file['size'] > 10000000) {
      return array('error'=>'oversized files');
    }
    
    // Read CSV
    $fp = $this->fopen_utf8($file['tmp_name'], 'r');
    if (!$fp) {
      return array('error'=>'unable to open uploaded files');
    }
    
    // Make sure first row must have no changes. (Missing header issue)
    $s = fgets($fp);
    $arr = $this->_string2Array($s);
    $required_header = array('ISBN', 'ชื่อผู้แต่ง', 'ชื่อเรื่อง', 'ชื่อเรื่องย่อย', 'ผู้รับผิดชอบ',
     'Call Number', 'Call Number (2)', 'สถานที่พิมพ์', 'สำนักพิมพ์', 'ปีที่พิมพ์',);
    $i = 0;
    foreach ($arr as $field) {
      if (trim($field) != $required_header[$i]) {
        return array('error' => 'Missing header', 'pos' => $required_header[$i] . '(' . strlen($required_header[$i]) . ') != ' . $field . '(' . strlen($field) . ')');
      }
      $i++;
    }
    if ($i != count($required_header)) {
      return array('error' => 'Incorrect header');
    }
    $copy = 0;
    $done = 0;
    $failed = 0;
    $importQ = new CsvImportQuery();
    $line = 0;
    while (!feof($fp)) {
      $s = fgets($fp);
      $line++;
      $formatted = $this->_string2Array($s);
      if ($formatted['quote_incorrect']) {
        return array('error' => 'Incorrect double quote formatting');
      }
      else if (empty ($formatted['020a']) || empty($formatted['100a']) || empty($formatted['245a'])) {
        return array('error' => 'Missing required fields (ISBN, ชื่อผู้แต่ง, ชื่อเรื่อง) @ line ' . $line);
      }
    }
    fclose($fp);

    // Reopen to save them
    $fp = $this->fopen_utf8($file['tmp_name'], 'r');
    if (!$fp) {
      return array('error'=>'unable to open uploaded files');
    }
    $s = fgets($fp); // Skip header line
    while (!feof($fp)) {
      $s = fgets($fp);
      $import = $importQ->import($this->_string2Array($s));
      if ($import == 'copy') {
        $copy++;
      }
      else if ($import == 'done') {
        $done++;
      }
      else {
        $failed++;
      }
    }
    fclose($fp);
    return array('done'=>$done, 'copy'=>$copy, 'failed'=>$failed);
  }
  
  function fopen_utf8($filename, $type = 'r'){
    $encoding='';
    $handle = fopen($filename, $type);
    $bom = fread($handle, 2);
    rewind($handle);

    if($bom === chr(0xff).chr(0xfe)  || $bom === chr(0xfe).chr(0xff)){
      // UTF16 Byte Order Mark present
      $encoding = 'UTF-16';
    } else {
      $file_sample = fread($handle, 1000) + 'e'; // Read first 1000 bytes
      // + e is a workaround for mb_string bug
      rewind($handle);
      $encoding = mb_detect_encoding($file_sample , 'UTF-8, UTF-7, ASCII, EUC-JP,SJIS, eucJP-win, SJIS-win, JIS, ISO-2022-JP');
    }
    if ($encoding){
      stream_filter_append($handle, 'convert.iconv.'.$encoding.'/UTF-8');
    }
    return $handle;
  } 
  
  function _string2Array($str) {
    // Get array of data, without end of line
    $data = explode("\t", str_replace("\n", '', $str));
    
    foreach ($data as $i => $val) {
      // Strip all unescaped quotes, they should always be ("...") pattern
      if (mb_strpos($val, '"') === 0) {
        $data[$i] = mb_substr($val, 1, -1);
      }
      else {
        $data[$i] = $val;
      }
      
      // For escape quote should be parsed as double quotes
      $data[$i] = str_replace('""', '"', $data[$i]);
    }
    
    // Map data with real marc fields
    $header = array('020a', '100a', '245a', '245b', '245c', '050a', '050b', 
      '260a', '260b', '260c', );
      
    $data = array_combine($header, $data);
    
    return $data;
  }
}

class CsvImportQuery extends Query {
  function import($row) {
    require_once("BulkLookup.php");
    $bl = new BulkLookupQuery();
    if (!isset($row['020a'], $row['100a'], $row['245a'])) {
      return false;
    }
    $isbn = $this->verifyISBN($row['020a']);
    $existBibid = $this->getExistBiblio($isbn);
    if ($existBibid > 0) {
      $bl->addCopy($existBibid);
      return 'copy';
    }
    $this->_formatResults($row);
    $bib = $this->_getBiblio($row);
    $insert_bib[$isbn]['bibid'] = 0 + $this->_insertBiblio($bib);
    
    if ($insert_bib[$isbn]['bibid'] > 0) {
      $this->addCopy($insert_bib[$isbn]['bibid']);
      return 'done';
    }
    else {
      return false;
    }
  }
  
  function _formatResults(&$data) {
    
    switch ($this->_getCallNumberType()) {
      case 'loc':
      default: // Now support loc first.
        $data['callNmbr1'] = $data['050a'];
        $data['callNmbr2'] = $data['050b'];
        break;
      
    }
    $data['collectionCd'] = $this->_getDefaultCollection();
    $data['materialCd'] = $data['collectionCd'];
  }
  
  function _getDefaultCollection() {
    $this->_query("SELECT code FROM collection_dm WHERE default_flg='Y'", false);
    $array = $this->_conn->fetchRow();
    return $array === false ? '' : $array['code'];
  }
  
  function _getCallNumberType() {
    $this->_query("SELECT cutter_type FROM lookup_settings", false);
    $array = $this->_conn->fetchRow();
    return $array === false ? false : strtolower($array['cutter_type']);
  }
  
  function _getBiblio($post) {
    require_once("Biblio.php");
    require_once("BiblioField.php");
    
    $biblio = new Biblio();
    $biblio->setMaterialCd($post["materialCd"]);
    $biblio->setCollectionCd($post["collectionCd"]);
    $biblio->setCallNmbr1($post["callNmbr1"]);
    $biblio->setLastChangeUserid($_SESSION["userid"]);
    $biblio->setOpacFlg(true);
    unset($post['callNmbr1'], $post['callNmbr2'], $post['callNmbr3'], $post['collectionCd'], $post['materialCd']);
    $post['020a'] = $this->verifyISBN($post['020a']);
    $title_trail = substr($post['245a'], strlen($post['245a']) - 1);

    if ($title_trail == '/' || $title_trail == ':')
      $post['245a'] = substr($post['245a'], 0, -1);
    foreach($post as $index=>$val) {
      $value = $val;
      $fieldid = '';
      $tag = 0 + substr($index, 0, 3);
      $subfieldCd = substr($index, 3, 1);
      $requiredFlg = '';
      if ($index == '100a' || $index == '245a') // Author, Title
        $requiredFlg = 1;
      
      $biblioFld = new BiblioField();
      $biblioFld->setFieldid($fieldid);
      $biblioFld->setTag($tag);
      $biblioFld->setSubfieldCd($subfieldCd);
      $biblioFld->setIsRequired($requiredFlg);
      $biblioFld->setFieldData($value);
      $biblio->addBiblioField($index,$biblioFld);
    }
    
    return $biblio;
  }
  
  function _insertBiblio($biblio) {
    require_once("BiblioQuery.php");
    
    $biblioQ = new BiblioQuery();
    $biblioQ->connect();
    if ($biblioQ->errorOccurred()) {
      $biblioQ->close();
      return false;
    }
    $bibid = $biblioQ->insert($biblio);
    if (!$bibid) {
      $biblioQ->close();
      return false;
    }
    $biblioQ->close();
    return $bibid;
  }
  
  function addCopy($bibid) {
    $bibid = 0 + $bibid;
    if ($bibid < 1) {
      return false;
    }
    require_once("BiblioCopyQuery.php");
    $copyQ = new BiblioCopyQuery();
    $copyQ->connect();
    if ($copyQ->errorOccurred()) {
      $copyQ->close();
    }
    
    // Auto generate barcode
    $CopyNmbr = $copyQ->nextCopyid($bibid);
    if ($copyQ->errorOccurred()) 
      $copyQ->close();
    
    $nzeros = "5";
    $barcode = sprintf("%0".$nzeros."s",$bibid).$CopyNmbr;
    
    $copy = new BiblioCopy();
    $copy->setBibid($bibid);
    $copy->setBarcodeNmbr($barcode);
    if (!$copyQ->insert($copy)) {
      $copyQ->close();
    }
    $copyQ->close();
  }
  
  function getExistBiblio($isbn) {
    $isbn = mysql_escape_string($isbn);
    if (strlen($isbn) != 10) {
      return 0;
    }
    $this->_query("SELECT bibid FROM biblio_field WHERE tag=20 AND field_data='$isbn' LIMIT 1", false); // 020 = ISBN
    $data = $this->_conn->fetchRow();
    return 0 + $data['bibid'];
  }
  
  function verifyISBN($isbn,$keepDashes = false) {
			## remove any "-" char user may have entered
			if (!$keepDashes) {
				$isbn = str_replace("-", "", $isbn);
			}
			## remove any space char user may have entered
			$isbn = str_replace(" ", "", $isbn);

			// When isbn is not number (3 first characters), return false
			if (!is_numeric(substr($isbn, 0, 9))) {
			  return false;
			}

			## test if its a scanned EAN code
			## '978' & '979' per Cristoph Lange of Germany
			if (((substr($isbn, 0,3) == "978") ||(substr($isbn, 0,3) == "979")) && (strlen($isbn) > 12))  {
				## extract the isbn from the scanner jumble
				$isbn = substr($isbn, 3,9);
				$xSum = 0;
				$add = 0;
				for ($i=0; $i<9; $i++) {
					$add = substr($isbn, $i,1);
					$xSum += (10-$i) * $add;
				}
				$xSum %= 11;
				$xSum = 11-$xSum;
				if ($xSum == 10) {
					$xSum = "X";
			  }
				if ($xSum == 11) {
					$xSum = "0";
				}
				$isbn = $isbn . $xSum;
			}
			return substr($isbn,0,10);
	}
}
