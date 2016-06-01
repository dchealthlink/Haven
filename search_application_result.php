<?php
session_start();
include("inc/dbconnect.php");
// session_unregister("query_value");
// session_unregister("search_where");
if ($NEWSEARCH) {
header("Location: application_menu.php");
exit;
}
if ($UPDATEAPP) {
header("Location: update_application.php?appl_id=".$appl_id);
exit;
}

$show_menu = "ON";

$arr_a_sql = "select magi_label, field_name from table_label_xref where table_name = 'application_person' ";
$arr_a_result = execSql($db, $arr_a_sql, $debug) ;
$data = array();
while ($row = pg_fetch_row($arr_a_result)) {
        $data[$row[0]] = $row[1] ;
}

include("inc/index_header_inc.php");
	
?>
<HTML>
<script language="javascript">
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
					echo "<td><a href=search_application_output.php?appl_id=".$val.">".$val."</a></td>"; 
					
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

$sql="SELECT person.personfirstname||' '||personlastname as person, application_person.* FROM application_person , person WHERE application_person.personid = person.personid and application_person.applid = '".$appl_id."'  ORDER BY 2  ";

$result = execSql($db, $sql, $debug);
        $numrows = pg_numrows($result);

echo ("<tr><td>&nbsp;</td></tr>");
echo ("<tr><td>Applicant Information</td></tr>");

if ($result) {
        $numfields = pg_numfields($result);
} else {
        echo ("<tr><td><b>No Rows Returned</b></td></tr>");
}
 echo "<tr><td valign=top>";
if ($numrows > 0) {
	echo "<table border=0>";
        echo("\n<TR BGCOLOR=\"f5f5f5\">");
        for ($i=0;$i<$numfields;$i++) {
        $fldname = pg_fieldname($result,$i);
        $fldname = ereg_replace("_"," ",$fldname);
//        echo ("<Td><b>".(ucwords($fldname))."</b></Td>");
}

echo ("</TR>");
$color = "f5f5f5";

for ($i=0;$i<$numrows;$i++) {

	if ($i != 0) {
                echo ("<TR><td colspan=10>&nbsp;</td></tr>");
	}

        if (($i % 2) == 0) {
//                echo ("\n<TR>");
                echo ("\n<TR BGCOLOR=$color>");
        } else {
                echo ("\n<TR BGCOLOR=$color>");
        }
	$rowcount = 0;
        $rowarr = pg_fetch_row($result,$i);
        for ($j=0;$j<$numfields;$j++) {
        	$ffldname = pg_fieldname($result,$j);
		$ftype = pg_field_type($result,$j);
                $val = $rowarr[$j];
		$foundval = array_search($ffldname,$data)  ;
                if ($val != "" and $val != "  " and $val != '0.00' and $foundval) {
				$rowcount = $rowcount + 1;

				if ($ftype == 'numeric') {
                        		echo "<td><b>".$foundval."</b></td><td align=right>".(number_format($val,2))."</td>";
				} else {
                        		echo "<td><b>".$foundval."</b></td><td>".$val."</td>";
				}
				if ($rowcount % 3 == 0) {
					echo "</tr><tr>";
				}
                }

        }

echo ("</TR>");
}
echo ("</table>");
}

/* === relationship ==== */

$sql="SELECT p.personfirstname||' '||p.personlastname as person, ar.relationship, p1.personfirstname||' '||p1.personlastname as rel_person, ar.cross_relationship FROM application_relationship ar, person p, person p1 WHERE ar.personid = p.personid and ar.cross_personid = p1.personid and ar.applid = '".$appl_id."'  ORDER BY 1  ";
// $sql="SELECT ar.personid as person, ar.relationship, ar.cross_personid as rel_person, ar.cross_relationship FROM application_relationship ar WHERE  ar.applid = '".$appl_id."'  ORDER BY 1, 3  ";
$result = execSql($db, $sql, $debug);
       $numrows = pg_numrows($result);
if ($numrows > 0) {
	echo ("<tr><td>&nbsp;</td></tr>");
	echo ("<tr><td>Relationship Information</td></tr>");

        $numfields = pg_numfields($result);
	echo ("</td></tr>");
	echo "<tr><td valign=top>";

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

/* === household ==== */

$sql="SELECT ah.householdid, ah.personid, p.personfirstname||' '||p.personlastname as person  FROM application_household ah, person p WHERE ah.personid = p.personid and ah.applid = '".$appl_id."' ORDER BY 1,2";
// $sql="SELECT  ah.householdid, ah.personid as person  FROM application_household ah WHERE  ah.applid = '".$appl_id."' ORDER BY 1,2";
$result = execSql($db, $sql, $debug);
$numrows = pg_numrows($result);
if ($numrows > 0) {
	echo ("<tr><td>&nbsp;</td></tr>");
	echo ("<tr><td>Household Information</td></tr>");

        $numfields = pg_numfields($result);
	echo ("</td></tr>");
	echo "<tr><td valign=top>";
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

/* -------------------------------------------------------------------------------- */


/* === tax stuff  ==== */

$sql="SELECT  at.filer_type, at.personid, p.personfirstname||' '||p.personlastname as person  FROM application_tax at, person p WHERE at.personid = p.personid and at.applid = '".$appl_id."' ORDER BY 1 desc, 2";
// $sql="SELECT at.filer_type, at.personid as person  FROM application_tax at WHERE  at.applid = '".$appl_id."' order by tax_no, 1 desc , 2";
$result = execSql($db, $sql, $debug);
$numrows = pg_numrows($result);
if ($numrows > 0) {
	echo ("<tr><td>&nbsp;</td></tr>");
	echo ("<tr><td>Tax Return Information</td></tr>");

        $numfields = pg_numfields($result);
	echo ("</td></tr>");
	echo "<tr><td valign=top>";
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
    <input class="gray" type="Submit" name="UPDATEAPP" value="update">&nbsp;
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
