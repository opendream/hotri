<?php
require_once("../shared/common.php");
require_once("../functions/searchFuncs.php");
require_once('Query.php');

class BiblioApiQuery extends Query {
  function search($keyword, $start = 0, $limit = 10, $type = 'title') {
    $words = explodeQuoted($keyword);
    $cond = '';
    if ($type == 'author') 
      $sortBy = 'author';
    else 
      $sortBy = 'title';

    if ($type == 'author') {
      foreach ($words as $w) 
        $cond .= "author LIKE '%$w%' OR ";
    }
    else if ($type == 'subject') {
      foreach ($words as $w) 
        $cond .= "topic1 LIKE '%$w%' OR topic2 LIKE '%$w%' OR topic3 LIKE '%$w%' OR topic4 LIKE '%$w%' OR topic5 LIKE '%$w%' OR ";
    }
    else { // Others are default search by title   
      foreach ($words as $w) {
        $cond .= "title LIKE '%{$w}%' OR title_remainder LIKE '%{$w}%' OR ";
      }
    }
    
    $q = "FROM biblio";
    $joined = 
      "LEFT JOIN collection_dm c ON collection_cd=c.code
      LEFT JOIN material_type_dm m ON material_cd=m.code 
      LEFT JOIN biblio_field f ON biblio.bibid=f.bibid AND tag=902 AND subfield_cd='a'";
    $where = "WHERE " .
      substr($cond, 0, -4) . " ORDER BY " . mysql_real_escape_string($sortBy);

    $counter = $this->_query("SELECT count(*) c $q $where", false);
    $row = $this->_conn->fetchRow();
    $result['rows'] = $row[c];
    $field = "f.field_data cover, biblio.bibid id, title, author, CONCAT(call_nmbr1, call_nmbr2, call_nmbr3) call_no, 
      c.description collection, m.description material";
    $handler = $this->_query("SELECT $field $q $joined $where LIMIT " . (0 + $start) . "," . (0 + $limit), false);
    //print_r("SELECT $field $q $joined $where LIMIT " . (0 + $start) . "," . (0 + $limit));
    while ($row = $this->_conn->fetchRow()) {
      $result['data'][] = $row;
    }
    //echo "<pre>" . print_r($result, true) . "</pre>";
    
    return serialize($result);
  }

  function getBiblio($id) {
    $id = 0 + $id;
    $field = "biblio.bibid id, title, title_remainder subtitle, responsibility_stmt responsibility, 
      author, CONCAT(call_nmbr1, call_nmbr2, call_nmbr3) call_no, 
      c.description collection, m.description material";
    $joined = 
      "LEFT JOIN collection_dm c ON collection_cd=c.code 
      LEFT JOIN material_type_dm m ON material_cd=m.code";
    $handler = $this->_query("SELECT $field FROM biblio $joined WHERE bibid=$id", false);
    $result = $this->_conn->fetchRow();

    if (!$result) return '';

    // MARC fields
    $handler = $this->_query("SELECT f.tag,f.subfield_cd, CONCAT(tdm.description, ' (', sdm.description, ')') description, field_data 
      FROM biblio_field f
      LEFT JOIN usmarc_tag_dm tdm ON tdm.tag=f.tag 
      LEFT JOIN usmarc_subfield_dm sdm ON sdm.tag=f.tag AND sdm.subfield_cd=f.subfield_cd 
      WHERE bibid=$id", false);
    while ($row = $this->_conn->fetchRow()) {
      if ($row['tag']==902 && $row['subfield_cd']='a') 
        $result['cover'] = $row['field_data'];
      else 
        $result['marc'][$row['tag'] . $row['subfield_cd']] = 
          array('label'=>$row['description'], 'value'=>$row['field_data']);
    }

    // Copies
    $handler = $this->_query("SELECT 
      barcode_nmbr barcode, copy_desc description, 
      s.description status, 
      status_begin_dt begin_date, due_back_dt due_date 
      FROM biblio_copy 
      LEFT JOIN biblio_status_dm s ON biblio_copy.status_cd=s.code 
      WHERE bibid=$id", false);
    while ($row = $this->_conn->fetchRow()) {
      $result['copies'][] = $row; 
    }

    //echo "<pre>" . print_r($result, true) . "</pre>";
    return serialize($result);
  }
}
