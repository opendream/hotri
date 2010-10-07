<?php
  require_once("../classes/DmQuery.php");
  require_once("../shared/forms.php");

  $tab = "opac";
  $lookup = "N";
  if (isset($_GET["lookup"])) {
    $lookup = "Y";
    $helpPage = "opacLookup";
  }

  $loc = new Localize(OBIB_LOCALE, "shared");
?>
<div class="advanced-search">
  <form method="post" action="../shared/biblio_advanced_search.php">
    <fieldset id="advanced-search">
      <legend><?php echo $loc->getText("advsTitle") ?></legend>
      <table>
        <tr>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td class="label"><?php echo $loc->getText("advsTypeOfMaterial"); ?></td>
          <td><?php echo form_biblio_material_type($loc) ?></td>
        </tr>
        <tr>
          <td colspan="2"></td>
        </tr>
        <tr>
          <td></td>
          <td>
            <input type="hidden" name="searchType" value="advanced">
            <input type="hidden" name="sortBy" value="default">
            <input type="hidden" name="tab" value="<?php echo H($tab); ?>">
            <input type="hidden" name="lookup" value="<?php echo H($lookup); ?>">
            <input type="submit" value="<?php echo $loc->getText("advsSearch"); ?>" class="button" />
          </td>
        </tr>
      </table>
    </fieldset>
  </form>
</div>
