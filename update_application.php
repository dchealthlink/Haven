<?php
session_start();
include("inc/dbconnect.php");
// session_unregister("query_value");
// session_unregister("search_where");
if ($NEWSEARCH) {
header("Location: application_menu.php");
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


echo "<form method=post action=update_application_add.php>"; 

if (!$search_where) {
 	$search_where = " application.applid = 160516085218 "; 
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

$sql="SELECT person.personfirstname||' '||person.personlastname as person, application_person.* FROM application_person, person WHERE application_person.personid = person.personid and application_person.applid = '".$appl_id."'  ORDER BY 2 ";

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

echo '<tr><td>&nbsp;</td></tr>';
echo '<tr><td>&nbsp;</td></tr>';
/* === relationship ==== */

	echo ("<table>");
                echo "<tr><td colspan=6>Relationship Information</td></tr>";

	$relsql = "select  c.personfirstname||' '||c.personlastname as personname, b.relationship,  d.personfirstname||' '||d.personlastname as crossperson, a.personid   , a.cross_personid from person c, person d, app_person_unique_list a left outer join application_relationship b on a.applid = b.applid and a.personid = b.personid and a.cross_personid = b.cross_personid where a.applid = '".$appl_id."' and a.personid = c.personid and a.cross_personid = d.personid  order by 1,2,4 ";

//        $taxsql = "SELECT p.personfirstname||' '||p.personlastname as person, ar.relationship,  cp.personfirstname||' '||cp.personlastname as cross_person ,ar.personid , ar.cross_personid from person p, application_relationship ar, person cp  WHERE ar.personid = p.personid and ar.cross_personid = cp.personid and ar.applId = '".$appl_id."' order by 2";
        $relresult = execSql($db, $relsql, $debug) ;
        $relrows = pg_num_rows($relresult) ;
        $trownum = 0;
        while($trow = pg_fetch_array($relresult, $trownum)) {
                list ($rperson, $rrelationship, $cperson, $rpersonid, $cpersonid) = pg_fetch_row($relresult, $trownum);
                echo '<tr><td colspan=2>'.$rperson;
                echo '<input type="hidden" name="relation['.$trownum.'][rperson]" value="'.$rpersonid.'">';
                echo '<input type="hidden" name="relation['.$trownum.'][cperson]" value="'.$cpersonid.'">';

                echo '</td>';
		echo '<td> is a/an </td>';
                echo '<td>';
                echo '<select name="relation['.($trownum).'][relationship]">';

                        $filer_type_all = pg_exec($db,"SELECT relationship as item_cd, relationship from relationship  order by sort_order ");
                        $rownum = 0;
                                while ($filer_type_row = pg_fetch_array($filer_type_all, $rownum)) {
                                        $item_description = $filer_type_row["relationship"];
                                        $item_cd = $filer_type_row["item_cd"];
                                        $rownum = $rownum + 1;
                                        if ($item_cd == $rrelationship ) {
                                        echo "<option selected value='".$item_cd."'>$item_description</option>";
                                        } else {
                                        echo "<option value='".$item_cd."'>".$item_cd."</option>";
                                        }
                                }
                echo "</select>";
                echo "</td>";
		echo '<td> of  </td>';
                echo '<td>'.$cperson.'</td>';
                echo "</tr>";
                $trownum = $trownum + 1;
        }


/* === household ==== */

    echo '<tr><td align=center colspan=2><b>---------------</b></td><td align=left colspan=2>------------------------------</td></tr>';
                echo "<tr><td colspan=6>Household Information</td></tr>";
                echo "<tr><td colspan=2>";
                echo "Person:</td><td>Household</td</tr>";

        $hhsql = "SELECT a.personid, p.personfirstname||' '||p.personlastname, b.householdid  from person p, application_person a left outer join application_household b on a.applid = b.applid and a.personid = b.personid WHERE a.personid = p.personid and a.applId = '".$appl_id."' order by a.personid, b.householdid ";

        $hhresult = execSql($db, $hhsql, $debug) ;
        $hhcount = pg_num_rows($hhresult) ;
        $hrownum = 0;
        while($hrow = pg_fetch_array($hhresult, $hrownum)) {
                list ($hpersonId, $hpersonname, $hhouseholdid) = pg_fetch_row($hhresult, $hrownum);
                echo '<tr><td colspan=2>'.$hpersonname.'</td>';

                echo "<td>";
                echo '<input type="hidden" name="household['.($hrownum).'][personid]" value="'.$hpersonId.'">';
                echo '<select name="household['.($hrownum).'][household]">';
                // echo '<input type="hidden" name="household[sub'.$hrownum.'][personid]" value="'.$hpersonId.'">';
                // echo '<select name="household[sub'.$hrownum.'][household]">';

                        $relationship_all = pg_exec($db,"SELECT householdid as relationship from household order by householdid limit ".$hhcount);
                        $rownum = 0;
                                while ($relationship_row = pg_fetch_array($relationship_all, $rownum)) {
                                        $item_description = $relationship_row["relationship"];
                                        $item_cd = $relationship_row["relationship"];
                                        $rownum = $rownum + 1;
                                        if ($item_cd == $hhouseholdid) {
                                        echo "<option selected value='$item_cd'>$item_description</option>";
                                        } else {
                                        echo "<option value='$item_cd'>$item_description</option>";
                                        }
                                }
                echo "</select>";
                echo "</td></tr>";
                $hrownum = $hrownum + 1;
        }

    echo '<tr><td align=center colspan=2><b>---------------</b></td><td align=left colspan=2>------------------------------</td></tr>';


                echo "<tr><td colspan=6>Tax Information</td></tr>";
                echo "<tr><td colspan=2>";
                echo "Person:</td><td>Tax Return</td><td>Filer Type</td</tr>";
        $taxsql = "SELECT ap.personid, p.personfirstname||' '||p.personlastname, at.tax_no, at.filer_type  from person p, application_person ap  left outer join application_tax at on ap.applid = at.applid and ap.personid = at.personid WHERE ap.personid = p.personid and ap.applId = '".$appl_id."' order by 2";

        $taxresult = execSql($db, $taxsql, $debug) ;
        $taxrows = pg_num_rows($taxresult) ;
        $trownum = 0;
        while($trow = pg_fetch_array($taxresult, $trownum)) {
                list ($tpersonId, $tapplname, $ttax_no, $tfiler_type) = pg_fetch_row($taxresult, $trownum);
                echo '<tr><td colspan=2>'.$tapplname.'</td>';

                echo '<td>';
                echo '<select name="taxfile['.($trownum).'][id]">';
//              echo '<option value="'.$ttax_no.'" >Tax Return: '.$ttax_no.'</option>';
                for ($j = 1; $j <= ($taxrows); $j++) {
                        if ($ttax_no == $j) {
                       echo "<option selected value='".$j."'>Tax Return: ".$j."</option>";
                        } else {
                       echo "<option value='".$j."'>Tax Return: ".$j."</option>";
                        }
                }
                echo "</select>";
                echo "</td><td>";

                echo '<input type="hidden" name="taxfile['.$trownum.'][personid]" value="'.$tpersonId.'">';

                echo '<select name="taxfile['.$trownum.'][filertype]">';
//              echo '<option value="'.$tfiler_type.'" >'.(substr($tfiler_type,0,-1)).'</option>';


                        $filer_type_all = pg_exec($db,"SELECT item_cd, item_description from app_lookup where lookup_table = 'application_tax' and lookup_field = 'filer_type' order by sort_order ");
                        $rownum = 0;
                                while ($filer_type_row = pg_fetch_array($filer_type_all, $rownum)) {
                                        $item_description = $filer_type_row["item_description"];
                                        $item_cd = $filer_type_row["item_cd"];
                                        $rownum = $rownum + 1;
                                        if ($item_cd == $tfiler_type ) {
                                        echo "<option selected value='".$item_cd."'>$item_description</option>";
                                        } else {
                                        echo "<option value='".$item_cd."'>".$item_cd."</option>";
                                        }
                                }
                echo "</select>";
                echo "</td>";
                echo "</tr>";
                $trownum = $trownum + 1;
        }



/* === tax stuff  ==== */

// echo '</table>';
}
?>

</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>

    <input class="gray" type="Submit" name="UPDATEAPP" value="Update">&nbsp;
    <input type="hidden" name="appl_id" value="<?php echo $appl_id ?>">


</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
    </p>
  </form>

</blockquote>
<?

include "inc/footer_inc.php";
?>
</body>
</table>
</HTML>
