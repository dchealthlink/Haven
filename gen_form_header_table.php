<?
/* - gen_form_header_table.php - */
/* ==== start ======== */

/* $return_fields = get_parent_child_field ($db,$header_table,$detail_table,"insert",$header_table); */
$return_fields = get_table_field_access ($db,$header_table,"view");
/*
$sql = "SELECT ".$return_fields." from cert_order where order_seq=".$order_seq." order by order_seq";
*/
$sql = "SELECT ".$return_fields." from ".$header_table." ".$header_where_clause;
$sql.= " ORDER BY 1,2";


$result = pg_exec($db, $sql);

$numrows = pg_numrows($result);
$numfields = pg_numfields($result);

if (pg_ErrorMessage($db)) {
        DisplayErrMsg(sprintf("Error in executing %s statement", $sql)) ;
        DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
        }

/* echo ("<TABLE BORDER>"); */

if ($result) {

        echo("\n<TR BGCOLOR=\"f5f5f5\">");

                for ($i=0;$i<$numfields;$i++) {
                        $fldname = pg_fieldname($result,$i);
                        $fldname = ereg_replace("_"," ",$fldname);
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

		$delstring = "delete_".$header_table.".php?";

                for ($j=0;$j<$numfields;$j++) {
                        $val = $rowarr[$j];
                                if ($val == "") {
                                        $val = "&nbsp;";
                                } else {
				
				if ($j == 0) {

					$delstring.= pg_fieldname($result,$j)."=".(urlencode($val));
				
				} else {
					$delstring.= "&".pg_fieldname($result,$j)."=".(urlencode($val));
				}

				}
                                echo ("<TD>$val</TD>");



                }
				$delstring.= "&retform=".(urlencode($PHP_SELF));
                                echo ("<TD><a href=".$delstring.">Delete</a></TD>");
        echo ("</TR>");
}
/*        echo ("</Table>"); */
} else {
        DisplayErrMsg(sprintf("No result %s ", $result)) ;
};

/*  ====== end ====== */
/* echo ("<p>"); */
?>
