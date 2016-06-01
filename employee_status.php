<?php
session_start();
include("inc/dbconnect.php");
session_unregister("query_value"); 

if ($NEWSEARCH) {
header("Location: search_payment.php");
}
if ($LASTQUERY) {
	$search_where = $old_search;
	header("Location: search_payment_result.php");
}

$show_menu = "ON";
include("inc/index_header_inc.php");
?>
<HTML>
<head>
<!--This line must be included as the swfobject.js file is referenced byt the javascript below-->
                <script type="text/javascript" src="swfobject.js"> </script>
<!--End of swfobject.js definition-->

</head>
  <blockquote>
   <h1>Employee Status - Active Employees</h1>
<br><br>
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


$sql="SELECT e.employee_id, e.first_name, e.last_name, e.employee_type, sum(case when c.status = 'P' then 1 else 0 end) as pending,  sum(case when c.status = 'I' then 1 else 0 end) as in_progress, sum(case when c.status = 'X' then 1 else 0 end) as canceled,sum(case when c.status = 'C' then 1 else 0 end) as completed  from employee e left outer join course_user c on e.employee_id = c.user_id where e.status = 'A'  ";
if ($uid) {
	$sql.=" and e.employee_id = '".$uid."' ";
}
$sql.=" group by 1,2,3,4 order by 3,2 ";


$result = execSql($db, $sql, $debug);

        $numrows = pg_numrows($result);
if ($numrows > 0) {
        $numfields = pg_numfields($result);
        echo ("<tr><td><b><a href=search_employee.php>Employees - ".$numrows."</b></a></td></tr>");
} else {
        echo ("<tr><td><b><a href=search_employee.php>Employees - ".$numrows."</b></a></td></tr>");
        echo ("<tr><td><b>No Rows Returned</b></td></tr>");
}
echo ("</td></tr>");
echo "<tr><td valign=top>";
echo "<table border=1>";
if ($result) {
        echo("\n<TR BGCOLOR=\"f5f5f5\">");
        for ($i=0;$i<$numfields;$i++) {
        $fldname = pg_fieldname($result,$i);
        $fldname = ereg_replace("_"," ",$fldname);
        echo ("<Td><b>".(ucwords($fldname))."</b></Td>");
}
        echo ("<Td><b>Schedule</b></Td>");

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
				$uid = $val;
				if ($numrows == 1) {
					echo "<td><a href=search_course_gen.php?course_id=".$val.">".$val."</a></td>"; 
				} else {
					echo "<td><a href=employee_status.php?uid=".$val.">".$val."</a></td>"; 
				}
				$temp_xa_id = $val;
			} else {
				if ($ftype == 'numeric' OR $ftype == 'int2' OR $ftype == 'int4' OR $ftype == 'int8') {
                        		echo "<td align=right>$val</td>";
				} else {
                        		echo "<td>".$val."</td>";
				}
			}
                }

        }
              echo "<td align=center><a href=enter_course_user.php?uid=".$uid.">Schedule</a></td>";
echo ("</TR>");
}
echo ("</table>");
}


if ($numrows == 1 ) {

	$uid = $rowarr[0];

	$sql="SELECT c.course_id, e.last_name||', '||e.first_name as user_name,  c.course_type as type, c.status , c.num_modules   as modules  , c.modules_passed as passed,  c.module_retakes as retakes, c.course_start_date as start_date, c.course_end_date as end_date, c.course_result as result, c.user_id from course_user c, employee e where c.user_id = e.employee_id and c.admin_id = '".$userid."' and c.status in ('A', 'F','C' ) and c.course_end_date > now()::date - 14 AND c.user_id LIKE '".$uid."' ORDER BY c.course_id, c.course_end_date ";

	$result = execSql($db, $sql, $debug);
	echo ("<tr><td>&nbsp;</td></tr>");
	echo ("<tr><td><a href=search_course_user.php alt='Search all'>Courses Completed</a></td></tr>");

	if ($result) {
        	$numrows = pg_numrows($result);
        	$numfields = pg_numfields($result);
	} else {
        	echo ("<tr><td><b>No Rows Returned</b></td></tr>");
	}
 	echo "<tr><td valign=top>";
	echo "<table border=1>";
	if ($result) {
        	echo("\n<TR BGCOLOR=\"f5f5f5\">");
	        for ($i=0;$i<$numfields - 1;$i++) {
        	$fldname = pg_fieldname($result,$i);
	        $fldname = ereg_replace("_"," ",$fldname);
        	echo ("<Td><b>".(ucwords($fldname))."</b></Td>");
	}
 /*       echo ("<Td><b>Action</b></Td>"); */

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

        	        if ($j == 0)  {
/*				echo "<td><a href=view_element.php?mid=".$val.">".$val."</a></td>";  */
				echo "<td><a href=review_module.php?uid=".$rowarr[1]."&mid=".$val.">".$val."</a></td>";  
/*				echo "<td><b>".$val."</b></td>"; */ 
	                } else {
				if ($ftype == 'numeric' OR $ftype == 'int2' OR $ftype == 'int4' OR $ftype == 'int8') {
                        		echo "<td align=right>$val</td>";
				} else {
                        		echo "<td>".$val."</td>";
				}
        	        }

        	}
/*
		if ($rowarr[1] == 'DEPS') {
			echo "<td><a href=cashier_deposit_return.php?xa_id=".$temp_xa_id."&account_id=".$rowarr[0]."&bill_id=".$rowarr[2].">Return Deposit</a></td>"; 
		} else {
			echo "<td><a href=cashier_correct.php?xa_id=".$temp_xa_id."&account_id=".$rowarr[0]."&bill_id=".$rowarr[2].">Update</a></td>"; 
		}
*/
		echo ("</TR>");
	}
	echo ("</table>");
	}

