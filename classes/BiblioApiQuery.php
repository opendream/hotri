<?php
require_once("../shared/common.php");
require_once("../functions/searchFuncs.php");
require_once('Query.php');

class BiblioApiQuery extends Query {
  function search($keyword, $start = 0, $limit = 10, $type = 'title') {
    $words = explodeQuoted($keyword, $extended = true);
    $cond = '';

    // Decode Arithmetric Clause
    foreach ($words as $key=>$w) {
      $words[$key] = str_replace('%space_bar%', ' ', $w);
    }
    if ($type == 'author') 
      $sortBy = 'author';
    else 
      $sortBy = 'title';

    if ($type == 'author') {
      $field_cond = array('author');
    }
    else if ($type == 'subject') {
      $field_cond = array('topic1', 'topic2', 'topic3', 'topic4', 'topic5');
    }
    else { // Otherwise set default search by title
      $field_cond = array('title', 'title_remainder');
    }

    $exclusion = '';
    
    foreach ($words as $w) {
      
      if (strpos($w, '%') !== false) {
        $buffer = '';
        $endp = -1;
        while (($p = strpos($w, '%', $endp + 1)) !== false) {
          $endp = strpos($w, '%', $p + 1);
          
          if ($endp === false) break;

          $pre_word = substr($w, 0, $p);
          $word_end = strpos($w, '%', $endp + 1);
          if ($word_end === false) 
            $post_word = substr($w, $endp + 1);
          else 
            $post_word = substr($w, $endp + 1, $word_end  - ($endp + 1));

          // c AND d OR e NOT f NOT g [c%and%d%or%e%not%f%not%g]
          // Running left-to-right actions.
          // ((field LIKE c AND field LIKE d) OR field LIKE e) AND field NOT LIKE f AND field NOT LIKE f

          // a OR b OR c AND d NOT e AND f OR g
          // (field LIKE a OR field LIKE b)
          // ([1] OR field LIKE c)
          // (((field LIKE a OR field LIKE b) OR field LIKE c) AND field LIKE d) AND 
          // Step:
          //   - buffer conditions ($buffer)
          //   - $buffer = "($buffer [CONDITION] field LIKE $post_word)";
          
          switch ($condition = strtoupper(substr($w, $p+1, $endp - ($p + 1)))) {
            case 'AND':
            case 'OR':
            case 'NOT':
              break;
            default:
              $condition = 'OR';
          }
          if ($condition == 'NOT') {
            if (empty($exclusion)) {
              // Pre word in NOT clause should be default clause.
              if (!empty($pre_word)) {
                if (empty($buffer)) 
                  $buffer = "(__FIELD__ LIKE '%$pre_word%')";
                else 
                  $buffer = "(__FIELD__ LIKE '%$pre_word%' OR ($buffer))";
              }
            }
            $exclusion .= '(';
            foreach ($field_cond as $f) {
              $exclusion .= "$f NOT LIKE '%$post_word%' AND ";
            }
            $exclusion = substr($exclusion, 0, -4) . ") AND ";
          }
          else {
            if (empty($buffer)) 
              $buffer = "(__FIELD__ LIKE '%$pre_word%' $condition __FIELD__ LIKE '%$post_word%')";
            else 
              $buffer = "($buffer $condition __FIELD__ LIKE '%$post_word%')";
          }
        }
        if (!empty($buffer)) {
          foreach ($field_cond as $f) {
            $cond .= str_replace('__FIELD__', $f, $buffer) . " OR ";
          }
        }
      }
      else {
        // Decode some characters.
        $w = str_replace('[percent_mrk]', '%', $w);
        $w = str_replace("%space_bar%", " ", $w);

        foreach ($field_cond as $f) {
          $cond .= "$f LIKE '%$w%' OR ";
        }
      }
    }
    
    $cond = substr($cond, 0, -4);
    if (!empty($exclusion)) {
      if (empty($cond)) 
        $cond = substr($exclusion, 0, -5);
      else 
        $cond = "($cond) AND " . substr($exclusion, 0, -5);
    }
    
    // Sample: a b OR "c d" e AND f NOT g
    // Data: [a][bORc d] [eANDfNOTg]
    // Current: 
    // field LIKE a OR (field LIKE b OR field LIKE "c d") OR ((field LIKE e AND field LIKE f) AND field NOT LIKE g)
    // Correction:
    // (field LIKE a OR (field LIKE b OR field LIKE "c d") OR (field LIKE e AND field LIKE f) AND field NOT LIKE g
    // $cond = "($cond) AND $exclusion"; 

    /*
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
    */
    
    $q = "FROM biblio";
    $joined = 
      "LEFT JOIN collection_dm c ON collection_cd=c.code
      LEFT JOIN material_type_dm m ON material_cd=m.code 
      LEFT JOIN biblio_field f ON biblio.bibid=f.bibid AND tag=902 AND subfield_cd='a'";
    $where = "WHERE " .
      $cond . " ORDER BY " . mysql_real_escape_string($sortBy);

    //return "SELECT count(*) c $q $where";

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
