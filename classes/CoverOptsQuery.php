<?php
class CoverOptsQuery extends Query {
  function getAWS() {
    $this->_query('SELECT * FROM cover_options', FALSE);
    return $this->_conn->fetchRow();
  }
  
  function setAWS($form) {
    $key = $form['coverOptsKey'];
    $secretKey = $form['coverOptsSecretKey'];
    $id = $form['coverOptsAccId'];
    
    $this->_query(
        $this->mkSQL("UPDATE cover_options SET aws_key=%Q,"
            . "aws_secret_key=%Q, aws_account_id=%Q", 
            $key, $secretKey, $id
        ),
        FALSE
    );
    
    return true;
  }
}
