<?php

	$sql = "select c.relname, a.attname, a.attnum, a.attlen, a.atttypmod, a.attnotnull, t.typname, tf.field_label, tf.addl_text, tf.read_write, tf.sort_order, case when a.attnotnull = 't' then 't' else tf.field_mandatory end as field_mandatory, tf.addl_text_pos " ;
	$sql.= " from pg_class c, pg_attribute a, pg_type t, table_field_access tf" ;
	$sql.= " where c.relname = '".$header_table."' and c.oid = a.attrelid and a.attnum > 0 and " ;
	$sql.= " a.atttypid = t.oid ";
	$sql.= " and ((cast(c.relname as varchar) = tf.table_name) and (cast(a.attname as varchar) = tf.field_name)) and ";	
if ($acc_method) {
	$sql.= " tf.access_type='".$acc_method."'";	
} else {
	$sql.= " tf.access_type='insert'";	

}
	$sql.= " order by 1, 11" ;

$result = pg_exec($db,$sql);
        
$numrows = pg_numrows($result);
if(pg_ErrorMessage($db))
        {
        DisplayErrMsg(sprintf("Executing %s ", $sql)) ;
        DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
        };

if ($numrows <= 0) {
        $sql = "select c.relname, a.attname, a.attnum, a.attlen, a.atttypmod, a.attnotnull, t.typname, a.attname as field_label, null as addl_text, 'W' as read_write, a.attnum as sort_order, a.attnotnull as field_mandatory , null as addl_text_pos" ;
        $sql.= " from pg_class c, pg_attribute a, pg_type t" ;
        $sql.= " where c.relname = '".$header_table."' and c.oid = a.attrelid and a.attnum > 0 and " ;
        $sql.= " a.atttypid = t.oid ";
        $sql.= " order by 1, 11" ;

$result = pg_exec($db,$sql);
if(pg_ErrorMessage($db))
        {
        DisplayErrMsg(sprintf("Executing %s ", $sql)) ;
        DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
        };
}

$rownum = 0;

?>
<table border=0 cellspacing=0 cellpadding=2 bordercolor=#eeeeee > 
<?
echo "<tr align=top>";

if ($orient == "horizontal") {

	while ($row = pg_fetch_array($result,$rownum))
	{
        	$matrix[$rownum + 0][1] = $row[pg_fieldname($result,1)];

	        echo "<td>".ucfirst(ereg_replace("_"," ",$matrix[$rownum][1]))."</td>";

		$rownum = $rownum + 1;
	}
	echo "</tr>";

}

$rownum = 0;

