<?
session_start();
include("inc/dbconnect.php");

session_unregister("query_value");
if ($MENU) {
	header("Location: view_admin.php");
}

$show_menu = "ON";
include("inc/header_inc.php");
	
/* <HTML> */
?>
<script language="javascript">
<!--
function submitform(form){
  var myindex=form.department_id.selectedIndex;
  prim=form.department_id.options[myindex].value;
  location="select_department_message_mult.php?department_id="+prim;
  form.employee_id.focus();
  }
function ValidateForm(){
        var dept_id=document.mainform.department_id

	if (document.mainform.whichbutton.value != 'Menu') {

        if ((dept_id.value==null)||(dept_id.value=="")){
                alert("Please Enter a Department ID")
                dept_id.focus()
                return false
        }
	}
        return true
 }

//-->
</script>
</head>

  <blockquote>
   <h1>Department Data</h1></td></tr>
<tr><td>&nbsp;<?php echo $message_data ?></td></tr>
  <?php


$header_table = "employee";
$acc_method = "view";
$header_where_clause = " where table_name = 'employee' and access_type = 'view' ";
$where_clause = " where table_name = 'employee' ";
$num_rows = count_table_field_access ($db, $header_table ,$where_clause);
echo "<FORM NAME=mainform METHOD=post ACTION=submit_department_message_mult.php onSubmit='return ValidateForm()'>";
echo "<tr><td>Department ID:&nbsp;";

$dpt_sql = "SELECT department_id, department_name FROM department ";
switch ($usertype) {
        case "su":
                break;
        case "admin":
                $dpt_sql.=" WHERE department_id IN (SELECT department_id FROM department_admin WHERE employee_id =  '".$key_value."') ";
                break;
        case "supervisor":
        case "user":
                $df_sql = "SELECT department_id FROM employee WHERE employee_id = '".$key_value."'";
                $df_result = execSql($db, $df_sql, $debug);
                list ($search_department_id) = pg_fetch_row ($df_result,0);
                $dpt_sql.=" WHERE department_id = '".$search_department_id."'";
                break;
        case "other":
                $search_employee_id = $key_value;
                $dpt_sql.=" WHERE employee_id = '".$search_employee_id."'";
                break;
        }




$dpt_sql.= " ORDER BY 2";

$dpt_result = execSql($db, $dpt_sql, $debug);

echo "<SELECT NAME=department_id onChange=submitform(this.form)>";
echo"<option selected value=\"\">";

$rownum = 0;
        while ($row = pg_fetch_array($dpt_result,$rownum))
        {
                list($t_dept_id, $t_dept_name) = pg_fetch_row($dpt_result,$rownum);
                if ($department_id == $t_dept_id) {
                        echo "<option SELECTED value=".$t_dept_id.">".$t_dept_name;
                } else {
                        echo "<option value=".$t_dept_id.">".$t_dept_name;
                }
        $rownum = $rownum + 1;
        }

echo "</SELECT>";

$e_sql = "SELECT employee_id, last_name||', '||first_name FROM employee WHERE department_id = '".$department_id."' ORDER BY 2 ";

$e_result = execSql($db, $e_sql, $debug);

echo "&nbsp;&nbsp;Employee:&nbsp;";
echo "<SELECT NAME=employee_id>";
echo "<option SELECTED value=ALL>ALL";

$rownum = 0;
        while ($row = pg_fetch_array($e_result,$rownum))
        {
                list($t_employee_id, $t_full_name) = pg_fetch_row($e_result,$rownum);
                echo "<option value=".$t_employee_id.">".$t_full_name;
        $rownum = $rownum + 1;
        }

echo "</SELECT></td>";

echo "<tr><td><table>";

if($SUBMIT) {

$numrecs = count($data_matrix);

for ($k = 0; $k < $numrecs; $k++) {
	if ($data_matrix[$k][10]) {
                echo "<p>Inserting: message_id = ".$data_matrix[$k][0]." department_id = ".$department_id."  employee_id= ".$employee_id."</p>";

		$sql = "INSERT INTO department_message (department_id, employee_id, message_id, msg_start_date, msg_end_date, msg_start_time, msg_end_time, on_xa) VALUES ('".$department_id."','".$employee_id."','".$data_matrix[$k][0]."','".$data_matrix[$k][2]."','";
		$sql.= $data_matrix[$k][3]."','".$data_matrix[$k][4]."','";
		$sql.= $data_matrix[$k][5]."','".$data_matrix[$k][6]."')";
		$sql = ereg_replace("''","null",$sql);


		showEcho('',$sql);
 		$result = execSql($db, $sql, $debug);   
	}
}

};


if($SUBMITALL) {
$numrecs = count($data_matrix);

for ($k = 0; $k < $numrecs; $k++) {
                echo "<p>Inserting: message_id = ".$data_matrix[$k][0]." department_id = ".$department_id."  employee_id= ".$employee_id."</p>";

		$sql = "INSERT INTO department_message (department_id, employee_id, message_id, msg_start_date, msg_end_date, msg_start_time, msg_end_time, on_xa) VALUES ('".$department_id."','".$employee_id."','".$data_matrix[$k][0]."','".$data_matrix[$k][2]."','";
		$sql.= $data_matrix[$k][3]."','".$data_matrix[$k][4]."','";
		$sql.= $data_matrix[$k][5]."','".$data_matrix[$k][6]."')";
		$sql = ereg_replace("''","null",$sql);

		$result = execSql($db, $sql, $debug);  
}

};


