<?php
session_start();
if (session_is_registered("key_attribute")) {
	$$key_attribute = $key_value;
}

include "inc/dbconnect.php";
include("inc/index_header_inc.php");
/*
if(!session_is_registered("userid"))
{
header("Location: index.htm");
exit;
}
*/

?>
<html>
<tr><td valign="top">
  Unallocated Issues:

<?


if ($debug == 1) {
	DisplayErrMsg(sprintf("db %s debug: %s  -- notify: %s    user_type: %s",$db, $debug, $notify, $usertype)) ;
}
/* =========================== */
	$sql="SELECT issue_id, issue_timestamp, issue_topic, issue_subject, issue_text, status from issue where issue_topic in (select issue_topic from issue_topic where respondent_cd in (select respondent_cd from emp_resp where employee_id ='".$key_value."')) and status in ('Q','N') ";

$rownum = 0;

echo "<table border=0 cellspacing=0 cellpadding=2 bordercolor=#eeeeee width=95%>";
echo "<tr align=top>";
?>
<FORM NAME="mainform" METHOD="post" ACTION="<?php $PHP_SELF ?>">
<?


$header_table = "customer";
if ($cust_id) {
$sql_where_clause = " WHERE cust_id = ".$cust_id;
$sql.=$sql_where_clause;
}
if ($cust_company) {
	$sql_where_clause = " WHERE cust_company = '".$cust_company."'";

	if ($cust_id) {

	$sql_where_clause = " and cust_id = ".$cust_id;
	}
$sql.=$sql_where_clause;
}
$link_reference = "view_select_queue.php?issue_id=";
include "inc/view_form_inc.php";


/*
<!-- this is the beginning of the commented section -->
        echo "<tr>";
for ($i = 0; $i < $fieldnum; $i++) {
        
                $header_value = pg_fieldname($result,$i);

                echo "<td>".ucfirst(ereg_replace("cust_","",$header_value))."</td>";

        }
                echo "<td colspan=2 align=center>Action</td>";
        echo "</tr><tr>";



$rownum = 0;
while ($row = pg_fetch_array($result,$rownum))
{

for ($i = 0; $i < $fieldnum; $i++) {
$field_val=$row[pg_fieldname($result,$i)];

if ($i == 0) {
	$cust_id = $field_val;
}
echo "<td>".$field_val."</td>";

}
echo "<td><b><a href='edit_customer_pay.php?cust_id=".$cust_id."'>Pay Info</a></b></td>";
echo "<td><b><a href='edit_customer_pay_log.php?cust_id=".$cust_id."&pay_log=3'>Make Payment</a></b></td>";
echo "</tr>";
$rownum = $rownum + 1;
}
<!-- this is the end of the commented segment -->
*/
echo "<tr><td>&nbsp</td></tr>";
echo "</table>"; 
echo "</td></tr><tr><td>"; 

include "inc/footer_inc.php";


?>
</form>
</body>
</HTML>

