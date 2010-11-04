<?php
class OverDueLetter {
  function output($html, $title='document', $pFilename='doc.pdf') {
    require_once('../classes/PHPExcel/Shared/PDF/tcpdf.php');
    require_once("../classes/Settings.php");
    require_once("../classes/SettingsQuery.php");
    
    // Create PDF
    $pdf = new TCPDF('P', 'pt', 'A4');
    $pdf->SetMargins(56.7, 56.7);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->setTitle($title);
    $pdf->AddPage();

    // Set the appropriate font
    
    $setQ = new SettingsQuery();
    $setQ->connect();
    if ($setQ->errorOccurred()) {
      $setQ->close();
      displayErrorPage($setQ);
    }
    $setQ->execSelect();
    if ($setQ->errorOccurred()) {
      $setQ->close();
      displayErrorPage($setQ);
    }
    $set = $setQ->fetchRow();
    
    $pdf->setFont($set->getFontNormal());
    $pdf->writeHTML($html);
    $pdf->SetTitle($title);
    return $pdf->output($pFilename, 'S');
  }
}
?>
