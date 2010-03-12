<?php

require_once("../shared/common.php");
require_once(dirname(__FILE__) . '/../lookup2/LookupHostsQuery.php');

class BulkLookup {
  private $_results;
  function BulkLookup() {
    
  }
  
  function showResults() {
    print_r($this->_results);
  }
  
  function importISBN($file, &$isbnList) {
    // Get uploaded file.
    $path = $file['tmp_name'];
    
    // Validations.
    if (!is_uploaded_file($path)) return array('error'=>'invalid upload files');
    if ($file['size'] <= 0 || $file['size'] > 10000) return array('error'=>'oversized files');
    
    // Read ISBN.
    $fp = fopen($file['tmp_name'], 'r');
    if (!$fp) return array('error'=>'unable to open uploaded files');
    
    $bl = new BulkLookupQuery();
    while (!feof($fp)) {
      $line = trim(fgets($fp));
      $isbn = $this->_verifyISBN($line);
      if (strlen($isbn) == 10) {
        $bl->queue($isbn);
        //$isbnList[] = $line;
      }
    }
    
    // Enable cron.
    file_put_contents(dirname(__FILE__) . '/../cron/cronrun.txt', 'ON');
  }
  
  function search($isbnList) {
    $bl = new BulkLookupQuery();
    
    foreach ($isbnList as $isbn) {
      $list = $this->_getLookupServers();
      $retry = false;
      foreach ($list as $server) {
        $result = $this->_getLookupResult($server, $isbn);
        if (!$result || isset($result['error'])) {
          if (ereg('not connect', $result['error']) || ereg('response error', $result['error'])) {
            $retry = true;
          }
          continue;
        }
        $this->_addResult(array('isbn'=>$isbn, 'data'=>$result));
        break;
      }
      
      if (isset($result['error'])) {
        $this->_addResult(array('isbn'=>$isbn, 'data'=>NULL));
        
        if ($retry) 
          $bl->setLookupStatus('retry', $isbn);
        else 
          $bl->setLookupStatus('manual', $isbn);
      }
    }
    $bl->saveResults($this->_results);
  }
  
  private function _verifyISBN($isbn,$keepDashes = false) {
			## remove any "-" char user may have entered
			if (!$keepDashes) {
				$isbn = str_replace("-", "", $isbn);
			}
			## remove any space char user may have entered
			$isbn = str_replace(" ", "", $isbn);

			## test if its a scanned EAN code
			## '978' & '979' per Cristoph Lange of Germany
			if (((substr($isbn, 0,3) == "978") ||(substr($isbn, 0,3) == "979")) && (strlen($isbn) > 12))  {
				## extract the isbn from the scanner jumble
				$isbn = substr($isbn, 3,9);
				//echo "raw reader isbn: $isbn <br />";

				$xSum = 0;
				$add = 0;
				for ($i=0; $i<9; $i++) {
					$add = substr($isbn, $i,1);
					$xSum += (10-$i) * $add;
				}
				$xSum %= 11;
				$xSum = 11-$xSum;
				if ($xSum == 10)
					$xSum = "X";
				if ($xSum == 11)
					$xSum = "0";
				//echo 'checksum: ' . $xSum . '<br />';

				$isbn = $isbn . $xSum;
			}
			return substr($isbn,0,10);
	}
  
  private function _getLookupServers() {
    global $postVars;
    getHosts('active');
    return $postVars['hosts'];
  }
  
  private function _getLookupResult($server, $isbn) {
    // Now support YAZ only.
    $query = '@attr 1=7 ' . $isbn;
    $conn = yaz_connect($server['host'], 
     array('user'=>$server['user'], 'password'=>$server['pw']));
    
    if (!$conn) return array('error' => 'could not connect lookup');
    yaz_database($conn, $server['db']);
    yaz_syntax($conn, "usmarc");
    yaz_element($conn, "F");

    //echo "sending: $qry <br />";
    if (! yaz_search($conn, 'rpn', $query)) return array('error' => 'bad query');
    
    yaz_wait();
    $error = yaz_error($conn);
    if (!empty($error)) {
      return array('error'=>'lookup response error (' . yaz_errno($conn) . ') : ' . yaz_addinfo($conn));
    }
    
    if (yaz_hits($conn) < 1) {
      return array('error'=>'no result');
    }
    // For bulk actions, auto select first record
    require_once(dirname(__FILE__) . '/../lookup2/lookupYazFunc.php');
    return extract_marc_fields(yaz_record($conn, 1, 'array'), true, 1, 1);
  }
  
  private function _addResult($result) {
    if (!is_array($result) || !isset($result['isbn'])) return false;
    
    $this->_results[$result['isbn']] = $result['data'];
    
    return true;
  }
  
}

class BulkLookupQuery extends Query {
  function queue($isbn) {
    return $this->_query("INSERT INTO lookup_queue (isbn) VALUES ('$isbn')", false);
  }
  
  function getQueue($status = 'queue', $limit = 100) {
    $limit = 0 + $limit;
    switch ($status) {
      case 'queue':
      case 'publish':
      case 'manual':
        $cond = "WHERE status='$status'";
        break;
      
      default:
        $cond = '';
    }
    $this->_query("SELECT * FROM lookup_queue $cond LIMIT $limit", false);
    
  }
  
  function fetch() {
    return $this->_conn->fetchRow();
  }
  
