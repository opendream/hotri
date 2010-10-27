<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
require_once("../classes/InstallQuery.php");

class UpgradeQuery extends InstallQuery {
  function UpgradeQuery() {
    # Call query constructor so database connection gets made
    $this->Query();
  }
  function insertBiblioFields($tag, $subFieldCd, 
                              $fromTablePrfx, $toTablePrfx,  $colName){
    $sql = "insert into ".$toTablePrfx."biblio_field"
          ."(bibid, fieldid, tag,   ind1_cd,ind2_cd,subfield_cd,     field_data) select "
          ." bibid, null,  ".$tag.",null,   null,'".$subFieldCd."',".$colName
          ." from ".$fromTablePrfx."biblio "
          ."where ".$colName." is not null";
    $this->exec($sql);
   }
   
   function copyDataToNewTable($tableName, $fromTablePrfx, $toTablePrfx, $sqlSelectConversion) {
        $sql = "delete from ".$toTablePrfx.$tableName;
        !$this->exec($sql);
        $conv = "(".implode(", ", array_keys($sqlSelectConversion)).") "
                . "select ".implode(", ", array_values($sqlSelectConversion));
        $sql = "insert into ".$toTablePrfx.$tableName." "
              .$conv
              ." from ".$fromTablePrfx.$tableName;
        $this->exec($sql);
   }
   
   function renamePrfxedTable($tableName, $fromTablePrfx, $toTablePrfx) {
     return $this->renameTable($fromTablePrfx.$tableName, $toTablePrfx.$tableName);
   }
  
  # Returns array($notices, $error).
  # On failure, $error is an Error and $notices should not be used.
  # On success, $error is NULL and $notices is an array of strings
  # notifying the user of upgrade changes.
  function performUpgrade_e($fromTablePrfx = DB_TABLENAME_PREFIX, $toTablePrfx = DB_TABLENAME_PREFIX) {
    # Each of these routines should update the given version to the next higher version.
    $upgrades = array(
      '0.3.0' => '_upgrade030_e',
      '0.4.0' => '_upgrade040_e',
      '0.5.2' => '_upgrade052_e',
      '0.6.0' => '_upgrade060_e',
    );
    $tmpPrfx = "obiblio_upgrade_";
    # FIXME - translate upgrade messages
    $locale = $this->getCurrentLocale($fromTablePrfx);

    $notices = array();
    # Do this first so new tables always have a prefix, if desired.
    if ($fromTablePrfx != $toTablePrfx) {
      $this->renameTables($fromTablePrfx, $toTablePrfx);
    }
    do {
      $version = $this->getCurrentDatabaseVersion($toTablePrfx);
      if ($version == OBIB_LATEST_DB_VERSION) {
        break;	# Done
      } elseif (isset($upgrades[$version])) {
        $func = $upgrades[$version];
        list($n, $error) = $this->$func($toTablePrfx, $tmpPrfx);
        if ($error) {
          return array(NULL, $error);
        }
        $notices = array_merge($notices, $n);
      } elseif (!$version) {
        $error = new Error("No existing OpenBiblio database, please perform a fresh install.");
        return array(NULL, $error);
      } else {
        $error = new Error('Unknown database version: '.$version.'.  No automatic upgrade routine available.');
        return array(NULL, $error);
      }
    } while (1);
    return array($notices, NULL);
  }
  # Individual upgrade functions
  # Each of these should upgrade the indicated database version by one version.
  # $prfx is the table prefix to be used by both the original and upgraded databases.
  # $tmpPrfx is a prefix which may be used for temporary tables.
  # Return value is the same as performUpgrade_e()
  
