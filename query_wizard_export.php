<?php
session_start();
session_unregister("query_value");
include("inc/dbconnect.php");

if ($NEWQUERY) {
	Header("Location: gen_select.php");
}
if ($EXPORTQUERY) {
$result = pg_exec($db, $query_value);
	$numrows = pg_numrows($result);

if (!$result) {
	printf("<br>No Rows Returned - possible error<br>");
} else {
	$numfields = pg_numfields($result);
	printf("Rows: <b>%d </b><br>",$numrows);
        $outfile = fopen($load_filename,"w") ;

for ($i=0;$i<$numrows;$i++) {
	$outputline="";

	$rowarr = pg_fetch_row($result,$i);
	for ($j=0;$j<$numfields;$j++) {
		$outputline.=$rowarr[$j].$load_delimiter;
	}
        $outputline=substr($outputline,0,strlen($outputline)-1);
        fputs($outfile,$outputline);
        fputs($outfile,"\n");
}
        fclose($outfile);

if ($result) pg_freeresult($result);
}
}

include("inc/index_header_inc.php");
/*
if(!session_is_registered("ownerid"))
{
header("Location: itlogin.php");
exit;
}
if ($client_name !== 'admin')
{
header("Location: itlogin.php");
exit;
}
*/
?>
<HTML>

<br clear="all">

  <blockquote>
   <h1>Export Query Data</h1>
  <?php

if($submit)
{

DisplayErrMsg(sprintf("Start time: %s",date("m-d-y h:i:s"))) ;
$sql = "COPY " . $table_name . " FROM " . "'" . $file_name ."' USING DELIMITERS ';';";
$result = pg_exec($db, $sql);

	if (pg_ErrorMessage($db)) {
     		DisplayErrMsg(sprintf("Error in executing %s statement", $sql)) ;
     		DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
	} 


pg_freeresult($result);
$sql = "INSERT INTO LOG (log_name, log_type, log_level, log_dir, log_file,
	log_status, log_timestamp) VALUES ('" . $table_name . "','Data Load',1,'"
	 . dirname($file_name) ."','" . basename($file_name) . "','PENDING', NOW());";
$result = pg_exec($db, $sql);

DisplayErrMsg(sprintf("End Time  : %s", date("m-d-y h:i:s"))) ;
pg_freeresult($result);
echo "<p>Data from File: " . $file_name . " has been Loaded</p>";

};

$sql ="select table_name from application_table order by 1";

$result = pg_exec($db,$sql);
$sql1 ="select item_cd, item_description, item_translation from app_lookup where lookup_table = 'copy_template_header' and lookup_field = 'load_type' order by sort_order";

$result1 = pg_exec($db,$sql1);
$sql2 ="select item_cd, item_description, item_translation from app_lookup where lookup_table = 'copy_template_header' and lookup_field = 'load_delimiter' order by sort_order";

$result2 = pg_exec($db,$sql2);

if(pg_ErrorMessage($db))
        {
        DisplayErrMsg(sprintf("Error in executing %s statement", $sql)) ;
        DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
        };
?>
  <form method="post" action="<?php echo $PHP_SELF ?>">

      <p>
    File Name:<br><input type="text" maxlength="80" size="60" name="load_filename" ><br>
    Query:<br><input type="hidden" name="query_value" value="<?php echo $query_value ?>"><b><?php echo $query_value ?></b><br>

          <br>

    Export Type:<br>

<?
        echo"<select name=\"load_type\">";
        echo"<option selected value=\"\">";
        $l_rownum=0;

while ($row = pg_fetch_array($result1,$l_rownum))
{
        $item_cd = $row["item_cd"];
        $item_description = $row["item_description"];
        $item_translation = $row["item_translation"];
        echo "<option value=".$item_translation.">".$item_cd." - ".$item_description;
        $l_rownum = $l_rownum + 1;
}
echo "</select>";
?>
          <br>



    Export Delimiter:<br>

<?
        echo"<select name=\"load_delimiter\">";
        echo"<option selected value=\"\">";
        $l_rownum=0;

while ($row = pg_fetch_array($result2,$l_rownum))
{
        $item_cd = $row["item_cd"];
        $item_description = $row["item_description"];
        $item_translation = $row["item_translation"];
        echo "<option value=".$item_translation.">".$item_cd." - ".$item_description;
        $l_rownum = $l_rownum + 1;
}
echo "</select>";
?>
          <br>

    Show Results:<br>
<?
        echo"<select name=\"show_results\">";

        echo "<option selected value=N>N";
        echo "<option value=Y>Y";

echo "</select>";

?>

    <br>
    <br>
    <input class="gray" type="Submit" name="EXPORTQUERY" value="Export Query">
    <input class="gray" type="Submit" name="NEWQUERY" value="New Query">
    </p>
  </form>
</blockquote>
<?
echo "<br>";
include "inc/footer_inc.php";
?>
</body>
</HTML>
