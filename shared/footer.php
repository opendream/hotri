<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

  # Be sure we don't get leftovers.
  unset($_SESSION['pageErrors']);
  unset($_SESSION['postVars']);
?>
<!-- **************************************************************************************
     * Footer
     **************************************************************************************-->
<br><br><br>
</font>
  <div class="footer">
    <center>
      <?php if (OBIB_LIBRARY_URL != "") { ?>
        <a href="<?php echo H(OBIB_LIBRARY_URL);?>"><?php echo $headerLoc->getText("footerLibraryHome"); ?></a> |
      <?php }
      if (OBIB_OPAC_URL != "") { ?>
        <a href="<?php echo H(OBIB_OPAC_URL);?>"><?php echo $headerLoc->getText("footerOPAC"); ?></a> |
      <?php } ?>
      <a href="javascript:popSecondary('../shared/help.php<?php if (isset($helpPage)) echo "?page=".H(addslashes(U($helpPage))); ?>')"><?php echo $headerLoc->getText("footerHelp"); ?></a>
      <br><br>
        <a href="http://obiblio.sourceforge.net/"><img src="../images/powered_by_openbiblio.gif" width="125" height="44" border="0"></a>
      <br><br>
      <?php echo $headerLoc->getText("footerCopyright"); ?> &copy; 2002-2005 Dave Stevens<br>
      <?php echo $headerLoc->getText("footerUnderThe"); ?>
      <a href="../shared/copying.html"><?php echo $headerLoc->getText("footerGPL"); ?></a>
    </center>
  </div>
    </td>
  </tr>
</table>
</body>
</html>
