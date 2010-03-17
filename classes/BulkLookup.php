<?php

require_once("../shared/common.php");
require_once("../lookup2/LookupHostsQuery.php");

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
    $isbnList = array();
    while (!feof($fp)) {
      $line = trim(fgets($fp));
      $isbn = $this->verifyISBN($line);
      if (strlen($isbn) == 10) {
        $isbnList[$isbn]++;
      }
    }

    // 
    $bl->queue($isbnList);
    
    // Enable cron.
    if (ereg('OFF', file_get_contents("../cron/cronrun.txt"))) 
      file_put_contents("../cron/cronrun.txt", 'ON');
    $bl->clearDoneQueue();
  }
  
  function search($isbnList) {
    $bl = new BulkLookupQuery();

    if (!is_array($isbnList)) return false;
    
    foreach ($isbnList as $one) {
      // Check existing ISBN.
      $existBibid = $bl->getExistBiblio($one['isbn']);
      if ($existBibid > 0) {
        for ($i = 0; $i < $one['amount']; $i++)
          $bl->addCopy($existBibid);
        $bl->setLookupStatus('copy', $one['isbn']);
        continue;
      }
    
      $list = $this->_getLookupServers();
      $retry = false;
      if (!is_array($list) || count($list) < 1) {
        $bl->setLookupStatus('manual', $one['isbn'], $one['amount']);
      }
        
      foreach ($list as $server) {
        $result = $this->_getLookupResult($server, $one['isbn']);
        if (!$result || isset($result['error'])) {
          if (ereg('not connect', $result['error']) || ereg('response error', $result['error'])) {
            $retry = true;
          }
          continue;
        }
        $this->_addResult(array('isbn'=>$one['isbn'], 'data'=>$result, 'amount'=>$one['amount']));
        break;
      }
      
      if (isset($result['error'])) {
        $this->_addResult(array('isbn'=>$one['isbn'], 'data'=>NULL));
        
        if ($retry) 
          $bl->setLookupStatus('retry', $one['isbn']);
        else {
          $bl->setLookupStatus('manual', $one['isbn'], $one['amount']);
        }
      }
    }
    $bl->saveResults($this->_results);
  }
  
  function verifyISBN($isbn,$keepDashes = false) {
			## remove any "-" char user may have entered
			if (!$keepDashes) {
				$isbn = str_replace("-", "", $isbn);
			}
			## remove any space char user may have entered
			$isbn = str_replace(" ", "", $isbn);

			// When isbn is not number (3 first characters), return false
			if (!is_numeric(substr($isbn, 0, 9)))
			  return false;

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
    require_once("../lookup2/lookupYazFunc.php");
    return extract_marc_fields(yaz_record($conn, 1, 'array'), true, 1, 1);
  }
  
  private function _addResult($result) {
    if (!is_array($result) || !isset($result['isbn'])) return false;

    if (empty($result['amount']))
      $result['amount'] = 1;
    else
      $result['amount'] = 0 + $result['amount'];
    
    $this->_results[$result['isbn']] = array('data'=>$result['data'], 'amount'=>$result['amount']);
    
    return true;
  }
  
}

class BulkLookupQuery extends Query {
  function queue($isbn, $amount=1, $mode = 'default') {
    // Manual mode need one isbn (string).
    if ($mode == 'manual') {
      $this->_query("SELECT qmid FROM lookup_manual WHERE isbn = '$isbn'", false);
      $data = $this->fetch();
      if ($data['qmid'] > 0 && 0 + $amount > 0) {
        $this->_query("UPDATE lookup_manual SET hits=hits+" . (0 + $amount) . " WHERE qmid={$data['qmid']}", false);
      }
      else 
        $this->_query("INSERT INTO lookup_manual (isbn, hits) VALUES ('$isbn', " . (0 + $amount) . ")", false);
      
    }
    // Default mode need isbn list (array : key = ISBN, value = amount).
    else {
      if (!is_array($isbn)) return false;

      foreach ($isbn as $key => $amount) {
        if (0 + $amount > 0) {
          $this->_query("INSERT INTO lookup_queue (isbn, amount) VALUES ('$key', $amount)", false);
        }
      } 
    }
  }

  function getManualList($limit = 100) {
    $limit = 0 + $limit;
    $this->_query("SELECT * FROM lookup_manual WHERE hits != 0 LIMIT $limit", false);
  }
  
  function getQueue($status = 'queue', $limit = 100) {
    $limit = 0 + $limit;
    switch ($status) {
      case 'manual':
      case 'queue':
      case 'publish':
      case 'copy':
        $cond = "WHERE status='$status'";
        break;
      
      default:
        $cond = '';
    }
    $this->_query("SELECT * FROM lookup_queue $cond LIMIT $limit", false);
    
  }

