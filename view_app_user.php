<?
session_start();
include("inc/dbconnect.php");

session_unregister("query_value");
if ($NEWSEARCH) {
	header("Location: view_app_user.php");
}

$show_menu = "ON";
include("inc/header_inc.php");
	
/* <HTML> */
?>
<script language="javascript">
<!--
function submitform(form){
  var myindex=form.search_department_id.selectedIndex;
  prim=form.search_department_id.options[myindex].value;
  location="view_app_user.php?department_id="+prim;
  }

//-->
</script>
</head>

  <blockquote>
   <h1>Application Users</h1>

  <?php

if (!$employee_id) {
	$employee_id = $key_value;
}


if($SUBMIT) {

$numrecs = count($data_matrix);

for ($k = 0; $k < $numrecs; $k++) {
	if ($data_matrix[$k][0]) {
                echo "<p>Updating: Employee_id = ".$data_matrix[$k][1]." to department_id = ".$department_id."</p>";

		$sql = "UPDATE employee_pay_log SET auth_timestamp = now(), auth_employee_id = '".$key_value."' WHERE employee_id ='".$data_matrix[$k][1]."' AND pay_cycle_id = '".$data_matrix[$k][3]."' AND pay_period_num = ".$data_matrix[$k][2];

		$result = execSql($db, $sql, $debug);  

	}
}

};


if($SUBMITALL) {
$numrecs = count($data_matrix);

for ($k = 0; $k < $numrecs; $k++) {
                echo "<p>Updating: Employee_id = ".$data_matrix[$k][1]." to department_id = ".$department_id."</p>";

		$sql = "UPDATE employee SET department_id = '".$department_id."' WHERE employee_id ='".$data_matrix[$k][1]."'";

		$result = execSql($db, $sql, $debug);  
}

};

/*
if ($employee_id) {

        $pgsql = "SELECT * from employee WHERE employee_id = '".$employee_id."'";

        $pgresult = execSql($db, $pgsql, $debug);

        $row = pg_fetch_array($pgresult, 0);

        $fieldnum = pg_numfields($pgresult);

        for($i=0;$i<$fieldnum; $i++) {
                $dummy=pg_fieldname($pgresult,$i);
                $$dummy=$row[pg_fieldname($pgresult,$i)];
        }

}
*/

echo "<form method=post action=".$PHP_SELF.">"; 


/* ===== new =========== */

echo "<table><tr>";


echo "<td><table>";

echo "<td>Department:</td>";

$t_sql = "SELECT department_id, department_name FROM department ";
switch ($usertype) {
        case "user":
        case "supervisor":
                $df_sql = "SELECT department_id FROM employee WHERE employee_id = '".$key_value."'";
                $df_result = execSql($db, $df_sql, $debug);
                list ($search_department_id) = pg_fetch_row ($df_result,0);
                $t_sql.=" WHERE department_id = '".$search_department_id."'";
                break;
        case "admin":
                $t_sql.=" WHERE department_id IN (SELECT department_id FROM department_admin WHERE employee_id = '".$key_value."') ";
                break;
        case "su";
                break;
        }

$t_sql.= " ORDER BY 2";

$t_result = execSql($db, $t_sql, $debug);

echo "<td><SELECT NAME=search_department_id onChange=submitform(this.form)>";
echo"<option selected value=\"\">";


$rownum = 0;
        while ($row = pg_fetch_array($t_result,$rownum))
        {
                list($t_department_id, $t_department_name) = pg_fetch_row($t_result,$rownum);
                if ($search_department_id == $t_department_id) {
                        echo "<option SELECTED value=".$t_department_id.">".$t_department_id." - ".$t_department_name;
                } else {
                        echo "<option value=".$t_department_id.">".$t_department_id." - ".$t_department_name;
                }
        $rownum = $rownum + 1;
        }

echo "</SELECT></td></table></td>";



echo "</tr>";


/* ============ end new ============ */

$sql = "SELECT user_id, user_name, user_type,  start_key as employee_id, user_level as level FROM app_user"; 

$header_table = "app_user";
$acc_method = "view";

$orient = "horizontal";

if ($department_id) { 
        $sql.=" WHERE start_key IN (SELECT employee_id AS start_key FROM employee WHERE department_id = '".$department_id."') ";
} ELSE {
        	$sql.=" WHERE start_key IN (SELECT employee_id AS start_key FROM employee WHERE department_id IN (SELECT department_id FROM department_admin WHERE employee_id = '".$key_value."')) ";

}


$link_reference="";
echo "<tr><td valign=top>";
include("inc/view_form_inc.php");
echo "</td></tr>";


echo ("</table>");

?>

</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>

    <input class="gray" type="Submit" name="NEWSEARCH" value="New Search">&nbsp;
    <input class="gray" type="Reset">&nbsp;


</td></tr>
    </p>
  </form>

</blockquote>
<?

include "inc/footer_inc.php";
?>
</body>
</table>
</HTML>
