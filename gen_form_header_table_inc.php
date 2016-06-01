<?
/* - gen_form_header_table.php - */
/* ==== start ======== */

echo "going to get_parent_child_field";

$return_fields = get_parent_child_field ($db,$header_table,$detail_table,"insert",$header_table);
echo "coming back from get_parent_child_field";
/*
$sql = "SELECT ".$return_fields." from cert_order where order_seq=".$order_seq." order by order_seq";
*/
if ($header_where_clause) {
$sql = "SELECT ".$return_fields." from ".$header_table." ".$header_where_clause;
} else {
$sql = "SELECT ".$return_fields." from ".$header_table;
}

$result = pg_exec($db, $sql);

$numrows = pg_numrows($result);
$numfields = pg_numfields($result);
$numrows = 8;
if (pg_ErrorMessage($db)) {
        DisplayErrMsg(sprintf("Error in executing %s statement", $sql)) ;
        DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
        }

echo ("<TABLE BORDER>");

if ($result) {

        echo("\n<TR BGCOLOR=\"f5f5f5\">");

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




                for ($j=0;$j<$numfields;$j++) {
			echo ("<td><input type=text name=textfield[] length=".$fldlen_array[$j]."></td>");

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

