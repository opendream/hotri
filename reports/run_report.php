<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");

  require_once("../classes/Report.php");
  require_once("../classes/Table.php");
  require_once("../classes/Settings.php");
	require_once("../classes/SettingsQuery.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE, "reports");
  $navLoc = new Localize(OBIB_LOCALE, 'navbars');

  $tab="reports";
  $nav="results";
  if (isset($_REQUEST['tab'])) {
    $tab = $_REQUEST['tab'];
  }
  if (isset($_REQUEST['nav'])) {
    $nav = $_REQUEST['nav'];
  }
  require_once("../shared/logincheck.php");

  if (isset($_REQUEST['rpt___format'])) {
    $format = $_REQUEST['rpt___format'];
  } else {
    $format = 'paged';
  }
  
  function echolink($page, $text, $newSort=NULL) {
    global $tab, $nav, $format;
    echo '<a href="../reports/run_report.php?type=previous';
    echo '&amp;rpt___format='.HURL($format);
    echo '&amp;tab='.HURL($tab).'&amp;nav='.HURL($nav);
    echo '&amp;page='.HURL($page);
    if ($newSort) {
      echo '&amp;rpt_order_by='.HURL($newSort);
    }
    echo '">'
         . $text
         . '</a>';
  }
  function printResultPages(&$loc, $currPage, $pageCount) {
    if ($pageCount <= 1) {
      return false;
    }
    echo $loc->getText("Result Pages: ");
    if ($currPage > 1) {
      echolink($currPage-1, $loc->getText("&laquo;Prev"));
      echo ' ';
    }
    $i = max(1, $currPage-OBIB_SEARCH_MAXPAGES/2);
    $maxPg = OBIB_SEARCH_MAXPAGES + $i;
    if ($i > 1) {
      echo "... ";
    }
    for (;$i <= $pageCount; $i++) {
      if ($i == $maxPg) {
        echo "... ";
        break;
      }
      if ($i == $currPage) {
        echo "<b>".$i."</b> ";
      } else {
        echolink($i, $i);
        echo ' ';
      }
    }
    if ($currPage < $pageCount) {
      echolink($currPage+1, $loc->getText("Next&raquo;"));
      echo ' ';
    }
  }

  if (!$_REQUEST['type']) {
    header('Location: ../reports/index.php');
    exit(0);
  }
  if ($_REQUEST['type'] == 'previous') {
    $rpt = Report::load('Report');
  } else {
    list($rpt, $err) = Report::create_e($_REQUEST['type'], 'Report');
    if ($err) {
      $rpt = NULL;
    }
  }
  if (!$rpt) {
    header('Location: ../reports/index.php');
    exit(0);
  }

  if ($_REQUEST['type'] == 'previous') {
    if (isset($_REQUEST['rpt_order_by'])) {
      list($rpt, $errs) = $rpt->variant_el(array('order_by'=>$_REQUEST['rpt_order_by']));
      assert('empty($errs)');
    }
  } else {
    $errs = $rpt->initCgi_el();
    if (!empty($errs)) {
      $_SESSION['postVars'] = mkPostVars();
      $_SESSION['pageErrors'] = array();
      foreach ($errs as $k=>$e) {
        $_SESSION['pageErrors'][$k] = $e->toStr();
      }
      header('Location: ../reports/report_criteria.php?msg='.U('Incorrect parameters, see below:'));
      exit();
    }
  }
  if (isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
  } else {
    $page = $rpt->curPage();
  }

  foreach ($rpt->layouts() as $l) {
    if ($l['title']) {
      $title = $l['title'];
    } else {
      $title = $l['name'];
    }
    Nav::node('results/'.$l['name'], $loc->getText($title),
      '../reports/run_report.php?type=previous&rpt___format='.U($l['name']));
  }
  Nav::node('results/list', $loc->getText('Print list'),
    '../reports/run_report.php?type=previous&rpt___format=pdf');
  Nav::node('reportcriteria', $navLoc->getText('reportsCriteria'),
    '../reports/report_criteria.php?type='.U($rpt->type()));

  if ($rpt->count() == 0) {
    include('../shared/header.php');
    echo $loc->getText("reportsResultNotFound");
    require_once("../shared/footer.php");
    exit();
  }
  
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
  
  if ($format == 'csv') {
    include_once('../classes/CsvTable.php');
    $table = new CsvTable;
    header('Content-type: text/csv;header=yes');
    header('Content-disposition: inline; filename="'.$rpt->type().'.csv"');
    $rpt->table($table);
    exit;
  }
  else if ($format == 'overdue') {
    // Generate letters, group by member
    include_once('../classes/ExcelTable.php');
    $table = new ExcelTable;
    
    list($rpt, $errs) = $rpt->variant_el(array('order_by'=>'member_bcode'));
    if (!empty($errs)) {
      die('Unexpected report error');
    }
    $rpt->preloadTable($table);
    $table->start();
    
    // result header
    $row = $table->getData();
    //$row = $rpt->getTableRow($table)
    $row_header = <<<INNERHTML
<th style="width: 40%"><u>{$loc->getText($row[5])}</u></th>
          <th style="width: 23%"><u>{$loc->getText($row[6])}</u></th>
          <th style="width: 22%"><u>{$loc->getText($row[10])}</u></th>
          <th style="width: 15%; text-align: right;"><u>{$loc->getText($row[11])}</u></th>
INNERHTML;
    
    $html = '';
    $letters = array();
    $overdue_list = '';
    $mbrid = NULL;
    $oldmbrid = NULL;
    require_once('../classes/MemberQuery.php');
    $mbrQ = new MemberQuery;
    
    while ($row = $rpt->getTableRow($table)) {
      $row = array(
        $row[5], $row[6], $row[10], $row[11], // title, author, due date, days late
        $row[2], // mbrid, used for grouping letter & would be hidden
      );
      
      $mbr = $mbrQ->get(0 + array_pop($row));
      $mbrid = $mbr->getMbrid();
      if (!isset($oldmbrid)) {
        $oldmbrid = $mbrid;
      }
      else if ($mbrid != $oldmbrid) {
        $oldmbr = $mbrQ->get($oldmbrid);
        $letters[] = getHtmlLetter($oldmbr, $row_header, $overdue_list);
        $overdue_list = '';
        $oldmbrid = $mbrid;
      }
      
      $overdue_list .= <<<INNERHTML
        <tr>
          <td style="width: 40%">$row[0]</td>
          <td style="width: 23%">$row[1]</td>
          <td style="width: 22%">{$loc->getText('rptFormattedShortDate', array('date' => $row[2]))}</td>
          <td style="width: 15%; text-align: right;">$row[3]</td>
        </tr>

INNERHTML;
    }
    // flush remain letter
    if (!empty($overdue_list)) {
      $mbr = $mbrQ->get($oldmbrid);
      $letters[] = getHtmlLetter($mbr, $row_header, $overdue_list);
    }
    $html = implode("\n<tcpdf method=\"AddPage\" />\n", $letters);
    
    // Load pdf class, then convert html to pdf file
    require_once('../classes/OverdueLetter.php');
    $letter = new OverdueLetter();
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment;filename="' . $rpt->type() . '.pdf"');
    header('Cache-Control: max-age=0');
    echo $letter->output($html, $title);
    die();
  }
  else if ($format == 'xls' || $format == 'pdf' || $format == 'labels') {
    include_once('../classes/ExcelTable.php');
    $table = new ExcelTable;
    
    // Load phpExcel
    $objPHPExcel = initializePHPExcel();
    
    if ($format == 'labels') {
      $objPHPExcel->getActiveSheet()->setShowGridlines(false);
    }
    
    $rpt->preloadTable($table);
    $key_row = 0;
    
    // Get header row
    $table->start();
    $row = $table->getData();
    
    // Set autosize to columns.
    $cols = count($row);
    $colstart = 0;
    if ($format == 'labels') {
      $cols -= 2;
      $colstart = 1;
    }
    for ($i = $colstart; $i < $cols; $i++) {
      $objPHPExcel->getActiveSheet()->getColumnDimension(
              $columns[floor(($i + 1) / $breaker)] 
              . $columns[($i + 1) % $breaker])
              ->setAutoSize(TRUE);
    }
    if ($format == 'labels') {
      $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(FALSE);
      $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth($set->getFontSize() + 10);
    }
    
    do {
      if ($format == 'labels') {
        if ($key_row === 0) {
          $row = $rpt->getTableRow($table);
        }
        $row[4] = $row[4] . "\n" . $row[5] . "\n" . $row[6];
        $row[3] = preg_replace("/ /", "\n", $row[3]);
        unset($row[0], $row[1], $row[5], $row[6]);
        
        $row = array($row[3], $row[2], $row[4]);
      }
      
      foreach ($row as $key_col => $val) {
        $column_name = $columns[floor(($key_col + 1) / $breaker)] 
              . $columns[($key_col + 1) % $breaker] . ($key_row + 1);
        
        // Initialize cell styles
        $styles = $objPHPExcel->getActiveSheet()->getStyle($column_name);
        $styles->getAlignment()->setWrapText(TRUE);
        $styles->getAlignment()->setIndent(1);
        //$styles->getAlignment()->setShrinkToFit(TRUE);
        
        // Borders
        if ($format != 'labels') {
          $borders = $styles->getBorders();
          $borders->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
          $borders->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
          $borders->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
          $borders->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        
          if ($key_row === 0) {
            // Emphasize cell as header row
            
            $styles->getFont()->setBold(TRUE);
            $styles->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            if ($format == 'xls') {
              $styles->getFill()->getStartColor()->setARGB('FFFFDD00');
            }
            else {
              $styles->getFill()->getStartColor()->setARGB('FFCCCCCC');
            }
            $objPHPExcel->getActiveSheet()->setCellValue($column_name, $loc->getText($val));
          }
          else {
            $objPHPExcel->getActiveSheet()->setCellValue($column_name, $val);
          }
        }
        else {
          switch ($key_col) {
            case 1:
              $objPHPExcel->getActiveSheet()->setCellValue($column_name, '<span style="text-align:center;"><span style="font-family:free3of9x; font-size:20pt;">*' . $val . '*</span><br />' . $val . '</span>');
              break;
            case 2:
              $objPHPExcel->getActiveSheet()->setCellValue($column_name, $val . "\n");
              break;
            case 0:
              $styles->getFont()->setBold(TRUE);
              $styles->getFont()->setSize(7 + $set->getFontSize());
            default:
              $objPHPExcel->getActiveSheet()->setCellValue($column_name, $val);
          }
        }
      }
      
      $key_row++;
    } while ($row = $rpt->getTableRow($table));
    
    if ($format == 'xls') {
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="' . $rpt->type() . '.xls"');
      header('Cache-Control: max-age=0');

      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    }
    else {
      header('Content-Type: application/pdf');
      header('Content-Disposition: attachment;filename="' . $rpt->type() . '.pdf"');
      header('Cache-Control: max-age=0');
      
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
    }
    $objWriter->save('php://output', $loc->getText($rpt->title()));
    
    exit;
  }
  
  include('../shared/header.php');

  if (isset($_REQUEST["msg"]) && !empty($_REQUEST["msg"])) {
    echo "<font class=\"error\">".H($_REQUEST["msg"])."</font><br><br>";
  }

  echo '<p>'.$loc->getText('reportsResultFound', array('results' => $rpt->count())) . '</p>';
  if ($format == 'paged') {
    printResultPages($loc, $page, ceil($rpt->count()/OBIB_ITEMS_PER_PAGE));
  }
?>

<table class="resultshead">
  <tr>
      <th><?php echo $loc->getText("Report Results:"); ?></th>
    <td class="resultshead">
<table class="buttons">
<tr>
<?php
# Fill in report actions here
?>
</tr>
</table>
</td>
  </tr>
</table>
<?php
  if ($format == 'paged') {
    $rpt->pageTable($page, new Table('echolink'));
    printResultPages($loc, $page, ceil($rpt->count()/OBIB_ITEMS_PER_PAGE));
  } else {
    $rpt->table(new Table('echolink'));
  }

  include('../shared/footer.php');
  

function initializePHPExcel() {
  global $columns, $breaker, $set, $rpt;
  date_default_timezone_set('Asia/Bangkok');
  require_once '../classes/PHPExcel.php';
  
  $objPHPExcel = new PHPExcel();
  
  $columns = array(
    '',   'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 
    'I',  'J',  'K', 'L', 'M', 'N', 'O', 'P', 'Q', 
    'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
  );
  $breaker = count($columns);
  $objPHPExcel->setActiveSheetIndex(0);
  $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Tahoma');
  //$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
  $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
  //$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(TRUE);
  
  $objPHPExcel->getDefaultStyle()->getFont()->setSize($set->getFontSize()); 
  $objPHPExcel->getProperties()->setTitle($rpt->title());
  return $objPHPExcel;  
}

function getHtmlLetter($mbr, $header, $list) {
  global $loc, $set;
  
  $td_style = ' style="width: 33%; word-wrap: word-break;" ';
  $merge_style = ' style="width; 99%; word-wrap: word-break;" ';
  $address = str_replace("\n", "<br />", $mbr->getAddress());
  $date = $loc->getText('rptFormattedDate', array('date' => date('Y-m-d')));
  
  return <<<INNERHTML
<table style="width: 100%; font-size:{$set->getFontSize()}pt">
  <tr>
    <td $td_style></td>
    <td $td_style></td>
    <td $td_style>$address<br /></td>
  </tr>
  <tr>
    <td $td_style></td>
    <td $td_style>$date<br /></td>
    <td $td_style></td>
  </tr>
  <tr>
    <td $merge_style colspan="3">{$loc->getText('rptLetterDear', array('firstName' => $mbr->getFirstName(), 'lastName' => $mbr->getLastName()))}<br /></td>
  </tr>
  <tr>
    <td $merge_style colspan="3">{$loc->getText('rptLetterDetails')}<br />
      <br />
      <table>
        <tr>
          $header
        </tr>
$list
      </table>
      <br />
    </td>
  </tr>
  <tr>
    <td $td_style></td>
    <td $td_style>{$loc->getText('rptLetterFooter')}<br />
    </td>
    <td $td_style></td>
  </tr>
</table>
INNERHTML;
}
?>