  /* Upgrade 0.3.0 to 0.4.0 */
  function _upgrade030_e($prfx, $tmpPrfx) {
    # 0.3.0 was English only
    $this->freshInstall('en', false, '0.4.0', $tmpPrfx);

    # marc data conversion
    $fields = array(
      'edition' => array(250, 'a'),
      'isbn_nmbr' => array(20, 'a'),
      'lccn_nmbr' => array(10, 'a'),
      'lc_call_nmbr' => array(50, 'a'),
      'lc_item_nmbr' => array(50, 'b'),
      'udc_nmbr' => array(82, 'a'),
      'udc_ed_nmbr' => array(82, '2'),
      'publication_loc' => array(260, 'a'),
      'publisher' => array(260, 'b'),
      'publication_dt' => array(260, 'c'),
      'summary' => array(520, 'a'),
      'pages' => array(300, 'a'),
      'physical_details' => array(300, 'b'),
      'dimensions' => array(300, 'c'),
      'accompanying' => array(300, 'e'),
      'price' => array(20, 'c'),
    );
    foreach ($fields as $fname => $marc) {
      $this->insertBiblioFields($marc[0], $marc[1], $prfx, $tmpPrfx, $fname);
    }
    
    # biblio table conversion
    $this->copyDataToNewTable("biblio", $prfx, $tmpPrfx,
                              array(
                                "bibid" => "bibid",
                                "create_dt" => "create_dt",
                                "last_change_dt" => "last_updated_dt",
                                //TODO: Currently using 1 for last_change_userid, get real id
                                "last_change_userid" => "1",
                                "material_cd" => "material_cd",
                                "collection_cd" => "collection_cd",
                                "call_nmbr1" => "call_nmbr",
                                "call_nmbr2" => "NULL",
                                "call_nmbr3" => "NULL",
                                "title" => "title",
                                "title_remainder" => "subtitle",
                                "responsibility_stmt" => "trim(concat(author,' ',add_author))",
                                "author" => "author",
                                "topic1" => "NULL",
                                "topic2" => "NULL",
                                "topic3" => "NULL",
                                "topic4" => "NULL",
                                "topic5" => "NULL",
                                "opac_flg" => "'Y'",
                              ));
   
    # biblio_status -> biblio_copy conversion
    $sql = "insert into ".$tmpPrfx."biblio_copy "
."(bibid,  copyid,copy_desc,barcode_nmbr,  status_cd,                status_begin_dt,                       due_back_dt,   mbrid) select"
." b.bibid,null,  null,     b.barcode_nmbr,ifnull(bs.status_cd,'in'),ifnull(bs.status_begin_dt,b.create_dt),bs.due_back_dt,bs.mbrid from "
          .$prfx."biblio as b "
          ."left join ".$prfx."biblio_status as bs on b.bibid=bs.bibid";
    $this->exec($sql);
    
    $sql = "update ".$tmpPrfx."biblio_copy set status_cd = 'hld' where status_cd = 'cll'";
    $this->exec($sql);
    
    $this->dropTable($prfx.'biblio');
    $this->dropTable($prfx.'biblio_copy');

    #collection_dm data conversion
    $this->copyDataToNewTable("collection_dm", $prfx, $tmpPrfx,
                              array(
                                "code" => "code",
                                "description" => "description",
                                "default_flg" => "default_flg",
                                "days_due_back" => "days_due_back",
                                "daily_late_fee" => "0.00",
                              ));
    
    $this->dropTable($prfx.'collection_dm');

    #member table conversion
    $this->copyDataToNewTable("member", $prfx, $tmpPrfx,
                              array(
                                "mbrid" => "mbrid",
                                "barcode_nmbr" => "barcode_nmbr",
                                "create_dt" => "create_dt",
                                "last_change_dt" => "sysdate()",
                                "last_change_userid" => "1",
                                "last_name" => "last_name",
                                "first_name" => "first_name",
                                "address1" => "address1",
                                "address2" => "address2",
                                "city" => "city",
                                "state" => "state",
                                "zip" => "zip",
                                "zip_ext" => "zip_ext",
                                "home_phone" => "home_phone",
                                "work_phone" => "work_phone",
                                "email" => "NULL",
                                "classification" => "classification",
                                "school_grade" => "school_grade",
                                "school_teacher" => "school_teacher",
                              ));

    $this->dropTable($prfx.'member');

    #staff table conversion
    $this->copyDataToNewTable("staff", 
                              $prfx, $tmpPrfx,
                              array(
                                "userid" => "userid",
                                "create_dt" => "create_dt",
                                "last_change_dt" => "last_updated_dt",
                                "last_change_userid" => "1",
                                "username" => "username",
                                "pwd" => "pwd",
                                "last_name" => "last_name",
                                "first_name" => "first_name",
                                "suspended_flg" => "suspended_flg",
                                "admin_flg" => "admin_flg",
                                "circ_flg" => "circ_flg",
                                "circ_mbr_flg" => "circ_flg",
                                "catalog_flg" => "catalog_flg",
                                "reports_flg" => "admin_flg",
                              ));
    
    $this->dropTable($prfx.'staff');

    #settings data conversion
    $this->copyDataToNewTable("settings", 
                              $prfx, $tmpPrfx,
                              array(
                                "library_name" => "library_name",
                                "library_image_url" => "library_image_url",
                                "use_image_flg" => "use_image_flg",
                                "library_hours" => "library_hours",
                                "library_phone" => "library_phone",
                                "library_url" => "library_url",
                                "opac_url" => "opac_url",
                                "session_timeout" => "session_timeout",
                                "items_per_page" => "items_per_page",
                                "version" => "'0.4.0'",
                                "themeid" => "1",
                                "purge_history_after_months" => "6",
                                "block_checkouts_when_fines_due" => "'Y'",
                                "locale" => "'en'",
                                "charset" => "'iso-8859-1'",
                                "html_lang_attr" => "NULL",
                              ));

    $this->dropTable($prfx.'settings');
    
    # moving tables that haven't changed in structure,
    # yet may have been modified by the user
    $this->renamePrfxedTable("material_type_dm", $prfx, $tmpPrfx);
    $this->renamePrfxedTable("theme", $prfx, $tmpPrfx);
    $this->renameTables($tmpPrfx, $prfx);
    $notices = array('Any existing hold requests have been forgotten.');
    return array($notices, NULL); # no error
  }
  /* Upgrade 0.4.0 to 0.5.2 */
  function _upgrade040_e($prfx, $tmpPrfx) {
    $settings = $this->exec('select * from '.$prfx.'settings ');
    if (is_dir('../locale/'.$settings[0]['locale'].'/sql/0.5.2/domain')) {
      $domainDir = '../locale/'.$settings[0]['locale'].'/sql/0.5.2/domain';
    } else {
      $domainDir = '../locale/en/sql/0.5.2/domain';
    }
    $this->exec('alter table '.$prfx.'staff modify pwd char(32)');
    $this->exec('update '.$prfx.'staff set pwd=md5(lower(username))');
    $this->exec('alter table '.$prfx.'biblio_copy '
                . 'add renewal_count tinyint unsigned not null default 0 '
                . 'after mbrid ');
    $this->exec('alter table '.$prfx.'biblio_status_hist '
                . 'add renewal_count tinyint unsigned not null default 0 '
                . 'after mbrid ');
    $this->executeSqlFile('../install/0.5.2/sql/checkout_privs.sql', $prfx);
    $this->exec('insert into '.$prfx.'checkout_privs '
                . 'select mat.code material_cd, 1 classification, '
                . 'mat.adult_checkout_limit checkout_limit, '
                . '0 renewal_limit '
                . 'from material_type_dm mat ');
    $this->exec('insert into '.$prfx.'checkout_privs '
                . 'select mat.code material_cd, 2 classification, '
                . 'mat.juvenile_checkout_limit checkout_limit, '
                . '0 renewal_limit '
                . 'from material_type_dm mat ');
    $this->exec('alter table '.$prfx.'material_type_dm '
                . 'drop adult_checkout_limit, '
                . 'drop juvenile_checkout_limit ');
    $this->executeSqlFile('../install/0.5.2/sql/material_usmarc_xref.sql', $prfx);
    $this->exec("update ".$prfx."mbr_classify_dm set code='1' where code='a' ");
    $this->exec("update ".$prfx."mbr_classify_dm set code='2' where code='j' ");
    $this->exec('alter table '.$prfx.'mbr_classify_dm '
                . 'modify code smallint auto_increment, '
                . 'add max_fines decimal(4,2) not null after default_flg ');
    $this->executeSqlFile('../install/0.5.2/sql/member_fields.sql', $prfx);
    $this->executeSqlFile('../install/0.5.2/sql/member_fields_dm.sql', $prfx);
    $this->exec('insert '.$prfx.'member_fields '
                . "select mbrid, 'schoolGrade' code, school_grade data "
                . "from member where school_grade is not null "
                . "and school_grade <> '' ");
    $this->exec('insert '.$prfx.'member_fields '
                . "select mbrid, 'schoolTeacher' code, school_teacher data "
                . "from member where school_teacher is not null "
                . "and school_teacher <> '' ");
    $this->executeSqlFile($domainDir.'/member_fields_dm.sql', $prfx);
    $this->exec("update ".$prfx."member set classification=1 where classification='a' ");
    $this->exec("update ".$prfx."member set classification=2 where classification='j' ");
    $this->exec('alter table '.$prfx.'member '
                . 'add address text null after first_name, '
                . 'modify classification smallint not null ');
    # What a mess
    $this->exec('update '.$prfx.'member set address= '
                . "concat_ws('\n', nullif(address1, ''), nullif(address2, ''), "
                . "concat_ws('', city, concat(', ', nullif(state, '')), "
                . "concat(' ', nullif(zip, ''), ifnull(concat('-', zip_ext), '')))) ");
    $this->exec('alter table '.$prfx.'member '
                . 'drop address1, drop address2, '
                . 'drop city, drop state, drop zip, drop zip_ext, '
                . 'drop school_grade, drop school_teacher ');
    $this->exec('alter table '.$prfx.'settings '
                . 'add hold_max_days smallint not null '
                . 'after block_checkouts_when_fines_due ');
    $this->exec('update '.$prfx.'settings '
                . 'set hold_max_days=14 ');
    $this->exec('drop table '.$prfx.'state_dm ');

    $this->exec('update '.$prfx.'settings set version=\'0.5.2\'');
    $notices = array('All staff passwords have been reset to be equal to the corresponding usernames.');
    return array($notices, NULL); # no error
  }
  /* Upgrade 0.5.2 to 0.6.0 */
  function _upgrade052_e($prfx, $tmpPrfx) {
    $this->exec('alter table '.$prfx.'biblio_copy '
                . 'add create_dt datetime not null '
                . 'after copyid ');
    $this->exec('update biblio_copy bc, biblio b '
                . 'set bc.create_dt=b.create_dt '
                . 'where b.bibid=bc.bibid ');
    $this->exec("update settings set version='0.6.0'");
    $notices = array();
    return array($notices, NULL);
  }
  /* Upgrade 0.6.0 to 0.6.0_hotri1.0 */
  function _upgrade060_e($prfx, $tmpPrfx) {
    // Create directories for book cover / cover lookup
    $cover_path = @mkdir("../" . COVER_PATH, 0777, TRUE);
    $tmp_path = @mkdir("../" . COVER_PATH_TMP, 0777, TRUE);
    $notices = array();
    $error = '';
    if ($cover_path) {
      $notices[] = 'Create book cover directory successfully.';
    }
    else if (is_dir('../' . COVER_PATH)) {
      if (is_writable('../' . COVER_PATH)) {
        $notices[] = 'Book cover directory already exists & work properly.';
      }
      else {
        $force_chmod = @chmod('../' . COVER_PATH, 0777);
        if ($force_chmod) {
          $notices[] = 'Book cover directory is exists, force read/write access to exists one.';
        }
        else {
          $error .= 'Could not change access to exist cover directory! Please change ' . COVER_PATH . ' directory permission (chmod) to full access (777) manually.<br />';
        }
      }
    }
    else {
      $error .= 'Could not create book cover directory! Please create new ' . COVER_PATH . ' directory & change permission (chmod) to full access (777) manually.<br />';
    }
    
    if ($tmp_path) {
      $notices[] = 'Create temporary cover lookup directory successfully.';
    }
    else if (is_dir('../' . COVER_PATH_TMP)) {
      if (is_writable('../' . COVER_PATH_TMP)) {
        $notices[] = 'Temporay cover lookup directory already exists & work properly.';
      }
      else {
        $force_chmod = @chmod('../' . COVER_PATH_TMP, 0777);
        if ($force_chmod) {
          $notices[] = 'Temporary cover lookup directory is exists, force read/write access to exists one.';
        }
        else {
          $error .= 'Could not change access to exist temporary cover lookup directory! Please change ' . COVER_PATH_TMP . ' directory permission (chmod) to full access (777) manually.<br />';
        }
      }
    }
    else {
      $error .= 'Could not create temporary cover lookup directory! Please create new ' . COVER_PATH_TMP . ' directory & change permission (chmod) to full access (777) manually.<br />';
    }
    
    if (!empty($error)) {
      return array(NULL, new Error($error));
    }
    
    $updateDir = '../install/hotri/1.0';
    $this->executeSqlFilesInDir($updateDir, $tablePrfx);
    $this->exec("update settings set version='hotri1.0'");
    $notices = array();
    return array($notices, NULL);
  }
  
