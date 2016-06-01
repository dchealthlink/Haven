<!-- view_form_inc.php -->
<?php

if (!$acc_method) {
	$acc_method = "view";
}

if (!$sql) {
	$result_fields = get_table_field_access($db,$header_table,$acc_method);
	$sql = "select ".$result_fields." from ".$header_table;
	if ($sql_where_clause) {
		$sql.= $sql_where_clause;
	}
}

if ($order_field) {
	$sql.= " order by ".$order_field.", 1, 2 ";
} else {
	$sql.= " order by 1, 2 ";
}
$result = execSql($db, $sql, $debug);

$rownum = 0;
$fieldnum = pg_numfields($result);
$num_rows = pg_numrows($result);
if (!$orient)  {
	if ($num_rows == 1) {
		$orient = "vertical";
	} else {
		$orient = "horizontal";
	}
}

if (!$setborder) {
	$setborder = 0;
}
?>
<table border=<?php echo $setborder ?>> 
<?
echo("<TR BGCOLOR=#f5f5f5>");
if ($orient == "horizontal") {

if ($num_rows > 0) {
	for ($i = 0; $i < $fieldnum; $i++) {
        	$header_value = pg_fieldname($result,$i);
	
        	$l_sql = "SELECT field_label FROM table_field_access WHERE access_type = 'view' and table_name = '".$header_table."' and field_name = '".$header_value."'";

        	$l_result = execSql($db,$l_sql,$debug);

        	list($label_value) = pg_fetch_row($l_result, 0);

		if ($list_label != "N") {

		if ($label_value) {
	        	echo "<td><a href='".$PHP_SELF."?".$init_get_value."order_field=".$header_value."'>".$label_value."</a></td>";
		} else {
	        	echo "<td><b><a href='".$PHP_SELF."?".$init_get_value."order_field=".$header_value."'>".ucwords(ereg_replace("_"," ",$header_value))."</a></b></td>";

		}

		} else {
		if ($label_value) {
	        	echo "<td>".$label_value."</td>";
		} else {
	        	echo "<td><b>".ucwords(ereg_replace("_"," ",$header_value))."</b></td>";

		}

		}
}
	}
echo "</tr>";

}

$rownum = 0;

while ($row = pg_fetch_array($result,$rownum)) {
	for ($i = 0; $i < $fieldnum; $i++) {
        	$ftype = pg_field_type($result,$i);
        	$header_value = pg_fieldname($result,$i);
        	$data_value = $row[pg_fieldname($result,$i)];

		if ($orient != "horizontal") {

        		$l_sql = "SELECT field_label, addl_text, read_write FROM table_field_access WHERE access_type = 'view' and table_name = '".$header_table."' and field_name = '".$header_value."'";
        		$l_result = execSql($db,$l_sql, $debug);

        		list($label_value,$addl_text, $read_write) = pg_fetch_row($l_result, 0);

        		$addl_text = pg_fetch_row($l_result, 1);

			if ($read_write!="H") {

				if ($addl_text) {
        				echo "<tr><td colspan=2>".$addl_text."</td></tr>";
				}
				if ($label_value) {
        				echo "<tr><td>".$label_value."</td>";
				} else {
        				echo "<tr><td>".ucwords(ereg_replace("_"," ",$header_value))."</td>";
				}


				if ($i == 0 && $hlink != 'N') {
       					echo "<td colspan=7><b><a href=".$link_reference.(urlencode($data_value)).">".$data_value."</a></b></td></tr>";  
				} else {

					$data_description="";
        				$l_sql = "SELECT * FROM xref_lookup WHERE xref_tablename = '".$header_table."' AND xref_fieldname = '".$header_value."'";

        				$l_result = execSql($db,$l_sql, $debug);

        				$rowarr = pg_fetch_row($l_result, 0);

        				$lookuptable = $rowarr[2];
        				$lookupfield = $rowarr[3];
        				$lookupdesc = $rowarr[4];
        				$lookupreplace_field = $rowarr[5];
        				$lookupsort_order = $rowarr[6];

        if  ((pg_NumRows($l_result) > 0)) {

                if ($lookup_table != "app_lookup") {
                        $l_sql="SELECT ".$lookupdesc." as item_description";
                        $l_sql.=" from ".$lookuptable." ";
                        $l_sql.=" where ".$lookupfield." = '".$data_value."'" ;
                } else {
                        $l_sql="SELECT item_description ";
                        $l_sql.=" FROM app_lookup ";
                        $l_sql.=" WHERE lookup_table = '".$header_table."' AND ";
                        $l_sql.=" lookup_field ='".$header_value."' AND ";
                        $l_sql.=" item_cd ='".$data_value."'";
                }

                $l_result = execSql($db,$l_sql,$debug);

		list($data_description)= pg_fetch_row($l_result, 0);

		if ($data_description) {
			$data_description = " - ".$data_description;
		}

}



        				echo "<td colspan=7><b>".$data_value.$data_description."</b></td></tr>";
				}
			} else {
        			echo "<input type=hidden name=".$header_value." value='".$data_value."'>";
				$$header_value = $data_value;

			}


		} else {

			if ($i == 0 && $hlink != 'N') {
       				echo "<td><b><a href=".$link_reference.(urlencode($data_value)).">".$data_value."</a></b></td>";  
/*
			} else if ($i == 1 && $hlink != 'N') {
        			echo "<td><b><a href=".$PHP_SELF."?".$header_value."=".(urlencode($data_value)).">".$data_value."</a></b></td>";
*/

			} else {

				if ($data_value) {

				if ($header_value == 'password') {
					echo "<td>***********</td>";
				} else {
					if ($ftype == 'numeric' or $ftype == 'integer' or $ftype == 'int2' or $ftype == 'int4' or $ftype == 'int8') {
						echo "<td align=right>".$data_value."</td>";
					} else {
						echo "<td>".$data_value."</td>";
					}
				}
				} else {
        			echo "<td>&nbsp;</td>";

				}
			}
		}


	}

	echo "</tr>";
if (($rownum % 2) != 0) {
	echo ("<TR>");
} else {
	echo("<TR BGCOLOR=#f5f5f5>");
}
	$rownum = $rownum + 1;
}
if ($num_rows > 0) {
if($sumsql) {
echo "<tr>";
$result=execSql($db, $sumsql, $debug);
$fieldnum = pg_num_fields($result);
$rownum = 0;
while ($row = pg_fetch_array($result,$rownum)) {
	for ($i = 0; $i < $fieldnum; $i++) {
        	$ftype = pg_field_type($result,$i);
		$data_value = $row[pg_fieldname($result,$i)];
		if ($ftype == 'numeric' or $ftype == 'integer' or $ftype == 'int2' or $ftype == 'int4' or $ftype == 'int8') {
			echo "<td align=right>".$data_value."</td>";
		} else {
			echo "<td>".$data_value."</td>";
		}
	}
	$rownum = $rownum + 1;
}
}
$sumsql= "";
}

echo "</table>";
$sql = "";
?>
