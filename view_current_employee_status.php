<?
session_start();
include("inc/dbconnect.php");
include("inc/libmail.php");

/*
include("inc/navigation_inc.php");
if(!session_is_registered("key_attribute"))
{
header("Location: index.htm");
exit;
} else {
$$key_attribute = $key_value;
}


$menu_enabled=0;

$left_menu = display_menu_array($db,(ereg_replace("/","",$PHP_SELF)),$HTTP_REFERER,$menu_enabled, $userlevel);
*/



if ($SUBMIT) {


	$m= new Mail; // create the mail
	$m->From( "tafahey@comcast.net" );
	$m->To( "thomas_fahey@msn.com" );
	$m->Subject( "the subject of the mail" );	

	$message= "Hello world!\n";
	$message= "This is a test of the Mail class\n";
	$message.="The campaign_id is : ".$campaign_id." \n";
	$message.="The cust_id is : ".$cust_id." \n";
	$message.="The campaign_status is : ".$campaign_status." \n";
	$m->Body( $message);	// set the body
//	$m->Cc( "someone@somewhere.fr");
//	$m->Bcc( "someoneelse@somewhere.fr");
	$m->Priority(4) ;	// set the priority to Low 
//	$m->Attach( "/home/leo/toto.gif", "image/gif" ) ;	// attach a file of type image/gif
	$m->Send();	// send the mail
	echo "the mail below has been sent:<br><pre>", $m->Get(), "</pre>";



}
include("inc/header_inc.php");
?>
<HTML>

  <blockquote>
   <h1>Employee Log Data</h1></td></tr>
  <?php


$header_table = "employee";
$acc_method = "view";
$header_where_clause = " where table_name = 'employee' and access_type = 'view' ";
$where_clause = " where table_name = 'employee' "; 
$num_rows = count_table_field_access ($db, $header_table ,$where_clause);
echo "<FORM NAME=mainform METHOD=post ACTION=".$PHP_SELF.">";

$orient = "vertical";

if (!$employee_id) {

	$employee_id = $key_value;

};


echo "<tr><td valign=top>";
include("employee_inc.php");
echo "</td></tr>";

echo "<tr><td><b>Current Status</b></td></tr>";

$header_table = 'employee_open_log';
$acc_method = "view";
$sql = "SELECT employee_id, log_timestamp, log_code, log_subcode, log_state, log_time, log_dept, log_in, log_out, log_error, log_closed FROM ".$header_table." WHERE employee_id = '".$employee_id."' AND log_error != 'Y' AND (log_closed is null OR log_closed = 'N')";
$sql_where_clause = " WHERE request_id = '".$request_id."'";


$list_label="N";
$link_reference="";
$orient= "horizontal";
echo "<tr><td valign=top>";
include("inc/view_form_inc.php");
echo "</td></tr>";

echo "<tr><td><b>Open Records (Error Condition)</b></td></tr>";

$header_table = 'employee_open_log';
$acc_method = "view";
$sql = "SELECT  employee_id, log_timestamp, log_code, log_subcode, log_state, log_time, log_dept, log_in, log_out, log_error, log_closed  FROM ".$header_table." WHERE employee_id = '".$employee_id."' AND log_error = 'Y' AND (log_closed is null OR log_closed != 'Y')";
$sql_where_clause = " WHERE request_id = '".$request_id."'";


$list_label="N";
$link_reference="";
$orient= "horizontal";
echo "<tr><td valign=top>";
include("inc/view_form_inc.php");
echo "</td></tr>";



echo "<tr><td><b>Activity Last 7 Days</b></td></tr>";

$header_table = 'employee_log';
$acc_method = "view";
$sql = "SELECT  employee_id, log_timestamp, log_code, log_subcode, log_state, log_time, log_dept, log_in, log_out, log_error, log_closed  FROM ".$header_table." WHERE employee_id = '".$employee_id."'"; 
$sql.=" AND log_timestamp > (now()::date - 7)";
$sql_where_clause = " WHERE request_id = '".$request_id."'";


$link_reference="";
$orient= "horizontal";
echo "<tr><td valign=top>";
include("inc/view_form_inc.php");
echo "</td></tr>";

?>
    <input type="hidden" name="employee_id" value="<?php echo $employee_id ?>">
 </p>
  </form>

</blockquote>
<?
include "inc/footer_inc.php";
?>
</table>
</body>
</HTML>
