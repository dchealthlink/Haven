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
if ($cust_id) {
	$sql_where_clause =" where cust_id = ".$cust_id ; 
	$menu_enabled = 1;
	$key_attribute = "cust_id";
	$key_value = $cust_id;
}


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
<script language="javascript">
<!--
function submitform(form){
  var myindex=form.department_id.selectedIndex;
  prim=form.department_id.options[myindex].value;
  location="view_employee.php?department_id="+prim;
  }
//-->
</script>
</head>

  <blockquote>
   <h1>Employee Data</h1></td></tr>
  <?php


$header_table = "employee";
$acc_method = "view";
$header_where_clause = " where table_name = 'employee' and access_type = 'view' ";
$where_clause = " where table_name = 'employee' "; 
$num_rows = count_table_field_access ($db, $header_table ,$where_clause);
echo "<FORM NAME=mainform METHOD=post ACTION=".$PHP_SELF.">";
echo "<tr><td>Department ID:&nbsp;";

$dpt_sql = "SELECT department_id, department_name FROM department ORDER BY 2";

$dpt_result = execSql($db, $dpt_sql, $debug);

echo "<SELECT NAME=department_id onChange=submitform(this.form)>";
echo"<option selected value=\"\">";

$rownum = 0;
        while ($row = pg_fetch_array($dpt_result,$rownum))
        {
                list($t_dept_id, $t_dept_name) = pg_fetch_row($dpt_result,$rownum);
                if ($department_id == $t_dept_id) {
                        echo "<option SELECTED value=".$t_dept_id.">".$t_dept_name;
                } else {
                        echo "<option value=".$t_dept_id.">".$t_dept_name;
                }
        $rownum = $rownum + 1;
        }

echo "</SELECT></td>";


$orient = "horizontal";

$sql = "SELECT email, employee_id, first_name, last_name, employee_type, phone, department_id FROM employee   ";
if ($department_id) {
        $sql.=" WHERE department_id = '".$department_id."' ";
}

if ($order_field) {
	$order_field = $order_field." , last_name, first_name ";
} else {
$order_field = "last_name, first_name ";
}
$link_reference="mailto:";
echo "<tr><td valign=top>";
include("inc/view_form_inc.php");
echo "</td></tr>";

/*
          <tr>
    <td>
    <input class="gray" type="Submit" name="SUBMIT" value="Submit">&nbsp;
    <input class="gray" type="reset" name="RESET" value="Reset">
	</td></tr>   
*/
?>
 </p>
  </form>

</blockquote>
<?
include "inc/footer_inc.php";
?>
</table>
</body>
</HTML>