while ($row = pg_fetch_array($result,$rownum))
{
        $matrix[$rownum + 0][1] = $row[pg_fieldname($result,1)];
        $matrix[$rownum][2] = $row[pg_fieldname($result,4)] - 4;
if ($row[pg_fieldname($result,4)] < 59) {
        $matrix[$rownum][6] = $row[pg_fieldname($result,4)] - 4;
} else {
        $matrix[$rownum][6] = 55;

}
        $matrix[$rownum][3] = $row[pg_fieldname($result,6)];
        $matrix[$rownum][5] = $row[pg_fieldname($result,7)];
        $matrix[$rownum][7] = $row[pg_fieldname($result,8)];
        $matrix[$rownum][8] = $row[pg_fieldname($result,9)];
        $matrix[$rownum][9] = $row[pg_fieldname($result,11)];
        $matrix[$rownum][10] = $row[pg_fieldname($result,12)];


	if ($matrix[$rownum][8] !== 'H') {
		if ($orient != "horizontal") {

			$addl_info = "&nbsp;";
			if ($matrix[$rownum][7]) {
				$addl_info = $matrix[$rownum][7];
			}
			if (!$matrix[$rownum][5]) {
				$matrix[$rownum][5] = ucwords(ereg_replace("_"," ",$matrix[$rownum][1]));
			}
			switch ($matrix[$rownum][10]) {

			case 'T':
        	 	echo "<tr><td colspan=10 align=center>".$addl_info."</td></tr>";  
        	 	echo "<tr><td>&nbsp;</td>";  
			break;
			case 'L':
        	 	echo "<tr><td>".$addl_info."</td>";  
			break;
			default:
        	 	echo "<tr><td>&nbsp;</td>";  

			}


        		echo "<td align=right nowrap>".$matrix[$rownum][5]." : </td>";
		}
	} 
        if ($matrix[$rownum][3]=='int4') {
                $len_val = '8';
        } else  if ($matrix[$rownum][3]=='int2') {
		$len_val = '4';
	} else {
                $len_val = $matrix[$rownum][2];
        }

/* ========= check for lookups ============== */
        $l_sql = "SELECT * FROM xref_lookup WHERE xref_tablename = '".$header_table."' AND xref_fieldname = '".$matrix[$rownum + 0][1]."'";

        $l_result = pg_exec($db,$l_sql);

        $rowarr = pg_fetch_row($l_result, 0);

        $lookuptable = $rowarr[2];
        $lookupfield = $rowarr[3];
        $lookupdesc = $rowarr[4];
        $lookupreplace_field = $rowarr[5];
        $lookupsort_order = $rowarr[6];

        if  ((pg_NumRows($l_result) > 0) and ($matrix[$rownum][8] == 'W')) {

                if ($lookuptable != "app_lookup") {
                        $l_sql="SELECT ".$lookupfield." as item_cd, ".$lookupdesc." as item_description,";
                        $l_sql.=$lookupreplace_field." as item_translation from ".$lookuptable." ";
                        $l_sql.=" order by ".$lookupsort_order ;
                } else {
                        $l_sql="SELECT item_cd, item_description, item_translation ";
                        $l_sql.=" FROM app_lookup ";
                        $l_sql.=" WHERE lookup_table = '".$header_table."' AND ";
                        $l_sql.=" lookup_field ='".$matrix[$rownum][1]."' ";
                        $l_sql.=" order by sort_order";
                }

                $l_result = pg_exec($db,$l_sql);

                if(pg_ErrorMessage($db)) {
                        DisplayErrMsg(sprintf("Error in executing %s statement", $l_sql)) ;
                        DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
                };
      
/* new for sub_cat only */
	if ($matrix[$rownum][1] != 'sub_cat') {

                echo"<td><select name=".$matrix[$rownum][1]."";
		if ($matrix[$rownum][1] == 'category') {
			echo " size=1 onChange=redirect(this.options.selectedIndex)";
		}

		echo ">";

                if (strlen($$matrix[$rownum][1]) == 0) {
                        echo"<option class=pink selected value=\"\">";
                }

                $l_rownum=0;
                $l_sql="";

                while ($row = pg_fetch_array($l_result,$l_rownum)) {

                        $item_cd = $row["item_cd"];
                        $item_description = $row["item_description"];
                        $item_translation = $row["item_translation"];


                        if ($item_cd == $$matrix[$rownum][1]) {
                                echo "<option class=pink SELECTED value='".$item_translation."'>".$item_cd;
				if ($item_description) {
                                echo " - ".$item_description;
				}
                        } else {
                                echo "<option value='".$item_translation."'><font size=8>".$item_cd;
				if ($item_description) {
                                echo " - ".$item_description."</font>";
				}
                        }

                        $l_rownum = $l_rownum + 1;
                }

                echo "</select></td>";

	} else {

$sql1="SELECT category, sub_cat, sub_cat_desc  FROM sub_category order by 1, 2 ";
                $l_result = pg_exec($db,$sql1);

/* ====================== this is the start ============== */

echo "<td><SELECT NAME=temp_sub_cat size=1 onChange=go(this.options.selectedIndex)>"; 
if ($sub_cat) {

echo "<option>".$sub_cat."</option>";

} else {
echo "<option>ALL</option>";

}
echo "</SELECT>";

$rownum1 = 0;
$groupnum = -1;
$subgroupnum = 0;
$groupnm = "";

?>
<script>
var temp=document.mainform.temp_sub_cat
var z=2
var groups=document.mainform.category.options.length
var group=new Array(groups)
for (i=0; i<groups; i++)
group[i]=new Array()
<?

while ($row = pg_fetch_array($l_result,$rownum1))
{

if ($groupnm == $row[pg_fieldname($l_result,0)]) {
        $subgroupnum = $subgroupnum + 1;
} else {
        $subgroupnum = 0;
        $groupnum = $groupnum + 1;
        $groupnm = $row[pg_fieldname($l_result,0)] ;
}
?>
group[<?php echo $groupnum ?>][<?php echo $subgroupnum ?>]=new Option("<?php echo $row[pg_fieldname($l_result,1)] ?>")
<?
$rownum1 = $rownum1 + 1;
}
?>


function redirect(x){
z=x;
for (m=temp.options.length-1;m>0;m--)
temp.options[m]=null
for (i=0;i<group[x].length;i++){
temp.options[i]=new Option(group[x][i].text,group[x][i].value)
}
temp.options[0].selected=true 
}
function go(y){
document.mainform.sub_cat.value=group[z][y].text;
}
</script>

<?
echo "<input type=hidden name=sub_cat value=ALL>"; 
}

/* ====================== this is the end ================ */





        } else {


        if  ((pg_NumRows($l_result) > 0) and ($matrix[$rownum][8] == 'R')) {
			$db_item_description = "";

                if ($lookuptable != "app_lookup") {
                        $l_sql="SELECT ".$lookupdesc." as item_description";
                        $l_sql.=" from ".$lookuptable." ";
                        $l_sql.=" where ".$lookupfield." = '".$$matrix[$rownum][1]."'" ;
                } else {
                        $l_sql="SELECT item_description ";
                        $l_sql.=" FROM app_lookup ";
                        $l_sql.=" WHERE lookup_table = '".$header_table."' AND ";
                        $l_sql.=" lookup_field ='".$matrix[$rownum][1]."' ";
                        $l_sql.=" and item_cd = '".$$matrix[$rownum][1]."'";
                }
			$l_result = pg_exec($db,$l_sql);

			list($db_item_description) = pg_fetch_row ($l_result, 0);
			$db_item_description = " - ".$db_item_description;
	}

                        switch ($matrix[$rownum][3]) {
                        case "int2" :

			if ($matrix[$rownum][8] == 'R' or $matrix[$rownum][8] == 'H') {
                echo "<input type=hidden  name=".$matrix[$rownum][1]." value=".$$matrix[$rownum][1].">";
			if ($matrix[$rownum][8] == 'R') { 
                echo "<td>".$$matrix[$rownum][1].$db_item_description."</td>";
			}

			} else {
                echo "<td colspan=7><input type=text class=pink maxlength=4 size=5 name=".$matrix[$rownum][1]." value='".$$matrix[$rownum][1]."' onblur=BisInt(this,4,'N')></td>";
			}
                                break;
                        case "int4" :

/* remember - changed 5 to 8 for tf.read_write */

			if ($matrix[$rownum][8] == 'R' or $matrix[$rownum][8] == 'H') {
                echo "<input type=hidden  name=".$matrix[$rownum][1]." value=".$$matrix[$rownum][1].">";
			if ($matrix[$rownum][8] == 'R') { 
                echo "<td>".$$matrix[$rownum][1].$db_item_description."</td>";
			}

			} else {
                echo "<td colspan=7><input type=text class=pink maxlength=8 size=9 name=".$matrix[$rownum][1]." value='".$$matrix[$rownum][1]."' onblur=BisInt(this,8,'N')></td>";
			}
                                break;
                        case "numeric" :
			if ($matrix[$rownum][8] == 'R') {
                echo "<td><input type=hidden  name=".$matrix[$rownum][1]." value=".$$matrix[$rownum][1].">".$$matrix[$rownum][1]."</td>";
			} else {
                echo "<td colspan=7><input type=text class=pink maxlength=14 size=15 name=".$matrix[$rownum][1];
		if ($flddisp != 'N') {
			echo " value='".$$matrix[$rownum][1]."'";
	}
		echo " onblur=BisNum(this,14,'N')></td>";
			}
                                break;
                        case "timestamp" :

			if ($matrix[$rownum][8] == 'R' or $matrix[$rownum][8] == 'H') {
                echo "<input type=hidden  name=".$matrix[$rownum][1]." value=".$$matrix[$rownum][1].">";
			if ($matrix[$rownum][8] == 'R') { 
                echo "<td>".$$matrix[$rownum][1].$db_item_description."</td>";
			}

			} else {
                echo "<td colspan=7><input type=text class=pink maxlength=25 size=26 name=".$matrix[$rownum][1]." value='".$$matrix[$rownum][1]."' onblur=BisTimestamp(this,25,'N')></td>";
			}
                                break;
                        case "date" :
			if ($matrix[$rownum][8] == 'R') {
                echo "<td><input type=hidden  name=".$matrix[$rownum][1]." value='".$$matrix[$rownum][1]."'>".$$matrix[$rownum][1]."</td>";
			} else {
                echo "<td colspan=7><input type=text class=pink maxlength=10 size=11 name=".$matrix[$rownum][1];
		if ($flddisp != 'N') {
 			echo " value='".$$matrix[$rownum][1]."'"; 
		}
		echo " onblur=BisDate(this,10,'N')></td>";
			}
                                break;

                        case "text" :
			if ($matrix[$rownum][8] == 'R') {
                echo "<td><input type=hidden  name=".$matrix[$rownum][1]." value='".$$matrix[$rownum][1]."'>".$$matrix[$rownum][1]."</td>";
			} else {
		if ($flddisp != 'N') {
                	echo "<td colspan=7><textarea class=pink rows=10 cols=90 name=".$matrix[$rownum][1].">".$$matrix[$rownum][1]."</textarea></td>";
		} else { 
                	echo "<td colspan=7><textarea class=pink rows=10 cols=90 name=".$matrix[$rownum][1]."></textarea></td>";

		}		
		}
                                break;


                        default:
			if ($matrix[$rownum][8] == 'R' or $matrix[$rownum][8] == 'H') {
                echo "<input type=hidden  name=".$matrix[$rownum][1]." value='".$$matrix[$rownum][1]."'>";
			if ($matrix[$rownum][8] == 'R') {
                echo "<td>".$$matrix[$rownum][1].$db_item_description."</td>";
			}

			} else {
			$inptype = "text";
		if ($matrix[$rownum][1] == 'password') {
			$inptype = "password";
		}

                echo "<td colspan=7><input type=".$inptype." class=pink size=".$matrix[$rownum][6]." maxlength=".$matrix[$rownum][2]." size=".$matrix[$rownum][2]." name=".$matrix[$rownum][1]." ;";
	if ($flddisp != 'N') {
            echo " value='".$$matrix[$rownum][1]."'>";
	}
		echo "</td>";
			}
                        }

}

/* echo "<input type=hidden name=view_fieldname[".$rownum."] value=".$matrix[$rownum][1].">";
echo "<input type=hidden name=view_type[] value=".$matrix[$rownum][3].">";
echo "<input type=hidden name=lookup[] value=".$matrix[$rownum][4].">";
*/
if ($matrix[$rownum][10] == 'R') {
        echo "<td>".$addl_info."</td>";

} else {

        echo "<td>&nbsp;</td>";

}

$rownum = $rownum + 1;

if ($orient != "horizontal") {
/*	echo "</tr>"; */
}
};
if ($orient == "horizontal") {
	/* echo "</tr>"; */
}

echo "</tr>";
echo "</table>";
?>
<SCRIPT LANGUAGE="Javascript">
<?
for ($j=0;$j< $rownum; $j++) {
if ($matrix[$j][9]=="t" && $matrix[$j][8]=="W") {
?>
function check<?php echo $matrix[$j][1] ?>() {
    var return<?php echo $matrix[$j][1] ?>=false
    var inp02=document.mainform.<?php echo $matrix[$j][1] ?>.value
    if (inp02=="") {
     alert("Field: <?php echo strip_tags($matrix[$j][5]) ?> is Mandatory -- please enter")
    } else {
     return<?php echo $matrix[$j][1] ?>=true
    }
    return return<?php echo $matrix[$j][1] ?>
}
<?
}
}
?>
function chkForm1() {
<?
for ($j=0;$j< $rownum; $j++) {
if ($matrix[$j][9]=="t" && $matrix[$j][8]=="W") {
?>
   varF<?php echo $j ?>A=check<?php echo $matrix[$j][1] ?>();
   if (varF<?php echo $j ?>A==false) {
       document.mainform.<?php echo $matrix[$j][1] ?>.focus();
       return false;
   } 
<?
}
}
?>
	return true;
        }


</SCRIPT>
