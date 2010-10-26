<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
require_once("../functions/errorFuncs.php");
require_once("../classes/Dm.php");
require_once("../classes/DmQuery.php");

/* Returns HTML for a form input field with error handling. */
function inputField($type, $name, $value="", $attrs=NULL, $data=NULL, $help_text=NULL) {
  global $loc;
  $s = "";
  if (isset($_SESSION['postVars'])) {
    $postVars = $_SESSION['postVars'];
  } else {
    $postVars = array();
  }
  if (isset($postVars[$name])) {
    $value = $postVars[$name];
  }
  if (isset($_SESSION['pageErrors'])) {
    $pageErrors = $_SESSION['pageErrors'];
  } else {
    $pageErrors = array();
  }
  if (isset($pageErrors[$name])) {
    $s .= '<font class="error">'.H($pageErrors[$name]).'</font><br />';
  }
  if (!$attrs) {
    $attrs = array();
  }
  if (!isset($attrs['onChange'])) {
    $attrs['onChange'] = 'modified=true';
  }
  switch ($type) {
  // TODO: radio
  case 'select':
    $s .= '<select id="'.H($name).'" name="'.H($name).'" ';
    foreach ($attrs as $k => $v) {
      $s .= H($k).'="'.H($v).'" ';
    }
    $s .= ">\n";
    foreach ($data as $val => $desc) {
      $s .= '<option value="'.H($val).'" ';
      if (strtolower($value) == strtolower($val)) {
        $s .= " selected";
      }
      $s .= ">".H($desc)."</option>\n";
    }
    $s .= "</select>\n";
    break;
  case 'textarea':
    $s .= '<textarea name="'.H($name).'" ';
    foreach ($attrs as $k => $v) {
      $s .= H($k).'="'.H($v).'" ';
    }
    $s .= ">".H($value)."</textarea>";
    break;
  case 'checkbox':
    $s .= '<input type="checkbox" ';
    $s .= 'name="'.H($name).'" ';
    $s .= 'value="'.H($data).'" ';
    if ($value == $data) {
      $s .= "checked ";
    }
    foreach ($attrs as $k => $v) {
      $s .= H($k).'="'.H($v).'" ';
    }
    $s .= "/>";
    break;
  case 'date':
    $thisDate = explode(' ', date('d m Y'));
    $dateInputName = H($name);
    $s .= '<select id="' . str_replace(array('[',']'),array(''), $dateInputName).'_day" name="'.$dateInputName.'_day">' . "\n";
    for ($i = 1; $i <= 31; $i++) {
      $day = str_pad($i, 2, '0', STR_PAD_LEFT); 
      $s .= '  <option value="' . $i . '" ' . ($i == 0 + $thisDate[0] ? ' selected="selected"':'') . '>' . $i . "</option>\n";
    }
    $s .= "</select>\n";
    $s .= '<select id="' . str_replace(array('[',']'),array(''), $dateInputName).'_month" name="'.$dateInputName.'_month">' . "\n";
    for ($i = 1; $i <= 12; $i++) {
      $mon = str_pad($i, 2, '0', STR_PAD_LEFT); 
      $s .= '  <option value="' . $mon . '"' . ($mon == $thisDate[1] ? ' selected="selected"':'') . '>' . $loc->getText('reportDateMonth' . $mon) . "</option>\n";
    }
    $s .= "</select>\n";
    
    $s .= '<select id="' . str_replace(array('[',']'),array(''), $dateInputName).'_year" name="'.$dateInputName.'_year">' . "\n";
    
    for ($i = -20; $i <= 20; $i++) {
      $y = $thisDate[2] + $i;
      $s .= '  <option value="' . $y . '" '. ($i == 0 ? 'selected="select"' : '') . '>' . $y . "</option>\n";
    }
    $s .= "</select>\n";
    
    // Javascript code for collecting date
    $s .= '<input type="hidden" id="' . $dateInputName . '" name="' . $dateInputName . '">
      <script>
        var updateDateInput_' . $dateInputName . ' = function() {
          document.getElementById("' . $dateInputName . '").value = 
            document.getElementById("' . $dateInputName . '_year").value + "-" +
            document.getElementById("' . $dateInputName . '_month").value + "-" +
            document.getElementById("' . $dateInputName . '_day").value;
            
            console.log(day.value);
        };
        
        document.getElementById("' . $dateInputName . '_day").onchange = updateDateInput_' . $dateInputName . ';
        document.getElementById("' . $dateInputName . '_month").onchange = updateDateInput_' . $dateInputName . ';
        document.getElementById("' . $dateInputName . '_year").onchange = updateDateInput_' . $dateInputName . ';
      </script>
    ';
    
    break;
  default:
    $s .= '<input type="'.H($type).'" ';
    $s .= 'id="' . str_replace(array('[',']'),array(''), H($name)).'" name="'.H($name).'" ';
    if ($value != "") {
      $s .= 'value="'.H($value).'" ';
    }
    foreach ($attrs as $k => $v) {
      $s .= H($k).'="'.H($v).'" ';
    }
    $s .= "/>";

    // Display a help text under the widget.
    // TODO: add this into another widgets.
    if (isset($help_text)) {
      $s .= "<div>". $help_text ."</div>";
    }

    break;
  }
  return $s;
}