  function clearDoneQueue($type = 'default') {
    if ($type == 'manual_list') {
      return $this->_query("DELETE FROM lookup_manual WHERE hits=0", false);
    }
    else {
      return $this->_query("DELETE FROM lookup_queue WHERE status!='queue'", false);
    }
  }
  
  function fetch() {
    return $this->_conn->fetchRow();
  }
  
  function countQueue($status = 'queue') {
    switch ($status) {
      case 'manual':  
      case 'queue':
      case 'publish':    
      case 'copy':
        $cond = "WHERE status='$status'";
        break;

      case 'manual_list':
        $this->_query("SELECT COUNT(*) AS c FROM lookup_manual WHERE hits=0", false);
        $res = $this->fetch();
        return $res[c];
      
      default:
        $cond = '';
      
    }
    $this->_query("SELECT COUNT(*) AS c FROM lookup_queue $cond", false);
    
    $res = $this->fetch();
    return $res[c];
  }
  
  function setLookupStatus($status, $isbn, $amount = 1) {
    if (0 + $isbn < 1) return false;
    switch ($status) {
      case 'manual':
        $this->queue($isbn, 0 + $amount, 'manual');
      case 'publish':
      case 'queue':
      case 'copy':
        $this->_query("UPDATE lookup_queue SET status='$status' WHERE isbn='$isbn' AND status='queue' LIMIT 1", false);
        break;
      case 'retry':
        $this->_query("UPDATE lookup_queue SET tries=tries+1 WHERE isbn='$isbn' AND status='queue' LIMIT 1", false);
        break;
    }
  }
  
  function saveResults(&$results) {
    if (!is_array($results)) return false;
    foreach ($results as $isbn=>$info) {
      if (isset($info['data'])) {
        $this->_formatResults($info['data']);
        $bib = $this->_getBiblio($info['data']);
        $results[$isbn]['bibid'] = 0 + $this->_insertBiblio($bib);
        if ($results[$isbn]['bibid'] > 0) {
          $amount = 0 + $info['amount'];
          if ($amount < 1) $amount = 1;

          for ($i = 0; $i < $amount; $i++) {
            $this->addCopy($results[$isbn]['bibid']);
          }
          
          // Cover lookup
          require_once("BiblioCoverQuery.php");
          $cq = new BiblioCoverQuery();
          $img_path = $cq->lookup($isbn);
          if ($img_path) {
            if($cq->save($img_path, $results[$isbn]['bibid']))
              $this->setLookupStatus('cover', $isbn);
            else
              $this->setLookupStatus('publish', $isbn);
          }
          else
            $this->setLookupStatus('publish', $isbn);
        }
      }
    }
  }

  function getExistBiblio($isbn) {
    $isbn = mysql_escape_string($isbn);
    if (strlen($isbn) != 10) return 0;

    $this->_query("SELECT bibid FROM biblio_field WHERE tag=20 AND field_data='$isbn' LIMIT 1", false); // 020 = ISBN
    $data = $this->fetch();
    return 0 + $data['bibid'];
  }

  function clearManualItem($isbn, $hits) {
    $hits = 0 + $hits;
    $isbn = mysql_escape_string($isbn);
    if (strlen($isbn) != 10) return 0;

    $this->_query("UPDATE lookup_manual SET hits=hits-$hits WHERE isbn='$isbn' LIMIT 1", false); // 020 = ISBN
  }

  function removeManualItem($isbn) {
    $isbn = mysql_escape_string($isbn);
    if (strlen($isbn) != 10) return 0;
    $this->_query("DELETE FROM lookup_manual WHERE isbn='$isbn' LIMIT 1", false);
  }
  
  function addCopy($bibid) {
    $bibid = 0 + $bibid;
    if ($bibid < 1) return false;
    
    require_once("BiblioCopyQuery.php");
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
    require_once("BiblioQuery.php");
    
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
    require_once("Biblio.php");
    require_once("BiblioField.php");
    
    $biblio = new Biblio();
    $biblio->setMaterialCd($post["materialCd"]);
    $biblio->setCollectionCd($post["collectionCd"]);
    $biblio->setCallNmbr1($post["callNmbr1"]);
    $biblio->setCallNmbr2($post["callNmbr2"]);
    $biblio->setCallNmbr3($post["callNmbr3"]);
    $biblio->setLastChangeUserid($_SESSION["userid"]);
    $biblio->setOpacFlg(true);
    unset($post['callNmbr1'], $post['callNmbr2'], $post['callNmbr3'], $post['collectionCd'], $post['materialCd']);
    $post['020a'] = BulkLookup::verifyISBN($post['020a']);
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


