<?php
session_start();
include("inc/dbconnect.php");
if ($usertype == 'biz') {
	$search_usr_id = $userid;
	$withsearch = " WHERE user_id = '".$userid."'";
} else {
if ($_GET['search_usr_id']) {
	$search_usr_id = $_GET['search_usr_id'];
}
if ($_POST['search_usr_id']) {
	$search_usr_id = $_POST['search_usr_id'];
}
}

// session_unregister("query_value");

$show_menu = "ON";
include("inc/index_header_inc.php");
	
?>
<script language="javascript">
<!--
function submitform(form){
  var myindex=form.search_user_id.selectedIndex;
  prim=form.search_user_id.options[myindex].value;
  location="select_mitc_response.php?search_usr_id="+prim;
  }

//-->
</script>
</head>

  <blockquote>
   <h1>MITC Response Type by User</h1>

  <?php

if($SUBMIT) {

	$numrecs = count($data_matrix);

//	$search_usr_id = $data_matrix[0][4] ;
	for ($k = 0; $k < $numrecs; $k++) {
		if ($data_matrix[$k][0]) {
			$sql = "INSERT INTO  mitc_response_type_list_user values ('".$data_matrix[$k][3]."','".$data_matrix[$k][1]."','Y' )"; 
  			$result = execSql($db, $sql, $debug);     
		}
	}

};


if($SUBMITALL) {
	$numrecs = count($data_matrix);

	$search_usr_id = $data_matrix[0][4] ;
	for ($k = 0; $k < $numrecs; $k++) {
		$sql = "INSERT INTO mitc_response_type_list_user values ('".$data_matrix[$k][3]."','".$data_matrix[$k][1]."','Y')"; 
		$result = execSql($db, $sql, $debug);    
	}

};


echo "<form method=post action=".$PHP_SELF.">"; 

/* ===== new =========== */

echo "<tr>";

echo "<td>User:&nbsp;&nbsp;";


$t_sql = "SELECT user_id, user_name FROM app_user ".$withsearch;
$t_sql.= " ORDER BY user_name";

$t_result = execSql($db, $t_sql, $debug);

echo "<SELECT NAME=search_user_id onChange=submitform(this.form)>";
echo"<option selected value=\"\">";


$rownum = 0;
        while ($row = pg_fetch_array($t_result,$rownum))
        {
                list($t_usr_id, $t_usr_name) = pg_fetch_row($t_result,$rownum);
                if ($search_usr_id == $t_usr_id) {
                        echo "<option SELECTED value='".$t_usr_id."'>".$t_usr_name;
                } else {
                        echo "<option value='".$t_usr_id."'>".$t_usr_name;
                }
        $rownum = $rownum + 1;
        }

echo "</SELECT></td></tr>";

/* ============ end new ============ */
$sql = "SELECT  a.response_type, a.display_flag, a.user_id, u.user_name  FROM mitc_response_type_list_user a, app_user u  WHERE a.user_id = u.user_id and a.user_id = '".$search_usr_id."' " ;

$list_label="N";
$orient="horizontal";
$link_reference="delete_mitc_response.php?uid=".(urlencode($search_usr_id))."&rtype=";
echo "<tr><td><table width=950><tr><td valign=top width=50%><table>";

echo ("<tr><td>Selected Response Types</td></tr>");
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


$sql = "SELECT response_type,  display_flag as default, '".$search_usr_id."' as usr_id FROM mitc_response_type_list WHERE coalesce(display_flag,'N') != 'X' and response_type NOT IN (SELECT response_type FROM mitc_response_type_list_user WHERE user_id = '".$search_usr_id."') ORDER BY 1"; 


$result = execSql($db, $sql, $debug);
$numrows = pg_numrows($result);
echo ("<tr><td>Response Types</td></tr>");
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
        for ($i=0;$i<$numfields - 1;$i++) {
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

        for ($j=0;$j<$numfields - 1;$j++) {

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
echo "<tr><td colspan=2><b>Total Count</b></td><td colspan=1 align=right>".$numrows."</td></tr>";
echo ("</table>");
}

echo "</table></td>";

?>

</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>

    <input class="gray" type="Submit" name="SUBMIT" value="SUBMIT">&nbsp;
    <input class="gray" type="Submit" name="SUBMITALL" value="SUBMIT all">&nbsp;
    <input class="gray" type="Reset">&nbsp;
    <input type="hidden" name="search_usr_id" value="<?php echo $search_usr_id ?>">
    <input type="hidden" name="pay_period_num" value="<?php echo $pay_period_num ?>">


</td></tr>

<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>

<?
/*
$sql = "SELECT pm.program_id, pm.module_id,  p.program_name, m.module_name FROM program_module pm , program p, module m  WHERE pm.program_id = p.program_id and pm.module_id = m.module_id and  mu.module_id = '".$search_mod_id."' " ;

$list_label="N";
$orient="horizontal";
$link_reference="select_program_module.php?search_prog_id=";
echo "<tr><td valign=top colspan=2><table>";

echo ("<tr><td>Courses Contained in Program(s):</td></tr>");
echo "<tr><td>";
include ("inc/view_form_inc.php");
echo "</td></tr>";

echo "</table></td></tr>";
*/
?>





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
