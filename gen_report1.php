<?php
session_start();
include("inc/dbconnect.php");

if ($create_report) {

$create_report = "";
session_unregister("search_where");
session_register("search_where");
$search_where = " AND ";


$reportname = ereg_replace(".php","",$reportname);
$sql = "select r.report_url, p.report_parameter, p.report_parameter_value FROM report_menu r, report_menu_parameter p WHERE r.report_name = '".$reportname."' AND r.report_name = p.report_name and r.user_level <=".$userlevel;

$rownum = 0;
$result = execSql($db, $sql, $debug);
while ($row = pg_fetch_array($result,$rownum)) {

$report_url = $row[pg_fieldname($result,0)];
$report_param = $row[pg_fieldname($result,1)];
$$report_param = $row[pg_fieldname($result,2)];

$rownum = $rownum + 1;
}
if ($from_date AND !$to_date AND $report_date) {
        $search_where.= "( ".$report_date." >= '".$from_date."') AND ";
}
if ($to_date AND !$from_date AND $report_date) {
        $search_where.= "( ".$report_date." >= '".$to_date."') AND ";
}
if ($to_date AND $from_date AND $report_date) {
        $search_where.= "( ".$report_date." <= '".$to_date."' AND ".$report_date." >= '".$from_date."') AND ";
}
if ($account_type AND $report_account_type) {
        $search_where.= "( ".$report_account_type." = '".$account_type."') AND ";
}
if ($status AND $report_status) {
        $search_where.= "( ".$report_status." = '".$status."') AND ";
}
if ($gt_amt AND !$lt_amt AND $report_amount) {
        $search_where.= "( ".$report_amount."  >= ".$gt_amt.") AND ";
}
if ($lt_amt AND !$gt_amt AND $report_amount) {
        $search_where.= "( ".$report_amount." <= ".$lt_amt.") AND ";
}
if ($gt_amt AND $lt_amt AND $report_amount) {
        $search_where.= " (".$report_amount." >= ".$gt_amt." AND ".$report_amount." <= ".$lt_amt.") AND ";
}
if ($pay_method AND $report_pay_method) {
        $search_where.= "( ".$report_pay_method." = '".$pay_method."') AND ";
}
if ($report_employee_id) {
        $search_where.= "( ".$report_employee_id." = '".$userid."') AND ";
}
if ($module_id AND $report_module_id) {
        $search_where.= "( ".$report_module_id." = '".$module_id."') AND ";
}
if ($pay_period_num AND $report_pay_period_num) {
        $search_where.= "( ".$report_pay_period_num." = '".$pay_period_num."') AND ";
}
if ($pay_type AND $report_pay_type) {
        $search_where.= "( substr(".$report_pay_type.",5,1) like '%".$pay_type."%') AND ";
}



if ($search_where) {
        $search_where = substr($search_where,0,-5);
}


	header("Location: ".$report_url."?repparam=".$repparam);
}



include("inc/header_inc.php");
?>
<HTML>
<tr><td>
  <blockquote>
   <h1>Generate Report: <?php echo $rep_name ?></h1>

<!--  <form method="post" action="gen_report.php"> -->
 <form method="post" action="gen_report.php">

	<table border=0 cellspacing=0 cellpadding=2 bordercolor=#eeeeee width=600> 

        <tr><td>From Date (yyyymmdd):</td><td><input class=pink type=text name=from_date maxlength=10 size=11 value="<?php echo date('Ymd') ?>" onblur="BisDate(this,'N')"></td>
        <td>To Date (yyyymmdd):</td><td><input class=pink type=text name=to_date maxlength=10 size=11 value="<?php echo date('Ymd') ?>" onblur="BisDate(this,'N')"></td></tr>

<!--
    Start Date:</td><td>
    <input type="text" name="start" size="20" onblur="BisDate(this,'N')">
          </td><td>
    End Date:</td><td>
    <input type="text" name="end" size="20" onblur="BisDate(this,'N')">
          </td></tr><tr><td>
-->
    <tr><td>Report:</td><td>
<!--    <input type="text" name="repparam" size="20"> -->


  <select name="reportname">
  <option value="<? echo $reportname ?>" selected><? echo $reportname ?></option>
  <?
  $reportname_all = pg_exec($db,"SELECT report_name, report_desc, report_url from report_menu where user_level <= ".$userlevel." order by sort_order");
