<?php
session_start();
include("inc/dbconnect.php");

// session_unregister("query_value");
if ($NEWSEARCH) {
	header("Location: gen_report.php");
	exit;
}

$show_menu = "ON";
include("inc/index_header_inc.php");
	
/* <HTML> */
?>
<script language="javascript">
<!--
function submitform(form){
  var myindex=form.search_dept_id.selectedIndex;
  prim=form.search_dept_id.options[myindex].value;
  did=form.department_id.value;
  location="view_whos_in.php?department_id="+did+"&search_dept_id="+prim;
  }

//-->
</script>
</head>

  <blockquote>
   <h1>Password Resets</h1>

  <?php




echo "<form method=post action=".$PHP_SELF.">"; 

$sql = "SELECT notification_id, notice_field, notice_field_value FROM notice_data where notification_id in (select notification_id from notification where notice_cd = 'password_request' and post_timestamp::date > now()::date - 14) and notice_field in ('user_name','post_timestamp','new_pw') "; 

$order_field = "notification_id, notice_field desc ";
echo ("<tr><td>Password Reset Information</td></tr>");
$acc_method = "view";

$link_reference="";
$orient= "horizontal";
echo "<tr><td valign=top>";
include("inc/view_form_inc.php");
echo "</td></tr>";
/* echo "</td>"; */



?>

</td></tr>
<tr><td>&nbsp;</td></tr>


    </p>
  </form>

</blockquote>
<?

include "inc/footer_inc.php";
?>
</body>
</table>
</HTML>
