<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  session_cache_limiter(null);

  $tab = "admin";
  $nav = "z3950_opts";
  $focus_form_name = "z3950optsform";
  $focus_form_field = "protocol";

  require_once("../functions/inputFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../shared/header.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  
  // Implementation for create dropdown options
  function getSelection($name, $options, $postVars, $hasLabel = TRUE) {
    if (!is_array($options)) {
      return false;
    }
    
    $selections = '<select id="' . $name . '" name="' . $name . '">' . "\n";
    foreach ($options as $label => $val) {
      $selections .= '  <option value="' . $val . '"';
      
      // No label? use value instead
      if (!$hasLabel) {
        $label = $val;
      }
      
      // Set defaults to pre-configure settings
      if ($postVars[$name] == $val) {
        $selections .= ' selected="selected"';
      }
      
      $selections .= ">$label</option>\n";
      
    }
    
    return $selections . "</select>\n";
  }
  
  function getCheckbox($name, $postVars, $value = 'y') {
    $checkbox = '<input type="checkbox" ';
    $checkbox .= 'id="' . $name . '" name="' . $name . '" ';
    $checkbox .= 'value="' . $value . '"';
    if ($postVars[$name] == $value) {
      $checkbox .= ' checked="checked"';
    }
    
    return $checkbox . " />\n";
  }

  // Load cover options
  require_once('../classes/Z3950OptsQuery.php');
  $opts = new Z3950OptsQuery();

  if ($_POST) {
    $opts->setOptions($_POST);
?>
<font class="error">Data has been updated.</font>
<?php
  }
  $form = $opts->getOptions();
  if (!is_array($postVars)) {
    $postVars = array();
  }
  $postVars = array_merge($form, $postVars);
?>
<form name="<?php echo $focus_form_name; ?>" method="POST" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>">
<table class="primary">
	<tbody>
  <tr>
    <th colspan="2" nowrap="yes" align="left">
      <?php echo $loc->getText("lookup_optsSettings"); ?>
    </th>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <label for="protocol"><?php echo $loc->getText("lookup_optsProtocol"); ?></label>
    </td>
    <td valign="top" class="primary">
      <?php
        $options = array(' ', 'YAZ', 'SRU');
        echo getSelection('protocol', $options, $postVars, FALSE);
      ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <label for="max_hits"><?php echo $loc->getText("lookup_optsMaxHits"); ?></label>
    </td>
    <td valign="top" class="primary">
      <?php printMyInputText("max_hits",10,10,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <label for="keep_dashes"><?php echo $loc->getText("lookup_optsKeepDashes"); ?></label>
    </td>
    <td valign="top" class="primary">
      <?php
      echo getCheckbox('keep_dashes', $postVars);
      ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <label for="callNmbr_type"><?php echo $loc->getText("lookup_optsCallNmbrType"); ?></label>
    </td>
    <td valign="top" class="primary">
      <?php
        $options = array(' ', 'LoC', 'Dew', 'UDC', 'local');
        echo getSelection('callNmbr_type', $options, $postVars, FALSE);
      ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <label for="auto_dewey"><?php echo $loc->getText("lookup_optsAutoDewey"); ?></label>
    </td>
    <td valign="top" class="primary">
      <?php
      echo getCheckbox('auto_dewey', $postVars);
      ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <label for="default_dewey"><?php echo $loc->getText("lookup_optsDefaultDewey"); ?></label>
    </td>
    <td valign="top" class="primary">
      <?php printMyInputText("default_dewey",10,10,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <label for="auto_cutter"><?php echo $loc->getText("lookup_optsAutoCutter"); ?></label>
    </td>
    <td valign="top" class="primary">
      <?php
      echo getCheckbox('auto_cutter', $postVars);
      ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
     <label for="cutter_type"><?php echo $loc->getText("lookup_optsCutterType"); ?></label>
    </td>
    <td valign="top" class="primary">
      <?php
        $options = array(' ', 'LoC', 'CS3');
        echo getSelection('cutter_type', $options, $postVars, FALSE);
      ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <label for="cutter_word"><?php echo $loc->getText("lookup_optsCutterWord"); ?></label>
    </td>
    <td valign="top" class="primary">
      <?php printMyInputText("cutter_word",10,10,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td class="primary" valign="top">
      <label for="auto_collect"><?php echo $loc->getText("lookup_optsAutoCollection"); ?></label>
    </td>
    <td valign="top" class="primary">
      <?php
      echo getCheckbox('auto_collect', $postVars);
      ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <label for="fiction_name"><?php echo $loc->getText("lookup_optsFictionName"); ?></label>
    </td>
    <td valign="top" class="primary">
      <?php printMyInputText("fiction_name",10,10,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td class="primary" valign="top">
      <label for="fiction_code"><?php echo $loc->getText("lookup_optsFictionCode"); ?></label>
    </td>
    <td valign="top" class="primary">
      <?php printMyInputText("fiction_code",10,10,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td class="primary" valign="top">
      <label for="fiction_loc"><?php echo $loc->getText("lookup_optsLocFictionCodes"); ?></label>
    </td>
    <td valign="top" class="primary">
      <?php printMyInputText("fiction_loc",30,50,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td class="primary" valign="top">
      <label for="fiction_dewey"><?php echo $loc->getText("lookup_optsDewFictionCodes"); ?></label>
    </td>
    <td valign="top" class="primary">
      <?php printMyInputText("fiction_dewey",30,50,$postVars,$pageErrors); ?>
    </td>
  </tr>
  </tbody>
  <tfoot>
  <tr>
    <td align="center" colspan="2" class="primary">
      <input type="submit" value="  <?php echo $loc->getText("adminUpdate"); ?>  " class="button">
    </td>
  </tr>
	</tfoot>
</table>
</form>
