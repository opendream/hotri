/*********************************************************
 *  Body Style
 *********************************************************/
body {
  background-color: <?php echo H(OBIB_PRIMARY_BG);?>
}

/*********************************************************
 *  Font Styles
 *********************************************************/
font.primary, .primary td {
  color: <?php echo H(OBIB_PRIMARY_FONT_COLOR);?>;
  font-size: <?php echo H(OBIB_PRIMARY_FONT_SIZE);?>px;
  font-family: <?php echo H(OBIB_PRIMARY_FONT_FACE);?>;
}
font.alt1 {
  color: <?php echo H(OBIB_ALT1_FONT_COLOR);?>;
  font-size: <?php echo H(OBIB_ALT1_FONT_SIZE);?>px;
  font-family: <?php echo H(OBIB_ALT1_FONT_FACE);?>;
}
font.alt1tab {
  color: <?php echo H(OBIB_ALT1_FONT_COLOR);?>;
  font-size: <?php echo H(OBIB_ALT2_FONT_SIZE);?>px;
  font-family: <?php echo H(OBIB_ALT2_FONT_FACE);?>;
<?php if (OBIB_ALT2_FONT_BOLD) { ?>
  font-weight: bold;
<?php } else { ?>
  font-weight: normal;
<?php } ?>
}
font.alt2 {
  color: <?php echo H(OBIB_ALT2_FONT_COLOR);?>;
  font-size: <?php echo H(OBIB_ALT2_FONT_SIZE);?>px;
  font-family: <?php echo H(OBIB_ALT2_FONT_FACE);?>;
<?php if (OBIB_ALT2_FONT_BOLD) { ?>
  font-weight: bold;
<?php } else { ?>
  font-weight: normal;
<?php } ?>
}
font.error {
  color: <?php echo H(OBIB_PRIMARY_ERROR_COLOR);?>;
  font-size: <?php echo H(OBIB_PRIMARY_FONT_SIZE);?>px;
  font-family: <?php echo H(OBIB_PRIMARY_FONT_FACE);?>;
  font-weight: bold;
}
font.small {
  font-size: 10px;
  font-family: <?php echo H(OBIB_PRIMARY_FONT_FACE);?>;
}
a.nav {
  color: <?php echo H(OBIB_ALT1_FONT_COLOR);?>;
  font-size: 10px;
  font-family: <?php echo H(OBIB_ALT1_FONT_FACE);?>;
  text-decoration: none;
  background-color: <?php echo H(OBIB_ALT1_BG);?>;
  border-style: solid;
  border-color: <?php echo H(OBIB_BORDER_COLOR);?>;
  border-width: <?php echo H(OBIB_BORDER_WIDTH);?>
}
h1 {
  font-size: 16px;
  font-family: <?php echo H(OBIB_PRIMARY_FONT_FACE);?>;
  font-weight: normal;
}

/*********************************************************
 *  Link Styles
 *********************************************************/
a:link {
  color: <?php echo H(OBIB_PRIMARY_LINK_COLOR);?>;
}
a:visited {
  color: <?php echo H(OBIB_PRIMARY_LINK_COLOR);?>;
}
a.primary:link {
  color: <?php echo H(OBIB_PRIMARY_LINK_COLOR);?>;
}
a.primary:visited {
  color: <?php echo H(OBIB_PRIMARY_LINK_COLOR);?>;
}
a.alt1:link {
  color: <?php echo H(OBIB_ALT1_LINK_COLOR);?>;
}
a.alt1:visited {
  color: <?php echo H(OBIB_ALT1_LINK_COLOR);?>;
}
a.alt2:link {
  color: <?php echo H(OBIB_ALT2_LINK_COLOR);?>;
}
a.alt2:visited {
  color: <?php echo H(OBIB_ALT2_LINK_COLOR);?>;
}
a.tab:link {
  color: <?php echo H(OBIB_ALT2_LINK_COLOR);?>;
  font-size: <?php echo H(OBIB_ALT2_FONT_SIZE);?>px;
  font-family: <?php echo H(OBIB_ALT2_FONT_FACE);?>;
<?php if (OBIB_ALT2_FONT_BOLD) { ?>
  font-weight: bold;
<?php } else { ?>
  font-weight: normal;
<?php } ?>
  text-decoration: none
}
a.tab:visited {
  color: <?php echo H(OBIB_ALT2_LINK_COLOR);?>;
  font-size: <?php echo H(OBIB_ALT2_FONT_SIZE);?>px;
  font-family: <?php echo H(OBIB_ALT2_FONT_FACE);?>;
<?php if (OBIB_ALT2_FONT_BOLD) { ?>
  font-weight: bold;
<?php } else { ?>
  font-weight: normal;
<?php } ?>
  text-decoration: none
}
a.tab:hover {text-decoration: underline}