  function executeSqlFilesInDir($dir, $tablePrfx = "") {
    if (is_dir($dir)) {
      if ($dh = opendir($dir)) {
        while (($filename = readdir($dh)) !== false) {
          if(preg_match('/\\.sql$/', $filename)) {
            $this->executeSqlFile($dir.'/'.$filename, $tablePrfx);
          }
        }
        closedir($dh);
      }
    }
  }

  /**********************************************************************************
   * Function to read through an sql file executing SQL only when ";" is encountered
   **********************************************************************************/
  function executeSqlFile($filename, $tablePrfx = DB_TABLENAME_PREFIX) {
    $fp = fopen($filename, "r");
    # show error if file could not be opened
    if ($fp == false) {
      Fatal::error("Error reading file: ".H($filename));
    } else {
      $sqlStmt = "";
      while (!feof ($fp)) {
        $char = fgetc($fp);
        if ($char == ";") {
          //replace table prefix, we're doing it here as the install script may
          //want to override the required prefix (eg. during upgrade / conversion 
          //process)
          $sql = str_replace("%prfx%",$tablePrfx,$sqlStmt);
          $root_path = "http://" . $_SERVER['HTTP_HOST'] . dirname(dirname($_SERVER['SCRIPT_NAME']));
          if (substr($root_path, -1) == '/') {
            $root_path = substr($root_path, 0, -1);
          }
          $sql = str_replace('%domain%', $root_path . "/cron/lookup.php", $sql);
          $this->exec($sql);
          $sqlStmt = "";
        } else {
          $sqlStmt .= $char;
        }
      }
      fclose($fp);
    }
  }
}

?>
