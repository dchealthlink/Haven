<?php
session_start();
session_unregister("query_value");
if ($NEWQUERY) {
header("Location: gen_select.php");
}
if ($EXPORTQUERY) {
session_register("query_value");
$query_value=$query_value;
header("Location: query_wizard_export.php");
}

include("inc/index_header_inc.php");
/*
if ($client_name !== 'admin')
{
header("Location: index.htm");
exit;
}
	*/
?>
<HTML>

  <blockquote>
   <h1>Save Query</h1>
  <?php
include("inc/dbconnect.php");

if($submitsave)
{

	$sql1 = "INSERT INTO user_query VALUES ('".$userid."','".$query_name."','".$query_description."','".$query_value."')";

	$result = pg_exec($db, $sql1);

		if (pg_ErrorMessage($db)) {
			DisplayErrMsg(sprintf("Error in executing %s statement", $sql1)) ;
			DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;  
		} else {

		echo "<p>Query : <b>".$query_name."</b> has been saved</p>";
		}
};


?>
  <form method="post" action="<?php echo $PHP_SELF?>">

      <p>
    Query Name:<br>
    <input type="text" size="30" name="query_name" value="<?php echo $query_name?>">
    <br>
    Query Description:<br>
    <input type="text" size="60" name="query_description" value="<?php echo $query_description?>">
    <br>
    Query:<br>
<?
	echo ("<b>".$query_value."</b>");
?>  
  <input type="hidden" name="query_value" value='<?php echo $query_value ?>'>
    <br>


          <br>
    <br>
    <input class="gray" type="Submit" name="submitsave" value="Save Query">
    <input class="gray" type="Submit" name="EXPORTQUERY" value="Export Query Data">
    <input class="gray" type="Submit" name="NEWQUERY" value="NeW Query">
    <input class="gray" type="Reset" name="reset" value="Reset">
    </p>
  </form>
</table>
</blockquote>
<?
/* include "inc/nav.inc"; */
include "inc/footer_inc.php";
?>
</body>
</HTML>
