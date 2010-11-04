<?php

require_once("../shared/common.php");
?>
<h1>CSV Formats For Import to OpenBiblio:</h1>
<p>CSV template which available on OpenBiblio is in tab-seperated value (TSV) format.</p>

<p>For Microsoft Excel 2003/2007: download, append with book informations, save and upload it.</p>
<p>For OpenOffice or another CSV editing software: make sure that select document character sets to Unicode or UTF-16 
and enable tab seperators to open CSV template. In OpenOffice, make sure you select 'Keep Current Format' while save.</p>
<h4>How to use template:</h4>
<ul>
  <li>Download template file.</li>
  <li>Open with CSV editing software eg. Microsoft Office, OpenOffice.</li>
  <li>Append book information eg. ISBN<font color="red">*</font>, Author<font color="red">*</font>, Title<font color="red">*</font>, etc. (Note: first 3 columns are required)</li>
  <li>Column 'Book cover filename' require filename link to cover image in <?php echo COVER_PATH; ?> directory.</li>
  <li>Don't change any first row columns in template file, it would be rejected when uploading.</li>
  <li>Save, then upload in CSV Import page. (Catalog > CSV Import)</li>
</ul>

<font class="small">Note: Upload would be failed in conditions:
<ol>
  <li>Missing or any changes with header (first row in CSV).</li>
  <li>Missing required fields.</li>
  <li>Incorrect CSV formatting.</li>
  <li>Failed to save new one in bibliographic database.</li>
</ol>
</font>