/*********************************************************
 *  Table Styles
 *********************************************************/
table.border {
  border-style: solid;
  border-color: <?php echo H(OBIB_BORDER_COLOR);?>;
  border-width: <?php echo H(OBIB_BORDER_WIDTH);?>
}
th {
  background-color: <?php echo H(OBIB_ALT2_BG);?>;
  color: <?php echo H(OBIB_ALT2_FONT_COLOR);?>;
  font-size: <?php echo H(OBIB_ALT2_FONT_SIZE);?>px;
  font-family: <?php echo H(OBIB_ALT2_FONT_FACE);?>;
  padding: <?php echo H(OBIB_PADDING);?>;
  border-style: solid;
<?php if (OBIB_ALT2_FONT_BOLD) { ?>
  font-weight: bold;
<?php } else { ?>
  font-weight: normal;
<?php } ?>
  border-color: <?php echo H(OBIB_BORDER_COLOR);?>;
  border-width: <?php echo H(OBIB_BORDER_WIDTH);?>;
  height: 1
}
th.rpt {
  background-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  color: <?php echo H(OBIB_PRIMARY_FONT_COLOR);?>;
  font-size: <?php echo (OBIB_PRIMARY_FONT_SIZE - 2);?>px;
  font-family: Arial;
  font-weight: bold;
  padding: <?php echo H(OBIB_PADDING);?>;
  border-style: solid;
  border-color: <?php echo H(OBIB_BORDER_COLOR);?>;
  border-width: 1;
  text-align: left;
  vertical-align: bottom;
}
td.primary {
  background-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  color: <?php echo H(OBIB_PRIMARY_FONT_COLOR);?>;
  font-size: <?php echo H(OBIB_PRIMARY_FONT_SIZE);?>px;
  font-family: <?php echo H(OBIB_PRIMARY_FONT_FACE);?>;
  padding: <?php echo H(OBIB_PADDING);?>;
  border-style: solid;
  border-color: <?php echo H(OBIB_BORDER_COLOR);?>;
  border-width: <?php echo H(OBIB_BORDER_WIDTH);?>
}
td.borderless {
  background-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  color: <?php echo H(OBIB_PRIMARY_FONT_COLOR);?>;
  font-size: <?php echo H(OBIB_PRIMARY_FONT_SIZE);?>px;
  font-family: <?php echo H(OBIB_PRIMARY_FONT_FACE);?>;
  padding: <?php echo H(OBIB_PADDING);?>;
}
td.rpt {
  background-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  color: <?php echo H(OBIB_PRIMARY_FONT_COLOR);?>;
  font-size: <?php echo (OBIB_PRIMARY_FONT_SIZE - 2);?>px;
  font-family: Arial;
  padding: <?php echo H(OBIB_PADDING);?>;
  border-top-style: none;
  border-bottom-style: none;
  border-left-style: solid;
  border-left-color: <?php echo H(OBIB_BORDER_COLOR);?>;
  border-left-width: 1;
  border-right-style: solid;
  border-right-color: <?php echo H(OBIB_BORDER_COLOR);?>;
  border-right-width: 1;
  text-align: left;
  vertical-align: top;
}
td.primaryNoWrap {
  background-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  color: <?php echo H(OBIB_PRIMARY_FONT_COLOR);?>;
  font-size: <?php echo H(OBIB_PRIMARY_FONT_SIZE);?>px;
  font-family: <?php echo H(OBIB_PRIMARY_FONT_FACE);?>;
  padding: <?php echo H(OBIB_PADDING);?>;
  border-style: solid;
  border-color: <?php echo H(OBIB_BORDER_COLOR);?>;
  border-width: <?php echo H(OBIB_BORDER_WIDTH);?>;
  white-space: nowrap
}