if($submitsave)
{

};


/* ===== new =========== */

echo "<table><tr>";

echo "<tr><td>&nbsp;</td></tr>";

echo "</table>";


/* ============ end new ============ */



/*
if (!$settle_search_where) {
	$settle_search_where = " 1 = 1 "; 
}
*/
$sql = "SELECT message_id, message_desc FROM message ORDER BY message_id";

$result = execSql($db, $sql, $debug);

        $numrows = pg_numrows($result);
echo ("<tr><td>Message Information</td></tr>");
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
        for ($i=0;$i<$numfields;$i++) {
        $fldname = pg_fieldname($result,$i);
        $fldname = ereg_replace("_"," ",$fldname);
        echo ("<Td><b>".(ucwords($fldname))."</b></Td>");
}

        echo ("<Td><b>Start Date</b></Td>");
        echo ("<Td><b>End Date</b></Td>");
/*        echo ("<Td><b>Start Time</b></Td>");
        echo ("<Td><b>End Time</b></Td>"); */
        echo ("<Td><b>On Transaction</b></Td>");
        echo ("<Td><b>Device Id</b></Td>");
echo ("</TR>");
$color = "f5f5f5";

for ($i=1;$i<=$numrows;$i++) {

        if (($i % 2) == 0) {
                echo ("\n<TR>");
        } else {
                echo ("\n<TR BGCOLOR=$color>");
        }
        $rowarr = pg_fetch_row($result,($i - 1));
/* radio button */
        echo ("<Td><input type=radio name=select_radio value=".$i."></Td>");

        for ($j=0;$j<$numfields;$j++) {

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
				if ($numrows > 1) {
 					echo "<td>".$val;  
 					/* echo "<td><a href=search_payment_gen.php?xa_id=".$val.">".$val."</a>";   */
					echo "<input type=hidden name=data_matrix[$i][$j] value='".$rowarr[$j]."'></Td>";
				} else {
 					echo "<td>";  
					echo "<input type=hidden name=data_matrix[$i][$j] value='".$val."'>".$rowarr[$j]."</Td>";
/*				echo "<td>".$val."</td>";  */

				}
				$temp_xa_id = $val;
			} else {
				if ($ftype == 'numeric') {
                        		echo "<td align=right>".$val."</td>";
                        		/* echo "<td align=right><input class=pink type=text name=data_matrix[$i][$j] value=".$val."></td>"; */
				} else {
                        		echo "<td>".$val."</td>";
                        		/* echo "<td><input class=pink type=text name=data_matrix[$i][$j] value='".$val."'></Td>"; */
				}
			}
                }

        }

                     echo "<td><input class=pink type=text name=data_matrix[$i][$j] value='".$msg_start_date."' size=12 maxlength=10 onBlur=\"BisDate(this,'N')\"></td>";
			$j=$j+1;
                     echo "<td><input class=pink type=text name=data_matrix[$i][$j] value='".$msg_end_date."' size=12 maxlength=10 onBlur=\"BisDate(this,'N')\"></td>";
			$j=$j+1;
/*                     echo "<td><input class=pink type=text name=data_matrix[$i][$j] value='".$msg_start_time."' size=10 maxlength=8 onBlur=\"BisTime(this,'N')\"></td>";
			$j=$j+1;
                     echo "<td><input class=pink type=text name=data_matrix[$i][$j] value='".$msg_end_time."' size=10 maxlength=8></td>";
			$j=$j+1;
*/
                      echo "<td><SELECT NAME=data_matrix[$i][$j]>";
			echo "<option selected value=A>All";
                        echo "</SELECT></td>";
			$j=$j+1;
                      echo "<td><SELECT NAME=data_matrix[$i][$j]>";
			echo "<option selected value=A>All";

$d_sql = "SELECT device_id FROM device WHERE status = 'A' ORDER BY device_id ";

$drownum = 0;
                $d_result = execSql($db, $d_sql, $debug);
		while ($row = pg_fetch_array($d_result, $drownum)) {
                	list ($ddevice_id) = pg_fetch_row ($d_result, $drownum);
			echo "<option value=".$ddevice_id.">".$ddevice_id;
			$drownum = $drownum + 1;
		}
                        echo "</SELECT></td>";
;
echo ("</TR>");
}
echo "<tr><td colspan=4><b>Total Count</b></td><td colspan=4>&nbsp;</td><td align=right>".$numrows."</td></tr>";
echo ("</table>");
}

?>

</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>

    <input class="gray" type="Submit" name="SUBMIT" value="SUBMIT">&nbsp;
    <input class="gray" type="Reset">&nbsp;
    <input type="hidden" name="dm_employee_id" value="<?php echo $key_value ?>">
    <input type="hidden" name="dm_timestamp" value="<?php echo date("Y-m-d h:i:s") ?>">
    <input type="hidden" name="whichbutton" value="none" >



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
