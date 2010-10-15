<?php

function form_biblio_material_types($loc) {
  $form = "";

  //    Played with printselect function
  if (isset($postVars['materialCd'])) {
    $materialCd = $postVars['materialCd'];
  } else {
    $materialCd = '';
  }
  $fieldname = "materialCd";
  $domainTable = "material_type_dm";

  $dmQ = new DmQuery();
  $dmQ->connect();
  $dms = $dmQ->get($domainTable);
  $dmQ->close();
  $form .= "<select id=\"materialCd\" name=\"materialCd\"";

  //    Needed OnChange event here.
  $form .= " onChange=\"matCdReload()\">\n";
  $form .= "<option value=\"\" selected>". $loc->getText("any") ."</option>";
  foreach ($dms as $dm) {
    $form .= "<option value=\"". H($dm->getCode()) ."\"";
    $form .= ">". H($dm->getDescription()) ."</option>";
  }
  $form .= "</select>";

  return $form;
}
