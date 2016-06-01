<?php
session_start();
$show_menu = "ON";
/*	
if(!session_is_registered("userid"))
{
header("Location: index.htm");
exit;
}
*/
include("inc/dbconnect.php");

if ($load_filename) {
	$load_filename = '/tmp/'.$load_filename; 
/*	$load_filename = '/tmp/'.$load_filename; */
}
/*
$ret_code = valid_application_level ($db, $tablename, $user_type);

if ($ret_code == 0) {
	DisplayErrMsg(sprintf("Invalid User Type for table %", $tablename)) ;
	echo "<script>";
	echo "history.back()";
	echo "</script>";
}
*/

if($continue_export)
{
        $continue_export = "";

        $sql = "SELECT max(load_id) + 1 as next_load_id from copy_template_header";
        $result = pg_exec($db, $sql);
        list($load_id) = pg_fetch_row($result, 0);

        if (!$load_id) {
                $load_id = 1;
        }
//        session_register("load_id");
	$_SESSION['load_id'] = $load_id;

        $where_array[0][0] = "load_id";
        $where_array[0][1] = $load_id;
        $load_id = $load_id;

        $sql = "INSERT INTO copy_template_header (load_id,
                load_filename,
                load_temptablename,
                load_tablename,
                load_type,
                load_delimiter,
                load_line_term,
                load_timestamp
                ) values ("
                .$load_id.",'"
                .$load_filename."','"
                .$load_temptablename."','"
                .$load_tablename."','"
                .$load_type."','"
                .$load_delimiter."','"
                .$load_line_term."',
                now())";

        $result = pg_exec($db, $sql);

        if (pg_ErrorMessage($db)) {
                DisplayErrMsg(sprintf("Error in executing %s statement", $sql)) ;
                DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;

        }


pg_freeresult($result);
/*
$sql = "INSERT INTO LOG (log_name, log_type, log_level, log_dir, log_file,
        log_status, log_timestamp) VALUES ('" . $table_name . "','Data Load',1,'"
         . dirname($file_name) ."','" . basename($file_name) . "','PENDING', NOW());";
$result = pg_exec($db, $sql);

*/
} else {
$sql="SELECT * from copy_template_header where load_id = ".$load_id;

$result = pg_exec($db,$sql);

list($load_id, $load_filename, $load_temptablename, $load_tablename, $load_type, $load_delimiter, $load_line_term, $load_timestamp) = pg_fetch_row($result, 0);

};



include("inc/index_header_inc.php");
?>
<HTML>

<MAP NAME="map1">
<AREA
   HREF="load_wizard_export.php" ALT="Wizard Step 1" TITLE="Header"
   SHAPE=RECT COORDS="100,5,177,75">
</MAP>

<IMG SRC="images/step2of2.gif"
   ALT="map of wizard" BORDER=0 WIDTH=500 HEIGHT=100
   USEMAP="#map1"><BR>

<?
/*
[ <A HREF="cts.html" ALT="Contacts">Contacts</A> ]
[ <A HREF="products.html" ALT="Products">Products</A> ]
[ <A HREF="new.html"      ALT="New!">New!</A> ]



<img src="images/step2.gif">
*/
?>




<br clear="all">
  <blockquote>
  <h1>Select Data</h1>
  <form method="post" action="<?php echo $PHP_SELF?>">

  </b> 
<?

/* === */
$sql ="select table_name from application_table ";


switch ($user_type) {
        case "user":
                $sql.= " WHERE table_type = 'user' order by table_name";
                break;
        case "admin":
                $sql.= " WHERE table_type != 'vendor' order by table_name";
                break;
        case "vendor":
                $sql.= " order by table_name";
                break;
        default:
                $sql.= " order by table_name";
        }

$result = pg_exec($db,$sql);

if(pg_ErrorMessage($db))
        {
        DisplayErrMsg(sprintf("Error in executing %s statement", $sql)) ;
        DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
        };

?>
      <p>
