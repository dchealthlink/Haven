<?
session_start();
include("inc/dbconnect.php");
$show_menu='ON';
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
   <h1>Employee Data</h1></td></tr>
  <?php

if (!$employee_id) {
	$employee_id=$key_value;
}
$header_table = "employee";
/* $acc_method = "view"; */
$header_where_clause = " where table_name = 'employee' and access_type = 'view' ";
$where_clause = " where table_name = 'employee' "; 
$num_rows = count_table_field_access ($db, $header_table ,$where_clause);
echo "<FORM NAME=mainform METHOD=post ACTION=".$PHP_SELF.">";

$sql= "SELECT employee_id, first_name, mid_init, last_name, suffix, employee_type, city, state FROM employee where employee_id = '".$employee_id."'"; 

$orient = "vertical";
$checkorder = "NO";

echo "<tr><td valign=top>";
include("inc/view_form_inc.php");
echo "</td></tr>";

$acc_method="insert";
$header_table = "employee_work";
$orient = "horizontal";
echo "<tr><td valign=top>";
include("inc/input_form_inc.php");
echo "</td></tr>";


$sql = "SELECT * FROM shift_code ";


$header_table = "shift_code";
$orient = "horizontal";
echo "<tr><td valign=top>";
include("inc/view_form_inc.php");
echo "</td></tr>";

?>

          <tr>
    <td>
<input class="gray" type="button" name="VIEWCOMMENT" value="View Comments" onclick="javascript:window.open('view_request_comments.php?request_id=<?php echo $request_id ?>', 'commentWindow', 'scrollbars,width=700,height=500')">&nbsp;

<?php

	if ($status == 'DN') {
?>		
		<input class="gray" type="button" name="ADDSURVEY" value="Add Survey" onclick="javascript:window.open('insert_survey_answer.php?request_id=<?php echo $request_id ?>', 'surveyWindow', 'scrollbars,width=800,height=600')">&nbsp;
<?php
	}
?>

	</td></tr>   

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
