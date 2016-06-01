<?php
session_start();
include("inc/dbconnect.php");

$show_menu="ON";

if ($create_report) {

$create_report = "";
$search_where = "";
// session_unregister("search_where");
// session_register("search_where");
$search_where = " AND ";
$_SESSION['search_where'] = $search_where ;

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


$repname = basename($report_url,'.php');
$searchcriteria = "?rn=".$repname;

if ($from_date AND !$to_date AND $report_date) {
        $search_where.= "( ".$report_date." >= '".$from_date."') AND ";
	$searchcriteria.= "&ctms=".$from_date;
}
if ($to_date AND !$from_date AND $report_date) {
        $search_where.= "( ".$report_date." <= '".$to_date."') AND ";
	$searchcriteria.= "&ctme=".$to_date;
}
if ($to_date AND $from_date AND $report_date) {
        $search_where.= "( ".$report_date." <= '".$to_date."' AND ".$report_date." >= '".$from_date."') AND ";
	$searchcriteria.= "&ctms=".$from_date."&ctme=".$to_date;
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
if ($employee_id AND $report_employee_id) {
        $search_where.= "( ".$report_employee_id." = '".$employee_id."') AND ";
	$searchcriteria.="&ei=".$employee_id;
}
if ($department_id AND $report_department_id) {
        $search_where.= "( ".$report_department_id." = '".$department_id."') AND ";
	$searchcriteria.="&di=".$department_id;
}
if ($module_id AND $report_module_id) {
        $search_where.= "( ".$report_module_id." = '".$module_id."') AND ";
	$searchcriteria.="&mi=".$module_id;
}
if ($course_id AND $report_course_id) {
        $search_where.= "( ".$report_course_id." = '".$course_id."') AND ";
	$searchcriteria.="&ci=".$course_id;
}
if ($pay_period_num AND $report_pay_period_num) {
        $search_where.= "( ".$report_pay_period_num." = '".$pay_period_num."') AND ";
}
if ($pay_type AND $report_pay_type) {
        $search_where.= "( substr(".$report_pay_type.",5,1) like '%".$pay_type."%') AND ";
}

if ($appl_id AND $report_appl_id) {
        $search_where.= "( ".$report_appl_id." = '".$appl_id."') AND ";
}


if ($search_where) {
        $search_where = substr($search_where,0,-5);
}

	if (substr($report_url,0,4) == 'leg-') {
		header("Location: leg-generic.php".$searchcriteria);
	} else {
		header("Location: ".$report_url."?repparam=".$repparam);
	}
}



$show_menu="ON";
 include("inc/index_header_inc.php"); 
?>
<HTML>
<head>
<script language = "Javascript">
function checkAll()
{
	alert('cheez');
}
</script>
</head>
<tr><td>
  <blockquote>
   <h1>Generate Report: <?php echo $rep_name ?></h1>

<!--  <form method="post" action="gen_report.php"> -->
 <form name="mainform" method="post" action="gen_report.php">

	<table border=0 cellspacing=0 cellpadding=2 bordercolor=#eeeeee width=600> 

        <tr><td>From Date (yyyymmdd):</td><td><input class=pink type=text name=from_date maxlength=10 size=11 onblur="BisDate(this,'N')"></td>
        <td>To Date (yyyymmdd):</td><td><input class=pink type=text name=to_date maxlength=10 size=11 value="<?php echo date('Ymd') ?>" onblur="BisDate(this,'N')"></td></tr>
<!--
        <tr><td>Date Type:</td><td>
  	<select name="datetype">
	</select>
	</td></tr>
-->	
<!--
    Start Date:</td><td>
    <input type="text" name="start" size="20" onblur="BisDate(this,'N')">
          </td><td>
    End Date:</td><td>
    <input type="text" name="end" size="20" onblur="BisDate(this,'N')">
          </td></tr><tr><td>
-->
    <tr><td>Report:
<?php
 echo "<img src='images/btn_tinyquestion.gif' ALT=\"What's This?\" onClick=\"javascript:window.open('view_report_parameter.php?report_name='+mainform.reportname.value, 'listWindow', 'screenX=300,screenY=300,width=700,height=400,scrollbars'); return false;\"></td><td>";

?>


  <select name="reportname" onChange="checkAll()\">
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

        <tr><td>First Name:</td><td><input class=pink type=text name=firstname maxlength=30 size=15"></td>
        <td>Last Name:</td><td><input class=pink type=text name=lastname maxlength=30 size=15"></td></tr>

 <tr><td>Application Name:</td><td colspan=3><input class=pink type=text name=applname maxlength=80 size=50></td>
</tr>


    <tr><td>State:</td><td>

  <select name="statecd" onChange="checkAll()\">
  <?
  $state_all = pg_exec($db,"SELECT state, state_name from states  order by sort_order");
$rownum = 0;
  while ($reportname_row = pg_fetch_array($state_all, $rownum))
  {
  $item_description = $reportname_row["state_name"];
  $item_cd = $reportname_row["state"];
  $item_translation = $reportname_row["state"];
$rownum = $rownum + 1;
  echo "<option value='$item_cd'>$item_description</option>";
  }
  ?>
  </select>

</td>

<?php
 echo "<td>Application Year:</td><td>";
$emsql = "SELECT item_cd, item_description from app_lookup WHERE lookup_table = 'generic' and lookup_field = 'appyear'";

$emresult = execSql($db, $emsql, $debug);

        echo"<select name=\"appYear\">";
        echo"<option selected value=\"\">";
        $em_rownum=0;

while ($row = pg_fetch_array($emresult,$em_rownum))
{
        list($user_type, $user_type_desc) = pg_fetch_row($emresult,$em_rownum);
        if ($user_type == $employee_type ) {
                echo "<option value=".$user_type." SELECTED>".$user_type_desc;
        } else {
                echo "<option value=".$user_type.">".$user_type_desc;
        }
        $em_rownum = $em_rownum + 1;
}

 echo "</td></tr>";






  $esql = "SELECT personid, personlastname||',  '||personfirstname FROM person ";
  $esql.=" ORDER BY personlastname, personfirstname ";

$eresult = execSql($db, $esql, $debug);
echo "<tr><td>Applicant: </td><td>";

        echo"<select name=\"personid\">";
	
	if ($usertype == 'admin' or $usertype == 'su' or $usertype == 'supervisor' or $usertype == 'support') {
        	echo"<option selected value=\"\">";
	}
        $e_rownum=0;
while ($row = pg_fetch_array($eresult,$e_rownum))
{
        list($temp_emp_id, $temp_emp_name) = pg_fetch_row($eresult,$e_rownum);
                echo "<option value=".$temp_emp_id.">".$temp_emp_name;
        $e_rownum = $e_rownum + 1;
}
echo "</select></td>";

 echo "<td>Application ID:</td><td><input class=pink type=text name=appl_id maxlength=15 size=10></td></tr>";

/*

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
while ($row = pg_fetch_array($ppresult,$p_rownum))
{
        list($temp_module_id, $temp_module_name) = pg_fetch_row($ppresult,$p_rownum);
                echo "<option value=".$temp_module_id.">".$temp_module_name." (".$temp_module_id.")";
        $p_rownum = $p_rownum + 1;
}
echo "</select></td>";
echo "</tr>";
*/


 echo "<tr><td colspan=6>&nbsp;</td></tr>";
 echo "<tr><td colspan=6>&nbsp;</td></tr>";
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

<?
	if ($usertype == 'su' or $usertype == 'admin') {
?>
    <tr><td align=center colspan=2><b><a href='gen_select.php'>Generic Query</a></b></td>
	<td colspan=2>Create a Generic Query</td></tr>
    <tr><td align=center colspan=2><b>Other Reports</b><td colspan=2>TBD</b></td>
    </tr>
<?
	}
?>


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
