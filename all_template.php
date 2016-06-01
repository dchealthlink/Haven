<?
session_start();
include("inc/dbconnect.php"); 
// include("inc/gen_functions_inc.php");


/* ==================== QUERY ====================== */
/* ==================== End of QUERY ====================== */
include("inc/header_inc.php");

?>
<HTML>
  <blockquote>
   <h1>Enter Data</h1>
  <?php

/* ================= Search ============== */
/* ============================ SUBMIT ==================== */

$menu_enabled = 1;
$header_table = $htable;
$acc_method = "insert";
$flddisp = "Y";
$site_redirect = "employee_confirm.php?employee_id=".$employee_id;
$where_clause = "where table_name = '".$htable."'";
echo "<FORM NAME=mainform METHOD=post ACTION=".$PHP_SELF." onSubmit='return ValidateForm()'>";
include("inc/input_form_submit.php");

/* ==================== UPDATE ====================== */
/* ==================== End of UPDATE ==================== */


/* ==================== DELETE ====================== */
/* ==================== End of DELETE ====================== */

$employee_status = "A";

$orient="vertical";
$header_table = $htable;
/* echo "<FORM NAME=mainform METHOD=post ACTION=".$PHP_SELF." onSubmit='return ValidateForm()'>"; */

echo("<table>");
include("inc/input_form_inc.php");


?>
    <input type="hidden" name="tablename" value="<?php echo $header_table ?>">

          <tr><td>&nbsp;</td>





	<tr><td colspan=2><input type="Submit" name="SUBMIT" value="Submit">
    <input type="Submit" name="update" value="Update">
    <input type="Submit" name="searchquery" value="Search">
    <input type="Submit" name="delete" value="Delete">

	<input type="Submit" name="newquery" value="Clear">

    <input type="Reset" name="Clear">
	<input type="hidden" name="tablename" value="<?php echo $tablename?>"></td>
	<input type="hidden" name="htable" value="<?php echo $htable?>"></td>
	</tr>
<?
?>
</blockquote>
<?
/* include "inc/form_expand.php"; */
echo "<br>";
echo ("<tr><td><a href=view_table.php?tablename=".$htable.">".ucwords($htable)." data</a></td></tr> | ");
echo "</table>";

include "inc/footer_inc.php";

?>
  </form>
</body>
</HTML>
