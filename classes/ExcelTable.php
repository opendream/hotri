<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
require_once("../functions/inputFuncs.php");

class ExcelTable {
  var $_cols = array();
  var $_data = array();
  
  function escape($str) {
    if (strcspn($str, ",\"\r\n") != strlen($str)) {
      $str = '"'.str_replace('"', '""', $str).'"';
    }
    return $str;
  }
  function parameters($params) {
  }
  function columns($cols) {
    $this->_cols = array_merge($this->_cols, $cols);
  }
  function start() {
    $arr = array();
    foreach ($this->_cols as $col) {
      if (!isset($col['title']) or !$col['title']) {
        $col['title'] = $col['name'];
      }
      //$arr[] = $this->escape($col['title']);
      $arr[] = $col['title'];
    }
    $this->_data = $arr;
  }
  function row($row) {
    $arr = array();
    foreach ($this->_cols as $col) {
      //$arr[] = $this->escape($row[$col['name']]);
      $arr[] = $row[$col['name']];
    }
    $this->_data = $arr;
  }
  function end() {
  }
  
  function getData() {
    $row = $this->_data;
    return $row;
  }
}

?>
