<?php
session_start();
include("inc/dbconnect.php");
// session_unregister("query_value");
if ($NEWSEARCH) {
	header("Location: uc_menu.php?calling=".$calling);
}

if ($calling=="check") {
	$show_menu="OFF";
} else {
	$show_menu = "ON";
}
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
//-->
</script>
</head>

  <blockquote>
   <h1>Search Result</h1>
  <?php

echo "<form name=mainform method=post action=".$PHP_SELF.">"; 
if ($curam_cd) {
	$search_where = " ctable_name = '".$curam_cd."' ";
} else {
	if (!$search_where) {
 		$search_where = "1 = 1 "; 
	}
}

$sql = "SELECT * FROM use_case WHERE ".$search_where;

$sql.=" ORDER BY 1 limit 1500";
// echo $sql."<br>";

$result = execSql($db, $sql, $debug);

$numrows = pg_numrows($result);
echo ("<tr><td>Table Information</td></tr>");

if ($numrows == 1 AND $calling == 'lookup') {
	list($vehicle_tag_no, $vehicle_make, $vehicle_model, $vehicle_color, $vehicle_year, $tag_expir_month, $tag_expir_year, $vehicle_state, $first_name, $last_name, $status, $boot_flag_date, $mva_flag_date, $vehicle_tag_balance, $citation_count, $warning_date, $warning_flag) = pg_fetch_row ($result,0);
?>
<script>
window.opener.mainform.vehicle_tag_no.value='<?php echo $vehicle_tag_no ?>';
window.opener.mainform.vehicle_make.value='<?php echo $vehicle_make ?>';
window.opener.mainform.vehicle_model.value='<?php echo $vehicle_model ?>';
window.opener.mainform.vehicle_color.value='<?php echo $vehicle_color ?>';
window.opener.mainform.vehicle_year.value='<?php echo $vehicle_year ?>';
window.opener.mainform.tag_expir_month.value='<?php echo $tag_expir_month ?>';
window.opener.mainform.tag_expir_year.value='<?php echo $tag_expir_year ?>';
window.opener.mainform.vehicle_state.value='<?php echo $vehicle_state ?>';
window.opener.mainform.first_name.value='<?php echo $first_name ?>';
window.opener.mainform.last_name.value='<?php echo $last_name ?>';
window.opener.mainform.citation_count.disabled=false;
window.opener.mainform.citation_count.value='<?php echo $citation_count ?>';
window.opener.mainform.citation_count.disabled=true;
window.opener.mainform.warning_date.disabled=false;
window.opener.mainform.warning_date.value='<?php echo $warning_date ?>';
window.opener.mainform.warning_date.disabled=true;
if ('<?php echo $warning_flag ?>' != 'Y' && <?php echo $citation_count ?> > 4) {
	window.opener.mainform.warning_flag.disabled=false;
	window.opener.mainform.warning_flag.value='<?php echo $warning_flag ?>';
} else {
	window.opener.mainform.warning_flag.disabled=false;
	window.opener.mainform.warning_flag.value='<?php echo $warning_flag ?>';
	window.opener.mainform.warning_flag.disabled=true;
}
window.opener.mainform.ticket_type.focus();
window.close();
</script>
<?php
} else {
	if ($calling == 'check') {
?>
<script>
window.resizeTo(1050,650);
document.all.calling.value='check';
</script>
<?php
	}
	if ($calling == 'lookup') {
?>
<script>
window.close();
</script>
<?php
	}
}


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
	if ($calling == 'check') {
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
					echo "<td><a href=uc_form.php?calling=".$calling."&ucId=".$val.">".$val."</a></td>"; 
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

	$ctable_name = $rowarr[0];

	$sql="SELECT ctable_field, field_type, field_length, field_decimal, field_aster from curam_table_field WHERE ctable_name = '".$ctable_name."'  ";

	$result = execSql($db, $sql, $debug);

	echo ("<tr><td>&nbsp;</td></tr>");
	echo ("<tr><td>Field Information</td></tr>");

	if ($result) {
        	$numrows = pg_numrows($result);
        	$numfields = pg_numfields($result);
	} else {
        	echo ("<tr><td><b>No Rows Returned - possible error</b></td></tr>");
	}
	 echo "<tr><td valign=top>";
	echo "<table border=1>";
	if ($result) {
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
				if ($j == 0) {
                        		echo "<td><a href=search_curam_field_result.php?ctable_field=".urlencode($val).">".$val."</a></td>";
				} else {
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
        		}

			echo ("</TR>");
		}
		echo ("</table>");
	}

/* === open_log ==== */

	$sql="SELECT *  FROM curam_table_fk  WHERE ctable_name = '".$ctable_name."' ";

	$result = execSql($db, $sql, $debug);

	echo ("<tr><td>&nbsp;</td></tr>");
	echo ("<tr><td>Foreign Key Data</td></tr>");

	if ($result) {
        	$numrows = pg_numrows($result);
        	$numfields = pg_numfields($result);
		echo "<tr><td valign=top>";
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

				switch (pg_fieldname($result,$j)) {

				case 'password':
                        		echo "<td>**********</td>";
				break;
				default:
					if ($ftype == 'numeric') {
                       				echo "<td align=right>$val</td>";
					} else {
						if ($j == 0) {
                       					echo "<td>$val</td>";
						} else  {
                       					echo "<td>$val</td>";
						}
					}
				}

        		}

		}
		echo ("</TR>");
        } else {
        	echo ("<tr><td><b>No Rows Returned</b></td></tr>");
	}
echo ("</table>");

}
?>

</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>

    <input type="Submit" name="NEWSEARCH" value="New Search">&nbsp;
    <input type="hidden" name="calling" value="<?php echo $calling ?>">&nbsp;


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
