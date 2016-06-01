<?php
session_start();
include "inc/dbconnect.php";
include("inc/index_header_inc.php");
/*
if(!session_is_registered("ownerid"))

{
header("Location: itlogin.php");
exit;
}
*/
?>
<html>

  Available Selections:


<br>
	<table border=0 cellspacing=0 cellpadding=2 bordercolor=#eeeeee width=600> 
    <tr><td align=center><b><a href='export_file.php'>Export File</a></b></td><td>Generic Export to Named External File</td></tr>
    <tr><td align=center><b><a href='load_wizard_export.php'>Export Template</a></b></td><td>Export Wizard to Named External File</td></tr>
    <tr><td align=center><b>---------------</a></b></td><td align=left>------------------------------</td></tr>
    <tr><td align=center><b>Other Export Utility</b><td>TBD</b></td>
    </table>
</p>
<?
include "inc/footer_inc.php";
?>
</body>
</HTML>
