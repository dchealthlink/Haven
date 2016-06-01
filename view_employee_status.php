<?php
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

if ($MENU) {
 header("Location: employee_menu.php");
}

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
  var myindex1=form.inout.selectedIndex;
  secd=form.inout.options[myindex1].value;
  location="view_employee_status.php?department_id="+prim+"&inout="+secd;
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

$dpt_sql = "SELECT department_id, department_name FROM department ";
                        switch ($usertype) {
                        case "user":
                        case "supervisor":
                                $df_sql = "SELECT department_id FROM employee WHERE employee_id = '".$key_value."'";
                                $df_result = execSql($db, $df_sql, $debug);
                                list ($search_department_id) = pg_fetch_row ($df_result,0);
                                $dpt_sql.="WHERE department_id = '".$search_department_id."'";
                                break;
                        case "admin":
                                $dpt_sql.=" WHERE department_id IN (SELECT department_id FROM department_admin WHERE employee_id = '".$key_value."') ";
                                break;
                        case "su":
                                break;       
                 }

 $dpt_sql.=" ORDER BY 2";

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

echo "</SELECT>";

$io_sql = "SELECT item_cd, item_description FROM app_lookup WHERE lookup_table = 'general' AND lookup_field = 'inout' ORDER BY sort_order";

$io_result = execSql($db, $io_sql, $debug);

echo "&nbsp;&nbsp;Employee Log Status:&nbsp;";
echo "<SELECT NAME=inout onChange=submitform(this.form)>";
echo"<option selected value=\"\">";

$rownum = 0;
        while ($row = pg_fetch_array($io_result,$rownum))
        {
                list($t_item_cd, $t_item_desc) = pg_fetch_row($io_result,$rownum);
                if ($inout == $t_item_cd) {
                        echo "<option SELECTED value=".$t_item_cd.">".$t_item_desc;
                } else {
                        echo "<option value=".$t_item_cd.">".$t_item_desc;
                }
        $rownum = $rownum + 1;
        }

echo "</SELECT></td>";




echo "<tr><td><table>";

if ($usertype != 'admin') {
	$dsql = "SELECT department_id FROM employee WHERE employee_id = '".$key_value."'";
	$d_result = execSql($db, $d_sql, $debug);

	list ($department_id) = pg_fetch_row($d_result,0);

}


	switch($inout) {

		case 'in':
			$sql = "SELECT e.employee_id, e.first_name, e.last_name, e.employee_type, e.phone, e.department_id, eol.log_state , eol.log_time , substr(eol.log_time,1,6)::date as log_date, substr(eol.log_time,7,6)::time as log_time, eol.log_error , eol.log_closed FROM employee e, employee_open_log eol WHERE e.employee_id = eol.employee_id AND log_error != 'Y'   ";

			if ($department_id) {
        			$sql.=" AND department_id = '".$department_id."' ";
			}
			switch ($usertype) {
        		case "user":
        		case "supervisor":
                		$df_sql = "SELECT department_id FROM employee WHERE employee_id = '".$key_value."'";
                		$df_result = execSql($db, $df_sql, $debug);
                		list ($search_department_id) = pg_fetch_row ($df_result,0);
                		$sql.=" AND e.department_id = '".$search_department_id."'";
                		break;
        		case "admin":
                		$sql.=" AND e.department_id IN (SELECT department_id FROM department_admin WHERE employee_id = '".$key_value."') ";
                		break;
        		case "su":
                		break;
        		}

		break;
		case 'out':
			$sql = "SELECT employee_id, first_name, last_name, employee_type, phone, department_id FROM employee    ";

			$sql.=" WHERE employee_id NOT IN (select distinct employee_id FROM employee_open_log) ";
			if ($department_id) {
        			$sql.=" AND department_id = '".$department_id."' ";
			}
			switch ($usertype) {
        		case "user":
        		case "supervisor":
                		$df_sql = "SELECT department_id FROM employee WHERE employee_id = '".$key_value."'";
                		$df_result = execSql($db, $df_sql, $debug);
                		list ($search_department_id) = pg_fetch_row ($df_result,0);
                		$sql.=" AND department_id = '".$search_department_id."'";
                		break;
        		case "admin":
                		$sql.=" AND department_id IN (SELECT department_id FROM department_admin WHERE employee_id = '".$key_value."') ";
                		break;
        		case "su":
                		break;
        		}

		break;
		case 'error':
			$sql = "SELECT e.employee_id, e.first_name, e.last_name, e.employee_type, e.phone, e.department_id, eol.log_state , eol.log_time , substr(eol.log_time,1,6)::date as log_date, substr(eol.log_time,7,6)::time as log_time, eol.log_error , eol.log_closed FROM employee e, employee_open_log eol WHERE e.employee_id = eol.employee_id AND log_error = 'Y'   ";

			if ($department_id) {
        			$sql.=" AND e.department_id = '".$department_id."' ";
			}
			switch ($usertype) {
        		case "user":
        		case "supervisor":
                		$df_sql = "SELECT department_id FROM employee WHERE employee_id = '".$key_value."'";
                		$df_result = execSql($db, $df_sql, $debug);
                		list ($search_department_id) = pg_fetch_row ($df_result,0);
                		$sql.=" AND e.department_id = '".$search_department_id."'";
                		break;
        		case "admin":
                		$sql.=" AND e.department_id IN (SELECT department_id FROM department_admin WHERE employee_id = '".$key_value."') ";
                		break;
        		case "su":
                		break;
        		}

		break;
		default:
			$sql = "SELECT e.employee_id, e.first_name, e.last_name, e.employee_type, e.phone, e.department_id, eol.log_state , eol.log_time , eol.log_error , eol.log_closed FROM employee e   ";

			$sql.=" LEFT OUTER JOIN employee_open_log eol on (e.employee_id = eol.employee_id AND log_error != 'Y') ";
			$sql.=" WHERE e.status != 'I' ";
			if ($department_id) {
        			$sql.=" AND e.department_id = '".$department_id."' ";
			}
			switch ($usertype) {
        		case "user":
        		case "supervisor":
                		$df_sql = "SELECT department_id FROM employee WHERE employee_id = '".$key_value."'";
                		$df_result = execSql($db, $df_sql, $debug);
                		list ($search_department_id) = pg_fetch_row ($df_result,0);
                		$sql.=" AND e.department_id = '".$search_department_id."'";
                		break;
        		case "admin":
                		$sql.=" AND e.department_id IN (SELECT department_id FROM department_admin WHERE employee_id = '".$key_value."') ";
                		break;
        		case "su":
                		break;
        		}

		break;
}

if ($order_field) {
	$order_field = $order_field." , last_name, first_name ";
} else {
$order_field = "last_name, first_name ";
}

$orient = 'horizontal';
echo "<tr><td valign=top>";
include("inc/view_form_inc.php");
echo "</td></tr>";

echo "</table>";

/*
          <tr>
    <td>
    <input class="gray" type="Submit" name="SUBMIT" value="Submit">&nbsp;
    <input class="gray" type="reset" name="RESET" value="Reset">
	</td></tr>   
*/
?>
          <tr><td>
    <input class="gray" type="Submit" name="MENU" value="Menu">&nbsp;
    <input type="hidden" name="order_field" value="<?php echo $order_field ?>">
        </td></tr>

 </p>
  </form>

</blockquote>
<?
include "inc/footer_inc.php";
?>
</table>
</body>
</HTML>
