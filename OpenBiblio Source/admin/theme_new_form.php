<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  session_cache_limiter(null);

  $tab = "admin";
  $nav = "themes";
  $headerWording="Add New";
  $focus_form_name = "newthemeform";
  $focus_form_field = "themeName";

  require_once("../functions/inputFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../shared/get_form_vars.php");
  require_once("../shared/header.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  
  #****************************************************************************
  #*  Checking for query string flag to read data from database.
  #*  This is only used when copying an existing theme.
  #****************************************************************************
  if (isset($_GET["themeid"])){
    unset($_SESSION["postVars"]);
    unset($_SESSION["pageErrors"]);

    $themeid = $_GET["themeid"];
    include_once("../classes/Theme.php");
    include_once("../classes/ThemeQuery.php");
    include_once("../functions/errorFuncs.php");
    $themeQ = new ThemeQuery();
    $themeQ->connect();
    if ($themeQ->errorOccurred()) {
      $themeQ->close();
      displayErrorPage($themeQ);
    }
    $themeQ->execSelect($themeid);
    if ($themeQ->errorOccurred()) {
      $themeQ->close();
      displayErrorPage($themeQ);
    }
    $theme = $themeQ->fetchTheme();

    $postVars["titleBg"] = $theme->getTitleBg();
    $postVars["titleFontFace"] = $theme->getTitleFontFace();
    $postVars["titleFontSize"] = $theme->getTitleFontSize();
    if ($theme->getTitleFontBold()) {  
      $postVars["titleFontBold"] = "CHECKED";
    } else {
      $postVars["titleFontBold"] = "";
    }
    $postVars["titleFontColor"] = $theme->getTitleFontColor();
    $postVars["titleAlign"] = $theme->getTitleAlign();

    $postVars["primaryBg"] = $theme->getPrimaryBg();
    $postVars["primaryFontFace"] = $theme->getPrimaryFontFace();
    $postVars["primaryFontSize"] = $theme->getPrimaryFontSize();
    $postVars["primaryFontColor"] = $theme->getPrimaryFontColor();
    $postVars["primaryLinkColor"] = $theme->getPrimaryLinkColor();
    $postVars["primaryErrorColor"] = $theme->getPrimaryErrorColor();

    $postVars["alt1Bg"] = $theme->getAlt1Bg();
    $postVars["alt1FontFace"] = $theme->getAlt1FontFace();
    $postVars["alt1FontSize"] = $theme->getAlt1FontSize();
    $postVars["alt1FontColor"] = $theme->getAlt1FontColor();
    $postVars["alt1LinkColor"] = $theme->getAlt1LinkColor();

    $postVars["alt2Bg"] = $theme->getAlt2Bg();
    $postVars["alt2FontFace"] = $theme->getAlt2FontFace();
    $postVars["alt2FontSize"] = $theme->getAlt2FontSize();
    $postVars["alt2FontColor"] = $theme->getAlt2FontColor();
    $postVars["alt2LinkColor"] = $theme->getAlt2LinkColor();
    if ($theme->getAlt2FontBold()) {  
      $postVars["alt2FontBold"] = "CHECKED";
    } else {
      $postVars["alt2FontBold"] = "";
    }

    $postVars["borderColor"] = $theme->getBorderColor();
    $postVars["borderWidth"] = $theme->getBorderWidth();
    $postVars["tablePadding"] = $theme->getTablePadding();

    $themeQ->close();
  }


?>

<script language="JavaScript" type="text/javascript">
<!--
function previewTheme() {
  var SecondaryWin;
  SecondaryWin = window.open('',"secondary","resizable=yes,scrollbars=yes,width=535,height=400");
  document.newthemeform.action = "../admin/theme_preview.php";
  document.newthemeform.target = 'secondary';
  document.newthemeform.submit();
}
function editTheme() {
  document.newthemeform.action = "../admin/theme_new.php";
  document.newthemeform.target = '';
  document.newthemeform.submit();
}
-->
</script>


<a href="javascript:previewTheme()"><?php echo $loc->getText("adminTheme_Preview"); ?></a><br /><br />

<form name="newthemeform" method="POST" action="../admin/theme_new.php">
<?php include("../admin/theme_fields.php"); ?>
<?php include("../shared/footer.php"); ?>
