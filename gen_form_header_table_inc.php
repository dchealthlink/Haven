<?
/* - gen_form_header_table.php - */
/* ==== start ======== */



$return_fields = get_parent_child_field ($db,$header_table,$detail_table,"insert",$header_table);

/*
$sql = "SELECT ".$return_fields." from cert_order where order_seq=".$order_seq." order by order_seq";
*/

if (!$sql) {
	if ($header_where_clause) {
		$sql = "SELECT ".$return_fields." from ".$header_table." ".$header_where_clause;
	} else {
		$sql = "SELECT ".$return_fields." from ".$header_table;
	}
}

$result = pg_exec($db, $sql);

$numrows = pg_numrows($result);
$numfields = pg_numfields($result);

if (pg_ErrorMessage($db)) {
        DisplayErrMsg(sprintf("Error in executing %s statement", $sql)) ;
        DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
        }

echo ("<TABLE BORDER>");

if ($result) {

        echo("\n<TR BGCOLOR=\"f5f5f5\">");

				echo ("<td>Day</td>");
                for ($i=0;$i<$numfields;$i++) {
                        $fldname = pg_fieldname($result,$i);
			$fldlen_array[$i] = pg_field_size($result, $i);
                        $fldname = ereg_replace("_","<br>",$fldname);
                        echo ("<Td><b>$fldname</b></Td>");
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

		 $dayofweek = date("l",mktime(0, 0, 0, substr($rowarr[0],5,2), substr($rowarr[0],8,2), substr($rowarr[0],0,4))); 
				echo ("<td>".$dayofweek."</td>");

                for ($j=0;$j<$numfields;$j++) {

			if ($j < 2) {
				echo ("<td><input type=hidden name=textfield[] value='".$rowarr[$j]."'>".$rowarr[$j]."</td>");
			} else {
				echo ("<td><input class=pink type=text name=textfield[] length=".$fldlen_array[$j]." value='".$rowarr[$j]."'></td>");
			}
		}
/*
                $rowarr = pg_fetch_row($result,$i);

                for ($j=0;$j<$numfields;$j++) {
                        $val = $rowarr[$j];
                                if ($val == "") {
                                        $val = "&nbsp;";
                                }
                                echo ("<TD>$val</TD>");

                }
*/
        echo ("</TR>");
}
        echo ("</Table>");
} else {
        DisplayErrMsg(sprintf("No result %s ", $result)) ;
};

/*  ====== end ====== */
echo ("<p>");
?>