td.title {
  background-color: <?php echo H(OBIB_TITLE_BG);?>;
  color: <?php echo H(OBIB_TITLE_FONT_COLOR);?>;
  font-size: <?php echo H(OBIB_TITLE_FONT_SIZE);?>px;
  font-family: <?php echo H(OBIB_TITLE_FONT_FACE);?>;
  padding: <?php echo H(OBIB_PADDING);?>;
<?php if (OBIB_TITLE_FONT_BOLD) { ?>
  font-weight: bold;
<?php } else { ?>
  font-weight: normal;
<?php } ?>
  border-color: <?php echo H(OBIB_BORDER_COLOR);?>;
  border-width: <?php echo H(OBIB_BORDER_WIDTH);?>;
  text-align: <?php echo H(OBIB_TITLE_ALIGN);;?>
}
td.alt1 {
  background-color: <?php echo H(OBIB_ALT1_BG);?>;
  color: <?php echo H(OBIB_ALT1_FONT_COLOR);?>;
  font-size: <?php echo H(OBIB_ALT1_FONT_SIZE);?>px;
  font-family: <?php echo H(OBIB_ALT1_FONT_FACE);?>;
  padding: <?php echo H(OBIB_PADDING);?>;
  border-style: solid;
  border-color: <?php echo H(OBIB_BORDER_COLOR);?>;
  border-width: <?php echo H(OBIB_BORDER_WIDTH);?>
}
td.tab1 {
  background-color: <?php echo H(OBIB_ALT1_BG);?>;
  color: <?php echo H(OBIB_ALT1_FONT_COLOR);?>;
  font-size: <?php echo H(OBIB_ALT1_FONT_SIZE);?>px;
  font-family: <?php echo H(OBIB_ALT2_FONT_FACE);?>;
<?php if (OBIB_ALT2_FONT_BOLD) { ?>
  font-weight: bold;
<?php } else { ?>
  font-weight: normal;
<?php } ?>
  padding: <?php echo H(OBIB_PADDING);?>;
}
td.tab2 {
  background-color: <?php echo H(OBIB_ALT2_BG);?>;
  color: <?php echo H(OBIB_ALT2_FONT_COLOR);?>;
  font-size: <?php echo H(OBIB_ALT2_FONT_SIZE);?>px;
  font-family: <?php echo H(OBIB_ALT2_FONT_FACE);?>;
<?php if (OBIB_ALT2_FONT_BOLD) { ?>
  font-weight: bold;
<?php } else { ?>
  font-weight: normal;
<?php } ?>
  padding: <?php echo H(OBIB_PADDING);?>;
}
td.noborder {
  background-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  color: <?php echo H(OBIB_PRIMARY_FONT_COLOR);?>;
  font-size: <?php echo H(OBIB_PRIMARY_FONT_SIZE);?>px;
  font-family: <?php echo H(OBIB_PRIMARY_FONT_FACE);?>;
  padding: <?php echo H(OBIB_PADDING);?>;
}
/*********************************************************
 *  Form Styles
 *********************************************************/
