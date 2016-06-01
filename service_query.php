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
   <h1>Make Request</h1>
<br><br>
  <?php

echo  "<form method=post action=execwsdl.php>" ;


$sql="SELECT ws.service_name, wsf.function_name, ws.service_id FROM testweb_service ws, testweb_service_function wsf WHERE ws.service_id = wsf.service_id AND  ws.status = 'A' and wsf.function_status = 'A' ";
$sql.= " ORDER BY 1, 2";
echo "Services <br>";
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
echo ("</table>");
}


if ($numrows>= 0 ) {

	$sql="SELECT ind_id, person_id, person_surname as surname, person_given_name as given, location_city_name as city, location_state_code as state, birthdate FROM testload_data ORDER BY 3,4 ";

	$result = pg_exec($db, $sql);
        $numrows = pg_numrows($result);
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
	        for ($j=0;$j<$numfields ;$j++) {
			$ftype = pg_field_type($result,$j);
                	$val = $rowarr[$j];
	                if ($val == "" or $val == "  ") {
        	                $val = "&nbsp;";
	                }

                        echo "<td>".$val."</td>";

        	}
              echo "<td align=center><input type=radio name=iid value='".$rowarr[0]."'></td>";

		echo ("</TR>");
	}
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