$rownum = 0;
  while ($reportname_row = pg_fetch_array($reportname_all, $rownum))
  {
  $item_description = $reportname_row["report_desc"];
  $item_cd = $reportname_row["report_name"];
  $item_translation = $reportname_row["report_url"];
$rownum = $rownum + 1;
  echo "<option value='$item_cd'>$item_description</option>";
  }
  ?>
  </select>

</td><td>
    Param:</td><td>
<!--    <input type="text" name="repparam" size="20"> -->


  <select name="repparam">
  <option value="<? echo $repparam ?>" selected><? echo $repparam ?></option>
  <?
  $date_param_all = pg_exec($db,"SELECT item_cd, item_description from app_lookup 
	WHERE lookup_table = 'date_param' and lookup_field = 'date_param'");
$rownum = 0;
  while ($date_param_row = pg_fetch_array($date_param_all, $rownum))
  {
  $item_description = $date_param_row["item_description"];
  $item_cd = $date_param_row["item_cd"];
$rownum = $rownum + 1;
  echo "<option value='$item_cd'>$item_description</option>";
  }
  ?>
  </select>

          </td></tr>
<?php

  $esql = "SELECT employee_id, last_name||',  '||first_name FROM employee WHERE employee_id = '".$userid."'";

	$esql.=" ORDER BY last_name, first_name ";

$eresult = execSql($db, $esql, $debug);
echo "<tr><td>Employee ID: </td><td>";

        echo"<select name=\"employee_id\">";
/*        echo"<option selected value=\"\">"; */
        $e_rownum=0;
while ($row = pg_fetch_array($eresult,$e_rownum))
{
        list($temp_emp_id, $temp_emp_name) = pg_fetch_row($eresult,$e_rownum);
                echo "<option value=".$temp_emp_id.">".$temp_emp_name;
        $e_rownum = $e_rownum + 1;
}
echo "</select></td>";




  $lcsql = "SELECT department_id, department_name FROM department ORDER BY department_id ";

$lcresult = execSql($db, $lcsql, $debug);
echo "<td>Department: </td><td>";

        echo"<select name=\"department_id\">";
        echo"<option selected value=\"\">";
        $l_rownum=0;
while ($row = pg_fetch_array($lcresult,$l_rownum))
{
        list($temp_resp_code, $temp_resp_desc) = pg_fetch_row($lcresult,$l_rownum);
                echo "<option value=".$temp_resp_code.">".$temp_resp_code." - ".$temp_resp_desc;
        $l_rownum = $l_rownum + 1;
}
echo "</select></td></tr>";



  $ppsql = "SELECT course_id, course_name FROM course ORDER BY 1";

$ppresult = execSql($db, $ppsql, $debug);
echo "<td>Course: </td><td>";

        echo"<select name=\"course_id\">";
        echo"<option selected value=\"\">";
        $p_rownum=0;
while ($row = pg_fetch_array($ppresult,$p_rownum))
{
        list($temp_course_id, $temp_course_name) = pg_fetch_row($ppresult,$p_rownum);
                echo "<option value=".$temp_course_id.">".$temp_course_name;
        $p_rownum = $p_rownum + 1;
}
echo "</select></td>";


  $ppsql = "SELECT module_id, module_name FROM module order by 1";

$ppresult = execSql($db, $ppsql, $debug);
echo "<td>Module: </td><td>";

        echo"<select name=\"module_id\">";
        echo"<option selected value=\"\">";
        $p_rownum=0;
                echo "<option value='_'> __ - All";
while ($row = pg_fetch_array($ppresult,$p_rownum))
{
        list($temp_module_id, $temp_module_name) = pg_fetch_row($ppresult,$p_rownum);
                echo "<option value=".$temp_module_id.">".$temp_module_name;
        $p_rownum = $p_rownum + 1;
}
echo "</select></td>";
echo "</tr>";



 echo "<tr><td colspan=6><B>Additional Information:</B></td></tr>";
/*
 echo "<tr><td>Amount Greater Than (>):</td><td><input class=pink type=text name=gt_amt maxlength=9 size=10></td>";
 echo "<td>Amount Less Than (<):</td><td><input class=pink type=text name=lt_amt maxlength=9 size=10></td></tr>";
 echo "<tr><td>Payment Type: </td><td>";

        echo"<select name=\"pay_method\">";
        echo"<option selected value=\"\">";

	$pay_method_all = pg_exec($db,"SELECT pay_method, pay_method_desc FROM pay_method ORDER BY sort_order");
	$rownum = 0;
  	while ($pay_method_row = pg_fetch_array($pay_method_all, $rownum)) {
		$item_description = $pay_method_row["pay_method_desc"];
		$item_cd = $pay_method_row["pay_method"];
		$rownum = $rownum + 1;
		echo "<option value='$item_cd'>$item_description</option>";
	}

echo "</select></td>";
$cashsql ="SELECT cashier_id, cashier_name FROM cashier WHERE cashier_status = 'A' ORDER BY 1";

$cashresult = execSql($db, $cashsql, $debug);
echo "<td>Cashier: </td><td>";

        echo"<select name=\"cashier_id\">";
        echo"<option selected value=\"\">";
        $l_rownum=0;
while ($row = pg_fetch_array($cashresult,$l_rownum))
{
        list($temp_cashier_id, $cashier_name) = pg_fetch_row($cashresult,$l_rownum);
        if ($cashier_id == $temp_cashier_id) {
                echo "<option selected value=".$temp_cashier_id.">".$temp_cashier_id." - ".$cashier_name;
        } else {
                echo "<option value=".$temp_cashier_id.">".$temp_cashier_id." - ".$cashier_name;
        }
        $l_rownum = $l_rownum + 1;
}
echo "</select></td></tr>";
*/
?>

<!-- </table> -->
<br>
<!--	<table border=0 cellspacing=0 cellpadding=2 bordercolor=#eeeeee width=600> -->
<?
  /*  <tr><td align=center><b><a href='' onClick="javascript:$report=calls_by_account">Calls by Account</a></b></td> */
?>

<?

$sql="SELECT * from app_lookup where lookup_table = 'report_menu' order by sort_order";

$result = pg_exec($db,$sql);
if(pg_ErrorMessage($db))
        {
        if ($debug) {
                DisplayErrMsg(sprintf("Error in executing %s statement", $sql)) ;
        }
        DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
        };


echo "<br>";
$rownum = 0;
/* echo "<table border=0 cellspacing=0 cellpadding=2 bordercolor=#eeeeee width=600>";
*/

while ($row = pg_fetch_array($result,$rownum))
{
$test=$row[pg_fieldname($result,0)];

echo "<tr><td align=center colspan=2><b><a href='".$row[pg_fieldname($result,4)]."'>".$row[pg_fieldname($result,2)]."</a></b></td><td colspan=2>".$row[pg_fieldname($result,3)]."</td></tr>";

$rownum = $rownum + 1;
}

$sql="SELECT * from user_query where user_id='".$userid."' order by query_name";

$result = pg_exec($db,$sql);
if(pg_ErrorMessage($db))
        {
        if ($debug) {
                DisplayErrMsg(sprintf("Error in executing %s statement", $sql)) ;
        }
        DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
        };


echo "<br>";
$rownum = 0;

while ($row = pg_fetch_array($result,$rownum))
{
$test=$row[pg_fieldname($result,0)];

echo "<tr><td align=center colspan=2><b><a href='run_user_query.php?query_name=".$row[pg_fieldname($result,1)]."'>".$row[pg_fieldname($result,1)]."</a></b></td><td colspan=2>".$row[pg_fieldname($result,2)]."</td></tr>";

$rownum = $rownum + 1;
}


?>




    <tr><td align=center colspan=2><b>---------------</a></b></td><td align=left colspan=2>------------------------------</td></tr>

    <tr><td align=center colspan=2><b><a href='gen_select.php'>Generic Query</a></b></td>
	<td colspan=2>Create a Generic Query</td></tr>
    <tr><td align=center colspan=2><b>Other Reports</b><td colspan=2>TBD</b></td>
    </tr>


    <tr>
    <td colspan=2><input class="gray" type="Submit" name="create_report" value="Create Report"></td></tr>
</table>
    </p>
  </form>
</blockquote>
<?

include "inc/footer_inc.php";
?>
</body>
</HTML>