/* === pay_log ==== */
	$sql="SELECT cu.course_id, u.last_name||', '||u.first_name as user_name, cu.course_type as type, cu.status ,  cu.num_modules as modules    , cu.modules_passed as passed, cu.module_retakes as retakes, cu.course_init_date as init_date, cu.course_spoil_date as spoil_date, c.course_name, cu.user_id  from course_user cu, course c, employee u where cu.course_id = c.course_id and cu.user_id = u.employee_id and cu.admin_id = '".$userid."' and cu.status = 'P' ";
	$sql.=" AND cu.user_id LIKE '".$uid."' ";
	$sql.= " ORDER BY  cu.course_id, cu.course_init_date ";

$result = execSql($db, $sql, $debug);
echo ("<tr><td>&nbsp;</td></tr>");
echo ("<tr><td>Courses Scheduled</td></tr>");

if ($result) {
        $numrows = pg_numrows($result);
        $numfields = pg_numfields($result);
} else {
        echo ("<tr><td><b>No Rows Returned</b></td></tr>");
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
			if ($ftype == 'numeric' OR $ftype == 'int2' OR $ftype == 'int4' OR $ftype == 'int8') {
                       		echo "<td align=right>$val</td>";
			} else {
				if ($j == 0) {
					echo "<td><a href=review_course.php?uid=".$rowarr[10]."&cid=".$val.">$val</a></td>";
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

	$sql="SELECT cu.course_id, u.last_name||', '||u.first_name as user_name, cu.course_type as type, cu.status , cu.num_modules as modules, cu.modules_passed as passed, cu.module_retakes as retakes, cu.course_init_date as init_date, cu.course_spoil_date as spoil_date, cu.course_start_date as start_date,  c.course_name , cu.user_id from course_user cu, course c, employee u where cu.course_id = c.course_id and cu.user_id = u.employee_id and cu.admin_id = '".$userid."' and cu.status = 'I'  and cu.user_id LIKE '".$uid."' ORDER BY cu.course_id, cu.course_start_date ";

$result = execSql($db, $sql, $debug);
echo ("<tr><td>&nbsp;</td></tr>");
echo ("<tr><td>Courses In Progress</td></tr>");

if ($result) {
        $numrows = pg_numrows($result);
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
/*
        list($sequence, $pay_method, $status, $card_num, $exp_date, $aba_code, $bank_account, $check_num, $payment_amount, $cash_amount, $change_amount, $pay_name, $email, $iv_in) = pg_fetch_row($result,$i) ;
*/
        $rowarr = pg_fetch_row($result,$i);
        for ($j=0;$j<$numfields - 1;$j++) {
                $ftype = pg_field_type($result,$j);
                $val = $rowarr[$j];
                $uid = $rowarr[12];
                if ($val == "" or $val == "  ") {
                        $val = "&nbsp;";
                }

                switch (pg_fieldname($result,$j)) {

                case 'password':
                        echo "<td>**********</td>";
                        break;
                default:
			if ($ftype == 'numeric' OR $ftype == 'int2' OR $ftype == 'int4' OR $ftype == 'int8') {
                                echo "<td align=right>$val</td>";
                        } else {
				if ($j==0) {
					echo "<td><a href=search_course_user_gen.php?user_id=".$uid."&course_id=".$val.">".$val."</a></td>"; 
				} else {
        	                        echo "<td>$val</td>";
				}
                        }
                }


        }
echo ("</TR>");
}
echo ("</table>");
}


} else {
/* setting old_search here */ 
	$old_search = $search_where;
}
?>

</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>

<?php
if ($temp_status == 'AA' AND $user_type == 'supervisor') {
    echo "<input type=Submit name=AUTHORIZE value='Authorize'>&nbsp;";
}
?>
<!--    <input type="Submit" name="NEWSEARCH" value="New Search">&nbsp;
<input type="button" name="PRINTRECEIPT" value="Print Receipt" onclick="javascript:window.open('cashier_print_receipt.php?xa_id=<?php echo $temp_xa_id ?>', 'tinyWindow', 'toolbar,scrollbars,width=200,height=650')">&nbsp;
-->

</td></tr>
<!-- </table> -->
    </p>

<?php
	if ($userverbose == 'y') {
?>

<!--This is where you setup the DIV. Notice the ID - this is the name of the DIV that is referenced by the Javascript below-->
        <div id="AlterEgosPlayer" align="right">Powered By AlterEgos.com</div>  <!--Replace this DIV ID with your own DIV ID if required-->
<!--End of DIV definition-->

<!--Please note the DIV must be before the Javascript -->
        <script type="text/javascript">
                        var so = new SWFObject("AlterEgos.com.swf", "main", "180", "200", "8", "#000000");
                        so.addParam("allowFullScreen", "true");
                        so.addVariable("MediaLink", "current_status.flv");
                        so.addVariable("image", "test_avatar1.jpg");
                        so.addVariable("playOnStart", "true");
                        so.addParam("wmode", "transparent");
                        so.addVariable("startVolume", "50");
                        so.addVariable("loopMedia", "false");
                        so.write("AlterEgosPlayer");
                </script>

<?php
	}
?>


  </form>

</blockquote>
<?

include "inc/footer_inc.php";
?>
</body>
</table>
</HTML>