</tr><tr><td>
<table border=1 cellspacing=0 cellpadding=2 bordercolor=#eeeeee width=400><tr><td>
    File Name:</td><td><b>
    <?php echo $load_filename ?></b>
    <input type="hidden" name="load_id" value="<?php echo $load_id ?>">
    <input type="hidden" name="load_filename" value="<?php echo $load_filename ?>">
</td></tr><tr>
    <td>Table Name:</td><td><b>
    <?php echo $load_tablename ?></b>
    <input type="hidden" name="load_tablename" value="<?php echo $load_tablename ?>" >
</td></tr><tr>
    <td>Delimiter:</td><td><b>
    <?php echo $load_delimiter ?></b>
    <input type="hidden" name="load_delimiter" value="<?php echo $load_delimiter ?>" >
</td></tr><tr>
    <td>Show Results:</td><td>

<?
/*
    <input type="text" name="show_results" value="<?php echo $show_results ?>" maxlength="1" size="1">
*/
        echo"<select name=\"show_results\">";
if ($show_results=="N") {
        echo "<option selected value=N>N";
        echo "<option value=Y>Y";
} else {
        echo "<option value=N>N";
        echo "<option selected value=Y>Y";
}

echo "</select>";

?>




	</td></tr>

</table>
</td></tr><tr><td>

<p>
	<b>Select from : </b><? echo $load_tablename ?><br>
</td></tr><tr><td>
<?

include ("inc/date.php");

echo "<p><table border=1 cellspacing=0 cellpadding=2 bordercolor=#eeeeee width=600>";
/* NEED TO HAVE A PARAMETER PASSED HERE THAT IS THE TABLE NAME */

$sql="SELECT c.relname, a.attname, a.attnum, t.typname, case when t.typname = 'int4' then '8' when t.typname = 'date' then '10' when t.typname = 'timestamp' then '20' when t.typname = 'numeric' then '14' else a.atttypmod - 4 end as atttypmod, a.attlen, a.attnotnull, t.typname ";
$sql.="FROM pg_class c, pg_attribute a, pg_type t ";
$sql.="WHERE c.relname = '".$load_tablename."' and c.oid = a.attrelid and a.attnum > 0 and ";
$sql.="a.atttypid = t.oid order by 1, 3";


$result1 = pg_exec($db,$sql);
if(pg_ErrorMessage($db))
	{
	if ($debug) {
		DisplayErrMsg(sprintf("Error in executing %s statement", $sql)) ;
	}
	DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
	};

$rownum = 0;
echo "<tr align=top>";
echo "<td><b>Fieldname</b></td>";
echo "<td><b>Fieldtype</b></td>";
echo "<td><b>Length</b></td>";
echo "<td><b>Include?</b></td>";
echo "<td><b>Sort<br>Order</b></td>";
echo "<td><b>Search Criteria</b></td>";
echo "</tr>";

while ($row = pg_fetch_array($result1,$rownum))
{
$fieldlabel=$row[pg_fieldname($result1,1)];
$fldtype=$row[pg_fieldname($result1,7)];
/*
$fldlength=$row[pg_fieldname($result1,5)] - 4;
*/
$fldlength=$row[pg_fieldname($result1,4)] ;
echo "<tr align=top>";
echo "<td><input type=hidden name=table_field_array[$rownum][0] value=".$fieldlabel.">";
echo "$fieldlabel</td>";
echo "<td><input type=hidden name=table_field_array[$rownum][1] value=".$fldtype.">";
echo "$fldtype</td>";
echo "<td><input type=hidden name=table_field_array[$rownum][2] value=".$fldlength.">";
echo "$fldlength</td>";
echo "<td><input type=checkbox name=table_field_array[$rownum][3]></td>";
echo "<td><input type=text size=2 name=table_field_array[$rownum][4]></td>";
echo "<td><input type=text size=40 name=table_field_array[$rownum][5]></td>";
echo "</tr>";
$rownum = $rownum + 1;
}


