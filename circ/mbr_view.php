<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "circulation";
  $nav = "view";
  $helpPage = "memberView";
  $focus_form_name = "barcodesearch";
  $focus_form_field = "barcodeNmbr";

  require_once("../functions/inputFuncs.php");
  require_once("../functions/formatFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/Member.php");
  require_once("../classes/MemberQuery.php");
  require_once("../classes/BiblioSearch.php");
  require_once("../classes/BiblioSearchQuery.php");
  require_once("../classes/BiblioHold.php");
  require_once("../classes/BiblioHoldQuery.php");
  require_once("../classes/MemberAccountQuery.php");
  require_once("../classes/DmQuery.php");
  require_once("../shared/get_form_vars.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  #****************************************************************************
  #*  Checking for get vars.  Go back to form if none found.
  #****************************************************************************
  if (count($_GET) == 0) {
    header("Location: ../circ/index.php");
    exit();
  }

  #****************************************************************************
  #*  Retrieving get var
  #****************************************************************************
  $mbrid = $_GET["mbrid"];
  if (isset($_GET["msg"])) {
    $msg = "<font class=\"error\">".H($_GET["msg"])."</font><br><br>";
  } else {
    $msg = "";
  }

  #****************************************************************************
  #*  Loading a few domain tables into associative arrays
  #****************************************************************************
  $dmQ = new DmQuery();
  $dmQ->connect();
  $mbrClassifyDm = $dmQ->getAssoc("mbr_classify_dm");
  $mbrMaxFines = $dmQ->getAssoc("mbr_classify_dm", "max_fines");
  $biblioStatusDm = $dmQ->getAssoc("biblio_status_dm");
  $materialTypeDm = $dmQ->getAssoc("material_type_dm");
  $materialImageFiles = $dmQ->getAssoc("material_type_dm", "image_file");
  $memberFieldsDm = $dmQ->getAssoc("member_fields_dm");
  $dmQ->close();

  #****************************************************************************
  #*  Search database for member
  #****************************************************************************
  $mbrQ = new MemberQuery();
  $mbrQ->connect();
  $mbr = $mbrQ->get($mbrid);
  $mbrQ->close();

  #****************************************************************************
  #*  Check for outstanding balance due
  #****************************************************************************
  $acctQ = new MemberAccountQuery();
  $acctQ->connect();
  if ($acctQ->errorOccurred()) {
    $acctQ->close();
    displayErrorPage($acctQ);
  }
  $balance = $acctQ->getBalance($mbrid);
  if ($acctQ->errorOccurred()) {
    $acctQ->close();
    displayErrorPage($acctQ);
  }
  $acctQ->close();
  
  #**************************************************************************
  #*  Show member information
  #**************************************************************************
  require_once("../shared/header.php");
  
  $balMsg = "";
  if ($balance > 0 && $balance >= $mbrMaxFines[$mbr->getClassification()]) {
    $balText = moneyFormat($balance, 2);
    $balMsg = "<font class=\"error\">".$loc->getText("mbrViewBalMsg",array("bal"=>$balText))."</font><br><br>";
  }
?>

<?php echo $balMsg ?>
<?php echo $msg ?>

<table class="primary">
  <tr><td class="noborder" valign="top">
  <br>
<table class="primary">
  <tr>
    <th align="left" colspan="2" nowrap="yes">
      <?php echo $loc->getText("mbrViewHead1"); ?>
    </th>
  </tr>
  <tr>
    <td nowrap="true" class="primary" valign="top">
      <?php echo $loc->getText("mbrViewName"); ?>
    </td>
    <td valign="top" class="primary">
      <?php echo H($mbr->getLastName());?>, <?php echo H($mbr->getFirstName());?>
    </td>
  </tr>
  <tr>
    <td class="primary" valign="top">
      <?php echo $loc->getText("mbrViewAddr"); ?>
    </td>
    <td valign="top" class="primary">
      <?php
        echo str_replace("\n", "<br />", H($mbr->getAddress()));
      ?>
    </td>
  </tr>
  <tr>
    <td class="primary" valign="top">
      <?php echo $loc->getText("mbrViewCardNmbr"); ?>
    </td>
    <td valign="top" class="primary">
      <?php echo H($mbr->getBarcodeNmbr());?>
    </td>
  </tr>
  <tr>
    <td class="primary" valign="top">
      <?php echo $loc->getText("mbrViewClassify"); ?>
    </td>
    <td valign="top" class="primary">
      <?php echo H($mbrClassifyDm[$mbr->getClassification()]);?>
    </td>
  </tr>
  <tr>
    <td class="primary" valign="top">
      <?php echo $loc->getText("mbrViewStatus"); ?>
    </td>
    <td valign="top" class="primary">
      <?php
        if (strcmp($mbr->getStatus(), "Y") == 0) {
          echo $loc->getText("mbrActive"); 
        } elseif (strcmp($mbr->getStatus(), "N") == 0) {
          echo $loc->getText("mbrInactive"); 
        }
      ?>
    </td>
  </tr>
  <tr>
    <td class="primary" valign="top">
      <?php echo $loc->getText("mbrViewPhone"); ?>
    </td>
    <td valign="top" class="primary">
      <?php
        if ($mbr->getHomePhone() != "") {
          echo $loc->getText("mbrViewPhoneHome").$mbr->getHomePhone()." ";
        }
        if ($mbr->getWorkPhone() != "") {
          echo $loc->getText("mbrViewPhoneWork").$mbr->getWorkPhone();
        }
      ?>
    </td>
  </tr>
  <tr>
    <td class="primary" valign="top">
      <?php echo $loc->getText("mbrViewEmail"); ?>
    </td>
    <td valign="top" class="primary">
      <?php echo H($mbr->getEmail());?>
    </td>
  </tr>
  <tr>
    <td class="primary" valign="top">
      <?php echo $loc->getText("mbrViewLastActDate"); ?>
    </td>
    <td valign="top" class="primary">
      <?php echo $loc->getText("mbrFormattedDate", array('date' => $mbr->getLastActDate()));?>
    </td>
  </tr>
<?php
  foreach ($memberFieldsDm as $name => $title) {
    if (($value = $mbr->getCustom($name))) {
?>
  <tr>
    <td class="primary" valign="top">
      <?php echo H($title); ?>
    </td>
    <td valign="top" class="primary">
      <?php echo H($value);?>
    </td>
  </tr>
<?php
    }
  }
?>
</table>

  </td>
  <td class="noborder" valign="top">

<?php
  #****************************************************************************
  #*  Show checkout stats
  #****************************************************************************
  $dmQ = new DmQuery();
  $dmQ->connect();
  $dms = $dmQ->getCheckoutStats($mbr->getMbrid());
  $dmQ->close();
?>
<?php echo $loc->getText("mbrViewHead2"); ?>
<table class="primary">
  <tr>
    <th align="left" rowspan="2">
      <?php echo $loc->getText("mbrViewStatColHdr1"); ?>
    </th>
    <th align="left" rowspan="2">
      <?php echo $loc->getText("mbrViewStatColHdr2"); ?>
    </th>
    <th align="center" colspan="2" nowrap="yes">
      <?php echo $loc->getText("mbrViewStatColHdr3"); ?>
    </th>
  </tr>
  <tr>
    <th align="left">
      <?php echo $loc->getText("mbrViewStatColHdr4"); ?>
    </th>
    <th align="left">
      <?php echo $loc->getText("mbrViewStatColHdr5"); ?>
    </th>
  </tr>
<?php
  foreach ($dms as $dm) {
?>
  <tr>
    <td nowrap="true" class="primary" valign="top">
      <?php echo H($dm->getDescription()); ?>
    </td>
    <td valign="top" class="primary">
      <?php echo H($dm->getCount()); ?>
    </td>
    <td valign="top" class="primary">
      <?php echo H($dm->getCheckoutLimit()); ?>
    </td>
    <td valign="top" class="primary">
      <?php echo H($dm->getRenewalLimit()); ?>
    </td>
  </tr>
<?php
  }
?>
  </table>
</td></tr></table>

<br>

<!--****************************************************************************
    *  Checkout form
    **************************************************************************** -->
<form name="barcodesearch" method="POST" action="../circ/checkout.php">
<input type="hidden" name="mbrid" value="<?php echo H($mbrid);?>">
<input type="hidden" name="date_from" id="date_from" value="default" />
<script type="text/javascript">
function showDueDate() {
  el = document.getElementById('date_from');
  el.value = "override";
  el = document.getElementById('duedateoverride');
  el.style.display = "none";
  el = document.getElementById('duedate1');
  el.style.display = "inline";
  el = document.getElementById('duedate2');
  el.style.display = "inline";
  el = document.getElementById('duedate3');
  el.style.display = "inline";
}
function hideDueDate() {
  el = document.getElementById('date_from');
  el.value = "default";
  el = document.getElementById('duedateoverride');
  el.style.display = "inline";
  el = document.getElementById('duedate1');
  el.style.display = "none";
  el = document.getElementById('duedate2');
  el.style.display = "none";
  el = document.getElementById('duedate3');
  el.style.display = "none";
}
</script>
<table class="primary">
  <tr>
    <th valign="top" nowrap="yes" align="left">
      <?php echo $loc->getText("mbrViewHead3"); ?>
    </th>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <table class="primary">
      <tr>
      <td class="borderless"><?php echo $loc->getText("mbrViewBarcode"); ?></td>
      <td class="borderless">
        <?php printInputText("barcodeNmbr",18,18,$postVars,$pageErrors); ?>
        <a href="javascript:popSecondaryLarge('../opac/index.php?lookup=Y')"><?php echo $loc->getText("indexSearch"); ?></a>
      </td><td class="borderless">
        <input type="submit" value="<?php echo $loc->getText("mbrViewCheckOut"); ?>" class="button">
      </td>
      </tr><tr>
      <td class="borderless"><span id="duedate1" style="display:none"><?php echo $loc->getText("Due Date:"); ?></td>
      <td class="borderless">
        <small id="duedateoverride"><a href="javascript:showDueDate()"><?php echo $loc->getText("Override Due Date"); ?></a></small>
        <span id="duedate2" style="display:none">
        <?php 
          if (isset($_SESSION['due_date_override']) && !isset($postVars['dueDate'])) {
            $postVars['dueDate'] = $_SESSION['due_date_override'];
          }
          printInputText("dueDate",18,18,$postVars,$pageErrors);
        ?>
        </span>
      </td>
      <td>
        <span id="duedate3" style="display:none"><input type="button" value="<?php echo $loc->getText("Cancel"); ?>" class="button" onclick="hideDueDate()" /></span>
      </td>
      </tr>
      </table>
    </td>
  </tr>
</table>
<?php if (isset($_SESSION['postVars']['date_from']) && $_SESSION['postVars']['date_from'] == 'override') { ?>
<script type="text/javascript">showDueDate()</script>
<?php } ?>
</form>

<h1><?php echo $loc->getText("mbrViewHead4"); ?>
  <font class="primary"> <a href="javascript:popSecondary('../circ/mbr_print_checkouts.php?mbrid=<?php echo H(addslashes(U($mbrid)));?>')"><?php echo $loc->getText("mbrPrintCheckouts"); ?></a></font>
</h1>
<table class="primary">
  <tr>
    <th valign="top" nowrap="yes" align="left">
      <?php echo $loc->getText("mbrViewOutHdr1"); ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php echo $loc->getText("mbrViewOutHdr2"); ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php echo $loc->getText("mbrViewOutHdr3"); ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php echo $loc->getText("mbrViewOutHdr4"); ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php echo $loc->getText("mbrViewOutHdr5"); ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php echo $loc->getText("mbrViewOutHdr6"); ?>
    </th>
    <th valign="top" align="left">
      <?php echo $loc->getText("mbrViewOutHdr8"); ?>
    </th>
    <th valign="top" align="left">
      <?php echo $loc->getText("mbrViewOutHdr7"); ?>
    </th>
  </tr>

<?php
  #****************************************************************************
  #*  Search database for BiblioStatus data
  #****************************************************************************
  $biblioQ = new BiblioSearchQuery();
  $biblioQ->connect();
  if ($biblioQ->errorOccurred()) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }
  if (!$biblioQ->doQuery(OBIB_STATUS_OUT,$mbrid)) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }
  if ($biblioQ->getRowCount() == 0) {
?>
  <tr>
    <td class="primary" align="center" colspan="8">
      <?php echo $loc->getText("mbrViewNoCheckouts"); ?>
    </td>
  </tr>
<?php
  } else {
    while ($biblio = $biblioQ->fetchRow()) {
?>
  <tr<?php echo $biblio->getDaysLate() > 0 ? ' class="biblio-late"' : ''; ?>>
    <td class="primary" valign="top" nowrap="yes">
      <?php echo H($biblio->getStatusBeginDt());?>
    </td>
    <td class="primary" valign="top">
      <img src="../images/<?php echo HURL($materialImageFiles[$biblio->getMaterialCd()]);?>" width="20" height="20" border="0" align="middle" alt="<?php echo H($materialTypeDm[$biblio->getMaterialCd()]);?>">
      <?php echo H($materialTypeDm[$biblio->getMaterialCd()]);?>
    </td>
    <td class="primary" valign="top" >
      <?php echo H($biblio->getBarcodeNmbr());?>
    </td>
    <td class="primary" valign="top" >
      <a href="../shared/biblio_view.php?bibid=<?php echo HURL($biblio->getBibid());?>"><?php echo H($biblio->getTitle());?></a>
    </td>
    <td class="primary" valign="top" >
      <?php echo H($biblio->getAuthor());?>
    </td>
    <td class="primary" valign="top" nowrap="yes">
      <?php echo H($biblio->getDueBackDt());?>
    </td>
    <td class="primary" valign="top" >
      <a href="../circ/checkout.php?barcodeNmbr=<?php echo HURL($biblio->getBarcodeNmbr());?>&amp;mbrid=<?php echo HURL($mbrid);?>&amp;renewal">Renew item</A>
      <?php
        if($biblio->getRenewalCount() > 0) { ?>
          </br>
          (<?php echo H($biblio->getRenewalCount());?> <?php echo $loc->getText("mbrViewOutHdr9"); ?>)
      <?php
        } ?>
    </td>
    <td class="primary" valign="top" >
      <?php echo H($biblio->getDaysLate());?>
    </td>
  </tr>
<?php
    }
  }
  $biblioQ->close();