  function countQueue($status = 'queue') {
    switch ($status) {
      case 'queue':
      case 'publish':
      case 'manual':
        $cond = "WHERE status='$status'";
        break;
      
      default:
        $cond = '';
      
    }
    $this->_query("SELECT COUNT(*) AS c FROM lookup_queue $cond", false);
    
    $res = $this->fetch();
    return $res[c];
  }
  
  function setLookupStatus($status, $isbn) {
    if (0 + $isbn < 1) return false;
    switch ($status) {
      case 'publish':
      case 'queue':
      case 'manual':
        $this->_query("UPDATE lookup_queue SET status='$status' WHERE isbn='$isbn'", false);
        break;
      case 'retry':
        $this->_query("UPDATE lookup_queue SET tries=tries+1 WHERE isbn='$isbn'", false);
    }
  }
  
  function saveResults(&$results) {
    if (!is_array($results)) return false;
    foreach ($results as $isbn=>$data) {
      if (isset($data)) {
        $this->_formatResults($data);
        $bib = $this->_getBiblio($data);
        $results[$isbn]['bibid'] = 0 + $this->_insertBiblio($bib);
        if ($results[$isbn]['bibid'] > 0) {
          $this->_addCopy($results[$isbn]['bibid']);
          $this->setLookupStatus('publish', $isbn);
        }
      }
    }
  }
  
  private function _addCopy($bibid) {
    $bibid = 0 + $bibid;
    if ($bibid < 1) return false;
    
    require_once(dirname(__FILE__) . "/../classes/BiblioCopyQuery.php");
    $copyQ = new BiblioCopyQuery();
    $copyQ->connect();
    if ($copyQ->errorOccurred()) 
      $copyQ->close();
    
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
      /*
      if ($copyQ->getDbErrno() == "") {
        $pageErrors["barcodeNmbr"] = $copyQ->getError();
        $_SESSION["postVars"] = $_POST;
        $_SESSION["pageErrors"] = $pageErrors;
        header("Location: ../catalog/biblio_copy_new_form.php?bibid=".U($bibid));
        exit();
      } else {
        displayErrorPage($copyQ);
      }
      */
    }
    $copyQ->close();
  }
  
  private function _insertBiblio($biblio) {
    require_once(dirname(__FILE__) . "/../classes/BiblioQuery.php");
    
    $biblioQ = new BiblioQuery();
    $biblioQ->connect();
    if ($biblioQ->errorOccurred()) {
      $biblioQ->close();
      //displayErrorPage($biblioQ);
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
  
  private function _getCallNumberType() {
    $this->_query("SELECT cutter_type FROM lookup_settings", false);
    $array = $this->_conn->fetchRow();
    return $array === false ? false : strtolower($array['cutter_type']);
  }
  
  private function _getDefaultCollection() {
    $this->_query("SELECT code FROM collection_dm WHERE default_flg='Y'", false);
    $array = $this->_conn->fetchRow();
    return $array === false ? '' : $array['code'];
  }
  
  private function _formatResults(&$data) {
    
    switch ($this->_getCallNumberType()) {
      case 'loc':
      default: // Now support loc first.
        $data['callNmbr1'] = $data['050a'];
        $data['callNmbr2'] = $data['050b'];
        break;
      
      
      /* Unmanaged code
      case 'dew':
        
        var fictionDew = lkup.opts['fictionDew'].split(' ');
			if (lkup.opts['autoDewey']
					&&
					((code == "") || (code == "[Fic]"))
					&&
					(fictionDew.indexOf(code) >= 0)
				 ) {
				//echo "using default dewey code" . '</br />';
				dew = lkup.opts['defaultDewey'];
			}

			var parts = code.split('.');
			var base1 = parts[0];
			var callNmbr = base1;
			if (parts[1]) {
				var base2 = parts[1].split('/');
				callNmbr += '.'+base2;
			}
			callNmbr = callNmbr.replace('/', '');
      
      
        var callNmbr = lkup.makeCallNmbr(data['082a']);
        $('input[name=callNmbr1]').val(callNmbr);
        var cutter = lkup.makeCutter(data['100a'], data['245a']);
        $('input[name=callNmbr2]').val(cutter); // just for show, posting done in called routine
        break;
      case 'udc':
        var callNmbr = lkup.makeCallNmbr(data['080a']);
        $('input[name=callNmbr1]').val(callNmbr);
        $('input[name=callNmbr2]').val(data['080b']);
        break;
      */
    } // switch($this->_getCallNumberType)..
    
    $data['collectionCd'] = $this->_getDefaultCollection();
    $data['materialCd'] = $data['collectionCd'];
  }
  
  private function _getBiblio($post) {
    require_once(dirname(__FILE__) . "/../classes/Biblio.php");
    require_once(dirname(__FILE__) . "/../classes/BiblioField.php");
    
    $biblio = new Biblio();
    $biblio->setMaterialCd($post["materialCd"]);
    $biblio->setCollectionCd($post["collectionCd"]);
    $biblio->setCallNmbr1($post["callNmbr1"]);
    $biblio->setCallNmbr2($post["callNmbr2"]);
    $biblio->setCallNmbr3($post["callNmbr3"]);
    $biblio->setLastChangeUserid($_SESSION["userid"]);
    $biblio->setOpacFlg(true);
    unset($post['callNmbr1'], $post['callNmbr2'], $post['callNmbr3'], $post['collectionCd'], $post['materialCd']);
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
}


