<?php
class CronQuery extends Query {
  function getUrlPath() {
    $this->_query("SELECT cron_url FROM lookup_settings LIMIT 1", false);
    $s = $this->_conn->fetchRow();
    return $s['cron_url'];
  }
}