/* Returns HTML for a select box with the contents of $table as options. */
function dmSelect($table, $name, $value="", $all=FALSE, $attrs=NULL, $required=TRUE) {
  $dmQ = new DmQuery();
  $dmQ->connect();
  # Don't use getAssoc() so that we can set the default below
  $dms = $dmQ->get($table);
  $dmQ->close();
  $default = "";
  $options = array();
  if ($all) {
    $options['all'] = 'All';
  }
  if (!$required) {
    // Add "Any" for the first option.
    $loc = new Localize(OBIB_LOCALE, "shared");
    $options[''] = $loc->getText("any");
  }
  foreach ($dms as $dm) {
    $options[$dm->getCode()] = $dm->getDescription();
    if ($dm->getDefaultFlg() == 'Y') {
      $default = $dm->getCode();
    }
  }
  if ($value == "") {
    $value = $default;
  }
  if (!$required) {
    // Selected on "Any" option.
    $value = "";
  }
  return inputField('select', $name, $value, $attrs, $options);
}

/*********************************************************************************
 * DEPRECATED, use inputField.  Draws input html tag of type text.
 * @param string $fieldName name of input field
 * @param string $size size of text box
 * @param string $max max input length of text box
 * @param array_reference &$postVars reference to array containing all input values
 * @param array_reference &$pageErrors reference to array containing all input errors
 * @return void
 * @access public
 *********************************************************************************
 */
function printInputText($fieldName,$size,$max,&$postVars,&$pageErrors,$visibility = "visible") {
  $_SESSION['postVars'] = $postVars;
  $_SESSION['pageErrors'] = $pageErrors;
  $attrs = array('size'=>$size,
                 'maxlength'=>$max,
                 'style'=>"visibility: $visibility");
  echo inputField('text', $fieldName, '', $attrs);
}

/*********************************************************************************
 * Custom printInputText for lookup2
 * @param string $fieldName name of input field
 * @param string $size size of text box
 * @param string $max max input length of text box
 * @param array_reference &$postVars reference to array containing all input values
 * @param array_reference &$pageErrors reference to array containing all input errors
 * @return void
 * @access public
 *********************************************************************************
 */
function printMyInputText($fieldName,$size,$max,&$postVars,&$pageErrors,$visibility = "visible") {
  $_SESSION['postVars'] = $postVars;
  $_SESSION['pageErrors'] = $pageErrors;
  $attrs = array('size'=>$size,
                 'maxlength'=>$max,
                 'style'=>"visibility: $visibility",
                 'id'=>$fieldName
                 );
  echo inputField('text', $fieldName, '', $attrs);
}

/*********************************************************************************
 * DEPRECATED, use dmSelect.
 * @param string $fieldName name of input field
 * @param string $domainTable name of domain table to get values from
 * @param array_reference &$postVars reference to array containing all input values
 * @param boolean $required will generate the first option with a null value if not required
 *********************************************************************************
 */
function printSelect($fieldName, $domainTable, &$postVars, $disabled=FALSE, $required=TRUE){
  $_SESSION['postVars'] = $postVars;
  $attrs = array();
  if ($disabled) {
    $attrs['disabled'] = '1';
  }
  echo dmSelect($domainTable, $fieldName, "", FALSE, $attrs, $required);
}
?>
