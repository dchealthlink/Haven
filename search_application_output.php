<?php
session_start();
include("inc/dbconnect.php");
// session_unregister("query_value");
// session_unregister("search_where");
if ($NEWSEARCH) {
header("Location: application_menu.php");
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

if ($appl_id) {
	$search_where = " applid = '".$appl_id."' ";
} else {

}


  /* <form method="post" action="<?php echo $PHP_SELF?>"> */

echo "<form method=post action=".$PHP_SELF.">"; 
/*
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
*/
if (!$search_where) {
 	$search_where = "1 = 1 "; 
}

$sql = "SELECT application.applid, application.name, application.statecd, application.appyear, application.postdate, application.status, application.statustimestamp FROM application WHERE ".$search_where;

$sql.=" ORDER BY application.applid limit 500";

$result = execSql($db, $sql, $debug);

        $numrows = pg_numrows($result);
echo ("<tr><td>Application Information</td></tr>");
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
						echo "<td><a href=search_application_gen.php?appl_id=".$val.">".$val."</a></td>"; 
					}

				} else {
					echo "<td><a href=search_application_gen.php?appl_id=".$val.">".$val."</a></td>"; 
					
				}
				$temp_appl_id = $val;
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

$appl_id = $rowarr[0];

$sql="SELECT * FROM application_result WHERE applid = '".$appl_id."'  ORDER BY 1  ";

$result = execSql($db, $sql, $debug);
        $numrows = pg_numrows($result);

echo ("<tr><td>&nbsp;</td></tr>");
echo ("<tr><td>Result Information</td></tr>");

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

$sql="SELECT * from application_determination where applid = '".$appl_id."'  ORDER BY 1  ";
$result = execSql($db, $sql, $debug);

echo ("<tr><td>&nbsp;</td></tr>");
echo ("<tr><td>Determination Information</td></tr>");
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
        for ($i=0;$i<$numfields ;$i++) {
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
        for ($j=0;$j<$numfields ;$j++) {
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

/* === aptc ==== */

$sql="SELECT * FROM application_aptc WHERE applid = '".$appl_id."' ORDER BY 1,2";
$result = execSql($db, $sql, $debug);
        $numrows = pg_numrows($result);
if ($numrows > 0) {
echo ("<tr><td>&nbsp;</td></tr>");
echo ("<tr><td>APTC Information</td></tr>");

        $numfields = pg_numfields($result);

echo ("</td></tr>");
echo "<tr><td valign=top>";
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


                    if ($ftype == 'numeric') {
                            echo "<td align=right>$val</td>";
                    } else {
                            echo "<td>$val</td>";
                    }


        }
echo ("</TR>");
}
echo ("</table>");
}
}

?>

</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>

    <input class="gray" type="Submit" name="NEWSEARCH" value="New Search">&nbsp;
    <input type="hidden" name="appl_id" value="<?php echo $appl_id ?>">


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