if ($submit) {
$sql="SELECT ";
$chkrows = count ($table_field_array);

$singlearray[]= "";
$order_by = "";

$numkeys = 2;
$j = 0;
for ($i = 0; $i < $chkrows; $i++) {

	if ($table_field_array[$i][3]) {
		$sql.=$table_field_array[$i][0].", ";

	}
	if ($table_field_array[$i][4] && !$singlearray[$table_field_array[$i][4]]) {

		$singlearray[$table_field_array[$i][4]] = $table_field_array[$i][0];
		if ($table_field_array[$i][4] > $topval) {
			$topval = $table_field_array[$i][4];
		}

	}
	if ($table_field_array[$i][5]) {
		$where_clause.= $table_field_array[$i][0]." ".$table_field_array[$i][5]." and ";
	}
};

for ($i = 0; $i < $topval + 1; $i++) {

 	if ($singlearray[$i]) {  

	$order_by.=$singlearray[$i].",";
	}  

}

if ($order_by) {
	
	$order_by =" ORDER BY ".substr($order_by,0,-1);

}

if ($where_clause) {
	
	$where_clause =" WHERE ".substr($where_clause,0,-5);
}

$sql= substr($sql,0,strlen($sql)-2)." FROM ".$load_tablename." ".$where_clause." ".$order_by;

$sql = stripslashes($sql);
echo ("Query: <b>\"$sql\"</b><br><br>");
$result = pg_exec($db, $sql);

if ($result) {
$numrows = pg_numrows($result);
$numfields = pg_numfields($result);
printf("Rows: <b>%d </b><br>",$numrows);
//        $outfile = fopen($dfile_name,"w") ;
        $outfile = fopen($load_filename,"w") ;

} else {
printf("<br>No Rows Returned - possible error<br>");
}


?>
<TABLE BORDER>
<?php
if ($result) {
	echo "<br><br>";
	echo "<a href=# onclick=javascript:window.open('export_download.php','downloadWindow','toolbar=0,location=0,left=0,top=0,resizable=1,scrollbars=yes,size=yes,width=650,height=300')>Download File</a>";
	echo "<br><br>";
	echo("\n<TR BGCOLOR=\"f5f5f5\">");
	for ($i=0;$i<$numfields;$i++) {
	$fldname = pg_fieldname($result,$i);
	$fldname = ereg_replace("_","<br>",$fldname);
	if ($show_results=="Y") {
		echo ("<Td><b>$fldname</b></Td>");
	}
}

echo ("</TR>");
$color = "f5f5f5";
	
for ($i=0;$i<$numrows;$i++) {
$outputline="";

if (($i % 2) == 0) {
echo ("<TR>");
} else {
echo ("<TR BGCOLOR=$color>");
}
$rowarr = pg_fetch_row($result,$i);
for ($j=0;$j<$numfields;$j++) {
$val = $rowarr[$j];
	if ($val == "") {

	      $val = "&nbsp;";
	      $outputline.=$load_delimiter;
	} else { 
	      $outputline.=$val.$load_delimiter;
	}

	if ($show_results=="Y") {
		echo ("<TD>$val</TD>");
	}
}
        $outputline=substr($outputline,0,strlen($outputline)-1); 
        fputs($outfile,$outputline);
        fputs($outfile,"\n");
	if ($show_results=="Y") {
		echo ("</TR>");
	}
}
}
/* === */
        fclose($outfile);


/* === */
if ($result) pg_freeresult($result);
?>
</table>
<?

};

?>
<!--    </table>
	<table border=0 cellspacing=0 cellpadding=2 bordercolor=#eeeeee> -->
	<tr><td><input class="gray" type="Submit" name="submit" value="Submit">&nbsp;
     <input class="gray" type="Reset" name="clear"></td>
<?
/*
	<td><input type="hidden" name="load_tablename" value="<?php echo $load_tablename?>"></td>
*/
?>
	</tr>

 </table>
    </p>
  </form>
</blockquote>

<?
include "inc/footer_inc.php";
?>
 </table>

</body>
</HTML>



