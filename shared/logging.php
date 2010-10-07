<?php

class Logging {
  var $filename = "";

  function __construct($filename) {
    $this->filename = $filename;
  }

  function debug($msg) {
    $msg = "[". date('Y-m-d H:i:s') ."] ". $msg ."\n\n";
    $fp = fopen($this->filename, "a");
    fwrite($fp, $msg);
    fclose($fp);
  }

  function clear() {
    $fp = fopen($this->filename, "w");
    fwrite($fp, "");
    fclose($fp);
  }
}
