<?php
session_start();
include("inc/dbconnect.php");
// session_unregister("query_value");
$_SESSION['query_value'] = '';
// session_unregister("search_where");
$_SESSION['search_where'] = '';
if ($NEWSEARCH) {
header("Location: employee_menu.php");
}
if ($ACCRUAL) {
header("Location: insert_accrual.php?employee_id=".$employee_id);
}
if ($ALLOCATE) {
header("Location: allocate_employee_set.php?employee_id=".$employee_id);
}

$show_menu = "ON";
include("inc/index_header_inc.php");
	
?>
<HTML>
<script language="javascript">
<!--
function submitform(form){
  var myindex=form.department_id.selectedIndex;
  prim=form.department_id.options[myindex].value;
  location="search_employee_result.php?department_id="+prim;
  }
function selectEmployeeOnly(employee_id){
 window.opener.mainform.employee_id.value=employee_id;
 window.close();
}
//-->
</script>
</head>

  <blockquote>
   <h1>Search Result</h1>
  <?php

if($submitsave)
{

	$sql1 = "INSERT INTO user_query VALUES ('".$userid."','".$query_name."','".$query_description."','".$query_value."')";

	$result = execSql($db, $sql1,$debug);

		if ($result != 'error') {
			echo "<p>Query : <b>".$query_name."</b> has been saved</p>";
		}
};

  /* <form method="post" action="<?php echo $PHP_SELF?>"> */

echo "<form method=post action=".$PHP_SELF.">"; 

echo "<tr><td>Department ID:&nbsp;";

$dpt_sql = "SELECT department_id, department_name FROM department ";
include ("user_select_inc.php");
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

echo "</SELECT></td>";

if (!$search_where) {
 	$search_where = "1 = 1 "; 
}

$sql = "SELECT employee_id, last_name, first_name, employee_type, city, state, zip_code, phone, department_id, verbose_flag, email, hire_date FROM employee WHERE ".$search_where;

if ($department_id) {
	$sql.=" AND (department_id = '".$department_id."') ";
}


$sql.=" ORDER BY last_name, first_name limit 1000";

$result = execSql($db, $sql, $debug);

        $numrows = pg_numrows($result);
echo ("<tr><td>Employee Information</td></tr>");
if ($numrows > 0) {
        $numfields = pg_numfields($result);
} else {
        echo ("<tr><td><b>No Rows Returned</b></td></tr>");
}
echo ("</td></tr>");
echo "<tr><td valign=top>";
if ($numrows > 0) {
	echo "<table border=1>";
        echo("\n<TR BGCOLOR=\"f5f5f5\">");
	if ($calling == 'populate') {
		echo "<td>&nbsp;</td>";
	}
        for ($i=0;$i<$numfields;$i++) {
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
					if ($calling == 'populate') {
						echo "<td><input class=gray type=button name=choose value=select onClick=\"selectEmployeeOnly('".$val."');\"></td>";
						echo "<td>".$val."</td>"; 
					} else {
						echo "<td><a href=search_employee_gen.php?employee_id=".$val.">".$val."</a></td>"; 
					}

				} else {
					echo "<td><a href=insert_employee.php?employee_id=".$val.">".$val."</a></td>"; 
					
				}
				$temp_employee_id = $val;
			} else {
				if ($ftype == 'numeric') {
                        		echo "<td align=right>$val</td>";
				} else {
                        		echo "<td>".$val."</td>";
				}
			}
                }

        }
echo ("</TR>");
}
echo ("</table>");
}


