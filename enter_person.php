<?php
// session_start();
include("inc/qdbconnect.php");
/*
$show_menu = "ON";
include("inc/index_header_inc.php");
*/
?>
<HTML>
<head>

</head>
  <blockquote>
   <h3>Enter Person</h3>
<br><br>
  <?php

echo  "<form method=post action=submit_enter_person.php>" ;

if ($_POST['id']) {
	$id = $_POST['id'];
	} else {
	$id = 1234;
}


$sql="SELECT ind_id, person_id, person_surname as surname, person_given_name as given_name, 'xxxx'||right(ssn,4) as ssn, gender, birthdate, created_at FROM testload_data WHERE ind_id = ".$id;
$sql.= " ORDER BY 1, 2";
echo "Person <br>";
$result = pg_exec($db, $sql);

        $numrows = pg_numrows($result);
if ($numrows > 0) {
        $numfields = pg_numfields($result);
}
echo ("</td></tr>");
echo "<tr><td valign=top>";
if ($numrows > 0) {
	echo "<table border=1>";
        echo("\n<TR BGCOLOR=\"f5f5f5\">");
        for ($i=0;$i<$numfields;$i++) {
        $fldname = pg_fieldname($result,$i);
//        $fldname = preg_replace("_"," ",$fldname);
        echo ("<Td><b>".(ucwords($fldname))."</b></Td>");
}
        echo ("<Td><b>Select</b></Td>");

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
                $val = $rowarr[$j];
		
       		echo "<td>".$val."</td>";

        }
              echo "<td align=center><input type=radio name=sidfunc value='".$val.'|'.$rowarr[1]."'></td>";
echo ("</TR>");
}
		echo ("<TR>");
		echo ("<TD><input type=text name=indId size=6>");
		echo ("</TD>");
		echo ("<TD><input type=text name=personId size=6>");
		echo ("</TD>");
		echo ("<TD><input type=text name=personSurname size=15>");
		echo ("</TD>");
		echo ("<TD><input type=text name=personGivenName size=15>");
		echo ("</TD>");
		echo ("<TD><input type=text name=ssn>");
		echo ("</TD>");
		echo ("<TD>");
			echo "<SELECT NAME=gender>";
			echo"<option selected value=\"\">";
                        	echo "<option value='urn:openhbx:terms:v1:gender#female'>Female";;
                        	echo "<option value='urn:openhbx:terms:v1:gender#male'>Male";
		echo "</SELECT>";
		echo ("</TD>");
		echo ("<TD><input type=text name=birthDate size=10>");
		echo ("</TD>");
		echo ("</TR>");
echo ("</table>");
}


if ($numrows>= 0 ) {

	$sql="SELECT mult_type, mult_iteration as iter, mult_label as label, mult_value as value FROM testload_data_mult WHERE ind_id = ".$id." ORDER by 1,2,3 ";

	$result = pg_exec($db, $sql);
        $numrows = pg_numrows($result);
	echo "<br><br>";
	echo ("<tr><td>&nbsp;</td></tr>");
	echo ("<tr><td>&nbsp;</td></tr>");
	echo ("<tr><td>Citizens</td></tr>");

	if ($numrows > 0) {
        	$numfields = pg_numfields($result);
	} else {
        	echo ("<tr><td><b>No Rows Returned</b></td></tr>");
	}
 	echo "<tr><td valign=top>";
	if ($numrows > 0) {
		echo "<table border=1>";
        	echo("\n<TR BGCOLOR=\"f5f5f5\">");
	        for ($i=0;$i<$numfields ;$i++) {
        	$fldname = pg_fieldname($result,$i);
//	        $fldname = preg_replace("_"," ",$fldname);
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

                        echo "<td>".$val."</td>";

        	}

	} 
		echo ("</TR>");
		echo ("<TR>");
		echo ("<TD><input type=hidden name=mindId value=".$id.">");
		$typesql = "SELECT distinct mult_type FROM testload_data_mult ORDER BY 1";
		$typeresult = pg_exec($db, $typesql) ;
			echo "<SELECT NAME=multType>";
			echo"<option selected value=\"\">";

			$trownum = 0;
        		while ($row = pg_fetch_array($typeresult,$trownum)) {
				list ($tmpMultType) = pg_fetch_row($typeresult, $trownum) ;
                        	echo "<option value=".$tmpMultType.">".$tmpMultType;
        			$trownum = $trownum + 1;
                	}
        
		echo "</SELECT>";
		echo ("</TD>");


		echo ("<TD><input type=text name=multIter>");
		echo ("</TD>");
		echo ("<TD><input type=text name=multLabel>");
		echo ("</TD>");
		echo ("<TD><input type=text name=multValue size=40>");
		echo ("</TD>");
		echo ("</TR>");
	echo ("</table>");
	}

}

?>

</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>

<?php
    echo "<br>";
    echo "<input type=Submit name=Submit value='Submit'>&nbsp;";
?>

</td></tr>
<!-- </table> -->
    </p>


  </form>

</blockquote>
<?

// include "inc/footer_inc.php";
?>
</body>
</table>
</HTML>