?>

</table>

<br>
<!--****************************************************************************
    *  Hold form
    **************************************************************************** -->
<form name="holdForm" method="POST" action="../circ/place_hold.php">
<table class="primary">
  <tr>
    <th valign="top" nowrap="yes" align="left">
      <?php echo $loc->getText("mbrViewHead5"); ?>
    </th>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <?php echo $loc->getText("mbrViewBarcode"); ?>
      <?php printInputText("holdBarcodeNmbr",18,18,$postVars,$pageErrors); ?>
        <a href="javascript:popSecondaryLarge('../opac/index.php?lookup=Y')"><?php echo $loc->getText("indexSearch"); ?></a>
      <input type="hidden" name="mbrid" value="<?php echo H($mbrid);?>">
      <input type="hidden" name="classification" value="<?php echo H($mbr->getClassification());?>">
      <input type="submit" value="<?php echo $loc->getText("mbrViewPlaceHold"); ?>" class="button">
    </td>
  </tr>
</table>
</form>

<h1><?php echo $loc->getText("mbrViewHead6"); ?></h1>
<table class="primary">
  <tr>
    <th valign="top" nowrap="yes" align="left">
      <?php echo $loc->getText("mbrViewHoldHdr1"); ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php echo $loc->getText("mbrViewHoldHdr2"); ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php echo $loc->getText("mbrViewHoldHdr3"); ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php echo $loc->getText("mbrViewHoldHdr4"); ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php echo $loc->getText("mbrViewHoldHdr5"); ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php echo $loc->getText("mbrViewHoldHdr6"); ?>
    </th>
    <th valign="top" align="left">
      <?php echo $loc->getText("mbrViewHoldHdr7"); ?>
    </th>
    <th valign="top" align="left">
      <?php echo $loc->getText("mbrViewHoldHdr8"); ?>
    </th>
  </tr>
