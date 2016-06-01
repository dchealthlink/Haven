<?php
session_start();
include("inc/dbconnect.php");
$show_menu="ON";
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
<MAP NAME="map1">
<AREA
   HREF="load_wizard_export.php" ALT="Wizard Step 1" TITLE="Header"
   SHAPE=RECT COORDS="100,5,177,75">
</MAP>

<IMG SRC="images/step1of2.gif"
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
   <h1>Load Data</h1>
  <?php

if($submit)
{
	if ($table_name = 'load_temp') 
	{
		$sql = "UPDATE LOG SET log_status = 'REPLACED' where log_name = '" . $table_name .
		"' AND log_status = 'PENDING';";
		$result = pg_exec($db, $sql);
		pg_freeresult($result);

		$sql = "TRUNCATE TABLE " . $table_name . ";";
		$result = pg_exec($db, $sql);
		pg_freeresult($result);
	}

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

$sql ="select table_name from application_table where user_level = '5' order by 1";

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
  <form method="post" action="export_template.php">

      <p>
    File Name:<br><input type="text" maxlength="80" size="60" name="load_filename" ><br>

    Table Name:<br>

<?
        echo"<select name=\"load_tablename\">";
        echo"<option selected value=\"\">";
        $l_rownum=0;

while ($row = pg_fetch_array($result,$l_rownum))
{
        $table_name = $row["table_name"];
        echo "<option value=".$table_name.">".$table_name;
        $l_rownum = $l_rownum + 1;
}
echo "</select>";
?>
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
    <input class="gray" type="Submit" name="continue_export" value="Continue">
    </p>
  </form>
</blockquote>
<?
echo "<br>";
include "inc/footer_inc.php";
?>
</body>
</HTML>
