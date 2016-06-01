<?php
session_start();
// session_unregister("tablename");
$_SESSION['tablename'] = '';
include("inc/dbconnect.php"); 
$show_menu="ON";
$debug=0;

/* ================= Search ============== */

if($search == 1) {

	$where_clause = str_replace("!!","'",$search_where_clause);
	$where_clause = str_replace("@@"," AND ",$where_clause);

	$sql = "SELECT * from ".$tablename." WHERE ".$where_clause;
	$result = pg_exec($db, $sql);

	if ($debug) {
			DisplayErrMsg(sprintf("Executing: %s", $sql)) ;   
			DisplayErrMsg(sprintf("%s", pg_ErrorMessage($db))) ;   
	}
	$row = pg_fetch_array($result, 0);

	$fieldnum = pg_numfields($result);

	for($i=0;$i<$fieldnum; $i++)
		{
	/*		$matrix[$i][4]=$row[pg_fieldname($result,$i)]; */
			$arr_val[$i]=pg_fieldname($result,$i);
			$$arr_val[$i]=$row[pg_fieldname($result,$i)];
		}


	$search=0;
	$acc_method = "insert";
};

if($search == 2) {

        $where_clause = str_replace("!!","'",$search_where_clause);
        $where_clause = str_replace("@@"," AND ",$where_clause);

        $sql = "SELECT * from ".$tablename." WHERE ".$where_clause;
        $result = pg_exec($db, $sql);

        if ($debug) {
                        DisplayErrMsg(sprintf("Executing: %s", $sql)) ;
                        DisplayErrMsg(sprintf("%s", pg_ErrorMessage($db))) ;
        }
        $row = pg_fetch_array($result, 0);

        $fieldnum = pg_numfields($result);

        for($i=0;$i<$fieldnum; $i++)
                {
        /*              $matrix[$i][4]=$row[pg_fieldname($result,$i)]; */
                        $arr_val[$i]=pg_fieldname($result,$i);
                        $$arr_val[$i]=$row[pg_fieldname($result,$i)];
                }


        $search=0;
	$acc_method = "update";
};



/* ============================ SUBMIT ==================== */

$menu_enabled = 1;
$header_table = $tablename;
$flddisp = "Y";
/* $site_redirect = "employee_confirm.php?employee_id=".$employee_id; */
/* $where_clause = "where table_name = '".$tablename."'"; */
include("inc/input_form_submit.php");

include("inc/index_header_inc.php");
?>
<HTML>
  <blockquote>
<tr><td>
   <h1>Enter Data  <?php echo $message_data ?></h1></td></tr>
  <?php
$message_data = "";
$employee_status = "A";

$orient="vertical";
$header_table = $tablename;
echo "<FORM NAME=mainform METHOD=post ACTION=".$PHP_SELF." onSubmit='return ValidateForm()'>";

echo("<tr><td valign=top>");
include("inc/input_form_inc.php");
echo("</td></tr>");


?>
    <input type="hidden" name="tablename" value="<?php echo $header_table ?>">

          <tr><td>&nbsp;</td>





<tr><td colspan=8>
    <input class="gray" type="Submit" name="SEARCHQUERY" value="Search">
    <input class="gray" type="Submit" name="SUBMIT" value="Submit">
    <input class="gray" type="Submit" name="UPDATE" value="Update">
    <input class="gray" type="Submit" name="DELETE" value="Delete">
    <input class="gray" type="Submit" name="NEWQUERY" value="Clear">
    <input class="gray" type="Reset" name="Clear">
	<input type="hidden" name="tablename" value="<?php echo $tablename?>"></td>
	</tr>
<?
?>
</blockquote>
<?
echo "<tr><td>";
include "inc/form_expand.php";
echo "</td></tr>";
echo "<br>";
echo ("<tr><td colspan=8><a href=view_table.php?tablename=".$tablename.">".ucwords($tablename)." data</a></td></tr> ");

include "inc/footer_inc.php";

?>
  </form>
</table>
</body>
</HTML>