input.button {
  background-color: <?php echo H(OBIB_ALT1_BG);?>;
  border-color: <?php echo H(OBIB_ALT1_BG);?>;
  border-left-color: <?php echo H(OBIB_ALT1_BG);?>;
  border-top-color: <?php echo H(OBIB_ALT1_BG);?>;
  border-bottom-color: <?php echo H(OBIB_ALT1_BG);?>;
  border-right-color: <?php echo H(OBIB_ALT1_BG);?>;
  padding: <?php echo H(OBIB_PADDING);?>;
  font-family: <?php echo H(OBIB_PRIMARY_FONT_FACE);?>;
  color: <?php echo H(OBIB_ALT1_FONT_COLOR);?>;
}
input.navbutton {
  background-color: <?php echo H(OBIB_ALT2_BG);?>;
  border-color: <?php echo H(OBIB_ALT2_BG);?>;
  border-left-color: <?php echo H(OBIB_ALT2_BG);?>;
  border-top-color: <?php echo H(OBIB_ALT2_BG);?>;
  border-bottom-color: <?php echo H(OBIB_ALT2_BG);?>;
  border-right-color: <?php echo H(OBIB_ALT2_BG);?>;
  padding: <?php echo H(OBIB_PADDING);?>;
  font-family: <?php echo H(OBIB_PRIMARY_FONT_FACE);?>;
  color: <?php echo H(OBIB_ALT2_FONT_COLOR);?>;
}
input {
  background-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  border-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  border-left-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  border-top-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  border-bottom-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  border-right-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  padding: 0px;
  scrollbar-base-color: <?php echo H(OBIB_ALT1_BG);?>;
  font-family: <?php echo H(OBIB_PRIMARY_FONT_FACE);?>;
  color: <?php echo H(OBIB_PRIMARY_FONT_COLOR);?>;
}
textarea {
  background-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  border-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  border-left-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  border-top-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  border-bottom-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  border-right-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  padding: 0px;
  scrollbar-base-color: <?php echo H(OBIB_ALT1_BG);?>;
  font-family: <?php echo H(OBIB_PRIMARY_FONT_FACE);?>;
  color: <?php echo H(OBIB_PRIMARY_FONT_COLOR);?>;
  font-size: <?php echo H(OBIB_PRIMARY_FONT_SIZE);?>px;
}
select {
  background-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  border-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  border-left-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  border-top-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  border-bottom-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  border-right-color: <?php echo H(OBIB_PRIMARY_BG);?>;
  padding: 0px;
  scrollbar-base-color: <?php echo H(OBIB_ALT1_BG);?>;
  font-family: <?php echo H(OBIB_PRIMARY_FONT_FACE);?>;
  color: <?php echo H(OBIB_PRIMARY_FONT_COLOR);?>;
}
 {}
td.primary.form-required, td.primary.form-optional { padding-left: 14px; }
td.primary.form-required { background: url(../images/required-star.png) no-repeat; }
td.primary.form-required sup { display: none; }

tr.biblio-late td { color: red; font-weight: bold; background: #ffccbb; border-color: white; }

/*ul.nav_main { list-style-type: none; padding-left: 0; margin-left: 0; }
li.nav_selected:before { white-space: pre-wrap; content: "\bb  " }
ul.nav_main li.nav_selected { font-weight: bold }
ul.nav_sub li.nav_selected { font-weight: bold }
ul.nav_main li { font-weight: normal }
ul.nav_sub li { font-weight: normal }*/

li.report_category { margin-bottom: 1em }

table.results {
  width: 100%;
  border-collapse: collapse;
}
table.resultshead {
  width: 100%;
  border-collapse: separate;
  border-top: solid <?php echo OBIB_ALT2_BG;?> 3px;
  border-bottom: solid <?php echo OBIB_ALT2_BG;?> 3px;
  clear: both;
}
table.resultshead th {
  text-align: left;
  color: <?php echo OBIB_PRIMARY_FONT_COLOR;?>;
  border: none;
  background: <?php echo OBIB_PRIMARY_BG;?>;
  font-size: 16px;
  font-weight: bold;
  vertical-align: middle;
  padding: 2px;
}
table.resultshead td {
  text-align: right;
}
table.results td.primary { border-top: none; }
td.picture { width: 120px; }
.Z3988 { display: none; }
