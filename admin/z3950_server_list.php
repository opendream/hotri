<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "admin";
  $nav = "lookupHosts";

  require_once("../functions/errorFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/Localize.php");
  require_once('../lookup2/LookupHostsQuery.php');
  
  $loc = new Localize(OBIB_LOCALE,$tab);
  $navbar = new Localize(OBIB_LOCALE, 'navbars');
  
  require_once("../shared/header.php");
  
?>
<a class="primary" href="../admin/z3950_server_edit_form.php"><?php echo $loc->getText("Add new z39.50 server"); ?></a><br />
<h1><?php echo $navbar->getText("lookup_hosts"); ?></h1>
<?php if ($_GET['done']) { echo '<p><font class="error">' . $loc->getText('lookup_hostsUpdated') .'</font></p>'; } ?>
<table id="showList" name="showList" class="primary striped">
	<thead>
  <tr>
    <th colspan="2" valign="top" nowrap="yes">
      <?php echo $loc->getText("lookup_hostsFunc"); ?>
    </th>
    <th valign="top" nowrap="yes">
      <?php echo $loc->getText("lookup_hostsSeqNo"); ?>
    </th>
    <th valign="top" nowrap="yes">
      <?php echo $loc->getText("lookup_hostsActive"); ?>
    </th>
    <th valign="top" nowrap="yes">
      <?php echo $loc->getText("lookup_hostsHost"); ?>
    </th>
    <th valign="top" nowrap="yes">
      <?php echo $loc->getText("lookup_hostsName"); ?>
    </th>
    <th valign="top" nowrap="yes">
      <?php echo $loc->getText("lookup_hostsDb"); ?>
    </th>
    <th valign="top" nowrap="yes">
      <?php echo $loc->getText("lookup_hostsUser"); ?>
    </th>
     <th valign="top" nowrap="yes">
      <?php echo $loc->getText("lookup_hostsPw"); ?>
    </th>
    <th valign="top" nowrap="yes">
      <?php echo $loc->getText("lookup_hostsCharset"); ?>
    </th>
  </tr>
	</thead>
	<tbody>
	  <?php
	    $host = new lookupHostQuery();
      $res = $host->execSelectAll();
      
      $odd = true;
      while ($row = $host->fetchRow()) {
        if (!$odd) {
          $alt = ' alt1';
        }
        else {
          $alt = '';
        }
        $odd = !$odd;
	  ?>
	  <tr>
	    <td valign="top" class="primary<?php echo $alt; ?>">
        <a class="primary" href="../admin/z3950_server_edit_form.php?id=<?php echo $row->_id; ?>">edit</a>
      </td>
      <td valign="top" class="primary<?php echo $alt; ?>">
        <a class="primary" href="../admin/z3950_server_del.php?id=<?php echo $row->_id; ?>">del</a>
      </td>
	    <td valign="top" class="primary<?php echo $alt; ?>">
	      <?php echo $row->_seq; ?>
	    </td>
	    <td valign="top" class="primary<?php echo $alt; ?>">
	      <?php
	        if ($row->_active == 'y') {
	          echo 'yes';
	        }
	        else {
	          echo 'no';
	        } ?>
	    </td>
	    <td valign="top" class="primary<?php echo $alt; ?>">
	      <?php echo $row->_host; ?>
	    </td>
	    <td valign="top" class="primary<?php echo $alt; ?>">
	      <?php echo $row->_name; ?>
	    </td>
	    <td valign="top" class="primary<?php echo $alt; ?>">
	      <?php echo $row->_db; ?>
	    </td>
	    <td valign="top" class="primary<?php echo $alt; ?>">
	      <?php echo $row->_user; ?>
	    </td>
	    <td valign="top" class="primary<?php echo $alt; ?>">
	      <?php echo $row->_pw; ?>
	    </td>
	    <td valign="top" class="primary<?php echo $alt; ?>">
	      <?php echo $row->_charset; ?>
	    </td>
	  </tr>
	  <?php } ?>
	</tbody>
</table>
<?php include("../shared/footer.php"); ?>
