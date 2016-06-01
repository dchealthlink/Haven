<?php
session_start();
include("inc/dbconnect.php");

session_unregister("query_value");

$show_menu = "ON";
include("inc/index_header_inc.php");
	
?>
<script language="javascript">
<!--
function submitform(form){
  var myindex=form.search_emp_id.selectedIndex;
  prim=form.search_emp_id.options[myindex].value;
  location="select_department_admin.php?search_emp_id="+prim;
  }

//-->
</script>
</head>

  <blockquote>
   <h1>Search Result</h1>

  <?php

if($SUBMIT) {

$numrecs = count($data_matrix);

/* print_r($data_matrix); */
for ($k = 0; $k < $numrecs; $k++) {
	if ($data_matrix[$k][0]) {

		$sql = "INSERT INTO department_admin values ('".$data_matrix[$k][1]."','".$data_matrix[$k][3]."','".$data_matrix[$k][4]."')"; 
	
  		$result = execSql($db, $sql, $debug);     
/*	showEcho($data_matrix[$k][0].'  -- ',$sql); */
	}
}

};


if($SUBMITALL) {
$numrecs = count($data_matrix);

for ($k = 0; $k < $numrecs; $k++) {

		$sql = "INSERT INTO department_admin values ('".$data_matrix[$k][1]."','".$data_matrix[$k][3]."','".$data_matrix[$k][4]."')"; 
	 $result = execSql($db, $sql, $debug);    
}

};


echo "<form method=post action=".$PHP_SELF.">"; 

/* ===== new =========== */

echo "<tr>";

echo "<td>Employee:&nbsp;&nbsp;";

$t_sql = "SELECT employee_id, last_name||', '||first_name FROM employee WHERE employee_type in ('admin','supervisor','su','reviewer') ORDER BY 2";

$t_result = execSql($db, $t_sql, $debug);

echo "<SELECT NAME=search_emp_id onChange=submitform(this.form)>";
echo"<option selected value=\"\">";


$rownum = 0;
        while ($row = pg_fetch_array($t_result,$rownum))
        {
                list($t_emp_id, $t_emp_name, $t_employee_type) = pg_fetch_row($t_result,$rownum);
                if ($search_emp_id == $t_emp_id) {
                        echo "<option SELECTED value=".$t_emp_id.">".$t_emp_name;
                } else {
                        echo "<option value=".$t_emp_id.">".$t_emp_name;
                }
        $rownum = $rownum + 1;
        }

echo "</SELECT></td></tr>";

/* ============ end new ============ */
$sql = "SELECT da.department_id, d.department_name, da.role_cd FROM department_admin da, department d  WHERE da.department_id = d.department_id AND  da.employee_id = '".$search_emp_id."' " ;

$list_label="N";
$orient="horizontal";
$link_reference="delete_department_admin.php?employee_id=".$search_emp_id."&department_id=";
echo "<tr><td><table width=750><tr><td valign=top width=50%><table>";

echo ("<tr><td>Selected Departments</td></tr>");
echo "<tr><td>";
include ("inc/view_form_inc.php");
echo "</td></tr>";

echo "</table></td>";

echo "<td valign=top width=50%><table>";

$sql = "SELECT employee_type FROM employee WHERE employee_id = '".$search_emp_id."'";
$result = execSql($db, $sql, $debug);
list ($t_employee_type) = pg_fetch_row($result,0);

switch ($t_employee_type) {

	case 'supervisor':
	case 'su':
	case 'admin':
		$app_type = 'Approver';
	break;
	case 'reviewer':
		$app_type = 'Reviewer';
	break;
}


$sql = "SELECT department_id, department_name, '".$search_emp_id."' as employee_id,'".$app_type."' as role_cd FROM department WHERE department_id NOT IN (SELECT department_id FROM department_admin WHERE employee_id = '".$search_emp_id."')"; 

$result = execSql($db, $sql, $debug);
$numrows = pg_numrows($result);
echo ("<tr><td>Department Information</td></tr>");
if ($numrows > 0) {
        $numfields = pg_numfields($result);
} else {
        echo ("<tr><td><b>No Rows Returned - possible error</b></td></tr>");
}
echo ("</td></tr>");
echo "<tr><td valign=top>";
echo "<table border=1>";
if ($result) {
        echo("\n<TR BGCOLOR=\"f5f5f5\">");
        echo ("<Td><b>Select</b></Td>");
        for ($i=0;$i<$numfields - 2;$i++) {
        $fldname = pg_fieldname($result,$i);
        $fldname = ereg_replace("_"," ",$fldname);
       	echo ("<Td><b>".(ucwords($fldname))."</b></Td>");
}

echo ("</TR>");
$color = "f5f5f5";

for ($i=0;$i<$numrows;$i++) {

        if (($i % 2) == 0) {
                echo ("\n<TR>");
        } else {
                echo ("\n<TR BGCOLOR=$color>");
        }
        $rowarr = pg_fetch_row($result,$i);

        echo "<Td>";

	echo "<input type=checkbox name=data_matrix[$i][0]>";
	echo "<input type=hidden name=data_matrix[$i][1] value='".$rowarr[0]."'>";
        echo "<input type=hidden name=data_matrix[$i][2] value='".$rowarr[1]."'>";
        echo "<input type=hidden name=data_matrix[$i][3] value='".$rowarr[2]."'>";
        echo "<input type=hidden name=data_matrix[$i][4] value='".$rowarr[3]."'>";
	echo "</Td>";

        for ($j=0;$j<$numfields - 2;$j++) {

		$ftype = pg_field_type($result,$j);
                $val = $rowarr[$j];
		
                if ($val == "") {
                        $val = "&nbsp;";
                }

                if (pg_fieldname($result,$j) == 'password')  {
                        echo "<td>**********</td>";
                } else {
			if (pg_fieldname($result,$j) == 'status') {
				$temp_status = $val;
			}
			if ($j == 0) {
 					echo "<td>".$val."</td>";  
			} else {
				if ($ftype == 'numeric') {
                        		echo "<td align=right>".$val."</td>";
				} else {
                        		echo "<td>".$val."</Td>";
				}
			}
                }

        }

echo ("</TR>");
}
echo "<tr><td colspan=2><b>Total Count</b></td><td align=right>".$numrows."</td></tr>";
echo ("</table>");
}

echo "</table></td>";

?>

</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>

    <input class="gray" type="Submit" name="NEWSEARCH" value="New Search">&nbsp;
    <input class="gray" type="Submit" name="SUBMIT" value="SUBMIT">&nbsp;
    <input class="gray" type="Submit" name="SUBMITALL" value="SUBMIT ALL">&nbsp;
    <input class="gray" type="Reset">&nbsp;
    <input type="hidden" name="department_id" value="<?php echo $department_id ?>">
    <input type="hidden" name="pay_period_num" value="<?php echo $pay_period_num ?>">


</td></tr>
</table>
    </p>
  </form>

</blockquote>
<?

include "inc/footer_inc.php";
?>
</body>
</table>
</HTML>
