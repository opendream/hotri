<?php

function get_active_theme() {
  $theme_name = "";

  // Get a name of the active theme.
  $sql = "SELECT t.theme_name FROM theme t JOIN settings s WHERE t.themeid = s.themeid";
  $q = new Query(); 
  $q->connect();
  $rows = $q->exec($sql);
  if (count($rows) > 0) {
    $theme_name = $rows[0]["theme_name"];
  }
  $q->close();

  // Check theme directory existence.
  $theme = "../themes/". $theme_name;
  if (file_exists($theme ."/style.css")) {
    return $theme_name;
  } else {
    return "";
  }
}
