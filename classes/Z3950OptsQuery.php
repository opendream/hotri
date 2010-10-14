<?php
class Z3950OptsQuery extends Query {
  function getOptions() {
    $this->_query('SELECT * FROM lookup_settings', FALSE);
    $options = $this->_conn->fetchRow();
    unset($options['cron_url']);
    return $options;
  }
  
  function setOptions($form) {
    // Defaults
    $checkboxes = array('keep_dashes', 'auto_dewey', 'auto_cutter', 'auto_collect');
    foreach ($checkboxes as $key) {
      $form[$key] = $form[$key] ? 'y' : 'n';
    }
    
    $options = $this->getOptions();
    $diff = array_diff_key($options, $form);
    if (count($diff) != 0) {
      return FALSE;
    }
    
    $fields = array();
    $vals = array();
    foreach ($form as $name => $val) {  
      $fields[] = "$name='" . mysql_real_escape_string($val, $this->_link) . "'";
    }
    
    $query = "UPDATE lookup_settings SET " . implode(',', $fields);
    $this->_query($query, FALSE);
    
    return TRUE;
  }
}