<?php
  #****************************************************************************
  #*  Search database for BiblioHold data
  #****************************************************************************
  $holdQ = new BiblioHoldQuery();
  $holdQ->connect();
  if ($holdQ->errorOccurred()) {
    $holdQ->close();
    displayErrorPage($holdQ);
  }
  if (!$holdQ->queryByMbrid($mbrid)) {
    $holdQ->close();
    displayErrorPage($holdQ);
  }
  if ($holdQ->getRowCount() == 0) {
?>
  <tr>
    <td class="primary" align="center" colspan="8">
      <?php echo $loc->getText("mbrViewNoHolds"); ?>
    </td>
  </tr>
<?php
  } else {
    while ($hold = $holdQ->fetchRow()) {
?>
  <tr>
    <td class="primary" valign="top" nowrap="yes">
      <a href="../shared/hold_del_confirm.php?bibid=<?php echo HURL($hold->getBibid());?>&amp;copyid=<?php echo HURL($hold->getCopyid());?>&amp;holdid=<?php echo HURL($hold->getHoldid());?>&amp;mbrid=<?php echo HURL($mbrid);?>"><?php echo $loc->getText("mbrViewDel"); ?></a>
    </td>
    <td class="primary" valign="top" nowrap="yes">
      <?php echo H($hold->getHoldBeginDt());?>
    </td>
    <td class="primary" valign="top">
      <img src="../images/<?php echo HURL($materialImageFiles[$hold->getMaterialCd()]);?>" width="20" height="20" border="0" align="middle" alt="<?php echo H($materialTypeDm[$hold->getMaterialCd()]);?>">
      <?php echo H($materialTypeDm[$hold->getMaterialCd()]);?>
    </td>
    <td class="primary" valign="top" >
      <?php echo H($hold->getBarcodeNmbr());?>
    </td>
    <td class="primary" valign="top" >
      <a href="../shared/biblio_view.php?bibid=<?php echo HURL($hold->getBibid());?>"><?php echo H($hold->getTitle());?></a>
    </td>
    <td class="primary" valign="top" >
      <?php echo H($hold->getAuthor());?>
    </td>
    <td class="primary" valign="top" >
      <?php echo H($biblioStatusDm[$hold->getStatusCd()]);?>
    </td>
    <td class="primary" valign="top" >
      <?php echo H($hold->getDueBackDt());?>
    </td>
  </tr>
<?php
    }
  }
  $holdQ->close();
?>


</table>


<?php require_once("../shared/footer.php"); ?>
