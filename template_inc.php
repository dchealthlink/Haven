<?
$tablename=$header_table;
                $sql1 = retrieve_columns_select($tablename,'cash_insert');
/*
        if (!$sql1) {
                $sql1 = retrieve_columns($tablename);
        };
*/
$result = execSql($db,$sql1,$debug);
      
$numrows = pg_numrows($result);
$rownum = 0;

echo "<table border=0 cellspacing=0 cellpadding=2 bordercolor=#eeeeee>";
echo "<tr>";
while ($row = pg_fetch_array($result,$rownum))
{

$matrix[$rownum + 0][1] = $row[pg_fieldname($result,1)];
$matrix[$rownum][2] = $row[pg_fieldname($result,4)] - 4;
$matrix[$rownum][3] = $row[pg_fieldname($result,6)];
$matrix[$rownum][5] = $row[pg_fieldname($result,5)];
$matrix[$rownum][7] = $row[pg_fieldname($result,7)];
$matrix[$rownum][8] = $row[pg_fieldname($result,9)];
if ($matrix[$rownum][7] == "W") {
echo "<td></b>".ucfirst(ereg_replace("_"," ",$matrix[$rownum][1]))."</b></td>";
}
$rownum = $rownum + 1;
}
echo "</tr>";

/* for ($i=0;$i < 5; $i++) { */
for ($i=0;$i < $cashier_xa_lines; $i++) {
echo "<tr><td>";
for ($j=0; $j < $numrows; $j++) {
/* echo "<td>"; */
if (($matrix[$j][3]=='int4') or ($matrix[$j][3]=='numeric')) {
        $len_val = '8';
        } else {
        $len_val = $matrix[$j][2];
        }
/* ========= check for lookups ============== */
$l_sql = "SELECT * FROM xref_lookup WHERE xref_tablename = '".$tablename."' AND xref_fieldname = '".$matrix[$j][1]."'";

$l_result = execSql($db,$l_sql,$debug);

$rowarr = pg_fetch_row($l_result, 0);

$lookup_table = $rowarr[2];
$lookup_field = $rowarr[3];
$lookup_desc_field = $rowarr[4];
$lookup_replace_field = $rowarr[5];

if  (pg_NumRows($l_result) > 0) {

        if ($lookup_table != "app_lookup") {
                $l_sql="SELECT ".$lookup_field." as item_cd, ".$lookup_desc_field." as item_description,";
                $l_sql.=$lookup_replace_field." as item_translation from ".$lookup_table." order by 1";
        } else {
                $l_sql="SELECT item_cd, item_description, item_translation from app_lookup where ";
                $l_sql.=" lookup_table = '".$tablename."' AND ";
                $l_sql.=" lookup_field ='".$matrix[$j][1]."' ";

                $l_sql.=" order by sort_order";
        }


$l_result = execSql($db,$l_sql, $debug);


	if ($matrix[$j][1] == 'account_type') {
       	 echo"<select name=".$matrix[$j][1]."[$i] onChange=\"return submitselectenter(this,event,".$i.")\"  onkeydown=\"return submitenter(this,event,".$i.")\" ".$matrix[$j][8]." >"; 
	} else {
       	 echo"<select name=".$matrix[$j][1]."[$i] onkeydown=\"return submitenter(this,event,".$i.")\" ".$matrix[$j][8]." >"; 
	}
/*        echo"<select name=".$matrix[$j][1].$i.">"; 
        echo"<select name=\"first[$i][$j]\">"; */
        if (strlen($matrix[$j][4]) == 0) {
                echo"<option selected value=\"\">";
        }
        $l_rownum=0;
        $l_sql="";

while ($row = pg_fetch_array($l_result,$l_rownum))
{

        $item_cd = $row[pg_fieldname($l_result,0)];
        $item_description = $row[pg_fieldname($l_result,1)];
        $item_translation = $row[pg_fieldname($l_result,2)];

/*
if ($item_cd == $matrix[$j][4]) {
                echo "<option SELECTED value=".$item_translation.">".$item_cd." - ".$item_description;
        } else {
*/
                echo "<option value=".$item_translation.">".$item_cd." - ".$item_description;
/*
        }
*/

$l_rownum = $l_rownum + 1;
}
echo "</select></td><td>";
} else {


        if ($matrix[$j][1]=='password') {
                echo "<input type=password maxlength=".$len_val." size=".$len_val." name=first[$i][$j] value='".$matrix[$j][4]."'></td><td>";
                } else {

        if ($matrix[$j][5] == 'f') {
                $yorn = 'N';
                } else {
                $yorn = 'Y';
                }

                        switch ($matrix[$j][3]) {
                        case "int4" :
		if ($matrix[$rownum][7]=='W') {
                echo "<input class=pink type=text maxlength=8 size=8 name=".$matrix[$j][1]."[$i] value='".$matrix[$j][4]."' onChange=BisInt(this,8,'".$yorn."')></td><td>";
		} else {

                echo "<input type=hidden name=".$matrix[$j][1]."[$i] value='".$matrix[$j][4]."'>";
		if ($matrix[$j][7]=='R') {
                	echo "".$matrix[$j][4]."</td><td>";
		}

		}
                                break;
                        case "numeric" :
		if ($matrix[$j][7]=='W') {

                echo "<input class=pink type=text maxlength=14 size=14 name=".$matrix[$j][1]."[$i] value='".$matrix[$j][4]."' onBlur=calc_it(this) onkeydown=\"return submitenter(this,event,".$i.")\" onChange=BisNum(this,14,'".$yorn."')></td><td>";
		} else {

                echo "<input type=hidden name=".$matrix[$j][1]."[$i] value='".$matrix[$j][4]."'>";
		if ($matrix[$j][7]=='R') {
                	echo "".$matrix[$j][4]."</td><td>";
		}
		}
                                break;
                        case "date" :
		if ($matrix[$j][7]=='W') {
                echo "<input class=pink type=text maxlength=10 size=10 name=".$matrix[$j][1]."[$i] value='".$matrix[$j][4]."' onChange=BisDate(this,'".$yorn."')></td><td>";
		} else {

                echo "<input type=hidden name=".$matrix[$j][1]."[$i] value='".$matrix[$j][4]."'>";
		if ($matrix[$j][7]=='R') {
                	echo "".$matrix[$j][4]."</td><td>";
		}
		}
                                break;
                        default:
		if ($matrix[$j][7]=='W') {

	                /* echo "<input class=pink type=text maxlength=".$matrix[$j][2]." size=".$matrix[$j][2]." name=first[$i][$j] onBlur=calc_it(23) onChange=BisRequired(this,'".$yorn."')></td><td>"; */
			if ($matrix[$j][1] == 'account_id') {
	                echo "<input class=pink type=text maxlength=".$matrix[$j][2]." size=".$matrix[$j][2]." name=".$matrix[$j][1]."[$i] onkeydown=\"return submitenter(this,event,".$i.")\" onChange=ValidateAccountId(".$i.",this,'on')></td><td>";

			} else {
	                echo "<input class=pink type=text maxlength=".$matrix[$j][2]." size=".$matrix[$j][2]." name=".$matrix[$j][1]."[$i] onkeydown=\"return submitenter(this,event,".$i.")\" ".$matrix[$j][8]."></td><td>";
	                /* echo "<input class=pink type=text maxlength=".$matrix[$j][2]." size=".$matrix[$j][2]." name=".$matrix[$j][1]."[$i] onChange=submitenter(this,event,".$i.") onChange=BisRequired(this,'".$yorn."')></td><td>"; */
			}

		} else {

        	        echo "<input type=hidden name=".$matrix[$j][1]."[$i] value='".$matrix[$j][4]."'>";
			if ($matrix[$j][7]=='R') {
                		echo "".$matrix[$j][4]."</td><td>";
			}
		}

                        }


                };
};
};
echo "</tr>";
};
echo "<tr><td colspan=2 align=right>Totals</td>";
echo "<td><input class=white type=text name=billing_total size=14 maxlength=14 DISABLED></td></tr>";
echo "</table>";
?>