if ($numrows==1) {
$chckrow=1;

$employee_id = $rowarr[0];

$sql="SELECT cu.course_id, c.course_name, cu.course_init_date as init_date, cu.course_spoil_date as spoil_date, cu.num_modules, cu.modules_passed as passed, cu.module_retakes as retakes, cu.status, cu.course_start_date as start_date, cu.course_end_date as end_date FROM course_user cu, course c WHERE cu.course_id = c.course_id AND cu.user_id = '".$employee_id."'  AND cu.status != 'I' ORDER BY 1  ";

$result = execSql($db, $sql, $debug);
        $numrows = pg_numrows($result);

echo ("<tr><td>&nbsp;</td></tr>");
echo ("<tr><td>Course Information</td></tr>");

if ($result) {
        $numfields = pg_numfields($result);
} else {
        echo ("<tr><td><b>No Rows Returned</b></td></tr>");
}
 echo "<tr><td valign=top>";
if ($numrows > 0) {
	echo "<table border=1>";
        echo("\n<TR BGCOLOR=\"f5f5f5\">");
        for ($i=0;$i<$numfields;$i++) {
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
        for ($j=0;$j<$numfields;$j++) {
		$ftype = pg_field_type($result,$j);
                $val = $rowarr[$j];
                if ($val == "" or $val == "  ") {
                        $val = "&nbsp;";
                }

                if (pg_fieldname($result,$j) == 'password')  {
                        echo "<td>**********</td>";
                } else {
				if ($ftype == 'numeric') {
                        		echo "<td align=right>$val</td>";
				} else {
                        		echo "<td>".$val."</td>";
				}
                }

        }

echo ("</TR>");
}
echo ("</table>");
}

/* === open_log ==== */

$sql="SELECT cu.course_id, c.course_name, cu.course_init_date as init_date, cu.course_spoil_date as spoil_date, cu.num_modules, cu.modules_passed as passed, cu.module_retakes as retakes, cu.course_start_date, cu.course_user_instance FROM course_user cu, course c WHERE cu.course_id = c.course_id AND cu.user_id = '".$employee_id."'  AND cu.status = 'I' ORDER BY 1  ";
$result = execSql($db, $sql, $debug);

echo ("<tr><td>&nbsp;</td></tr>");
echo ("<tr><td>Open Module Information</td></tr>");
        $numrows = pg_numrows($result);

if ($result) {
        $numfields = pg_numfields($result);
} else {
        echo ("<tr><td><b>No Rows Returned</b></td></tr>");
}
echo ("</td></tr>");
echo "<tr><td valign=top>";
if ($numrows > 0) {
	echo "<table border=1>";
        echo("\n<TR BGCOLOR=\"f5f5f5\">");
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
        for ($j=0;$j<$numfields - 1;$j++) {
		$ftype = pg_field_type($result,$j);
                $val = $rowarr[$j];
                if ($val == "" or $val == "  ") {
                        $val = "&nbsp;";
                }

		switch (pg_fieldname($result,$j)) {

		case 'password':
                        echo "<td>**********</td>";
			break;
		default:
			if ($ftype == 'numeric') {
                       		echo "<td align=right>$val</td>";
			} else {
				if ($j == 0) {
				 	echo "<td><a href=review_course.php?uid=".$xa_id."&cui=".$rowarr[8]."&cid=".$val.">$val</a></td>"; 
				} else  {
                       			echo "<td>$val</td>";
				}
			}
		}

        }
echo ("</TR>");
}
echo ("</table>");
}

/* === pay_bill_log ==== */
/*
$sql="SELECT pay_seq as sequence, account_id, bill_id, account_type, payment_amount, status, pay_method, post_date, cash_drawer_id, bill_year, xa_pay_bill_seq as bill_seq FROM xa_pay_bill_log WHERE xa_id = '".$xa_id."' ORDER BY pay_seq, bill_id";
$result = execSql($db, $sql, $debug);
        $numrows = pg_numrows($result);
echo ("<tr><td>&nbsp;</td></tr>");
echo ("<tr><td>Bill Payment Information</td></tr>");

if ($result) {
        $numfields = pg_numfields($result);
} else {
        echo ("<tr><td><b>No Rows Returned - possible error</b></td></tr>");
}
echo ("</td></tr>");
echo "<tr><td valign=top>";
echo "<table border=1>";
if ($result) {
        echo("\n<TR BGCOLOR=\"f5f5f5\">");
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
        for ($j=0;$j<$numfields - 1;$j++) {
                $ftype = pg_field_type($result,$j);
                $val = $rowarr[$j];
                if ($val == "" or $val == "  ") {
                        $val = "&nbsp;";
                }

                switch (pg_fieldname($result,$j)) {

                case 'password':
                        echo "<td>**********</td>";
                        break;
                default:
                        if ($ftype == 'numeric') {
                                echo "<td align=right>$val</td>";
                        } else {
                                echo "<td>$val</td>";
                        }
                }


        }
echo ("</TR>");
}
echo ("</table>");
}
*/


}
?>

</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>

    <input class="gray" type="Submit" name="NEWSEARCH" value="New Search">&nbsp;
    <input type="hidden" name="employee_id" value="<?php echo $employee_id ?>">


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
