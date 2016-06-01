<?php
session_start();
include("inc/dbconnect.php");
$debug = 1;
$sql="";
$show_menu="OFF";

include("inc/index_header_inc.php");
?>
<HTML>

  <blockquote>
   <h1>Parameter List</h1></td></tr>
  <?php


$header_table = "menu_report_parameter";
$acc_method = "view";
$sql = "SELECT report_name, screen_field, report_parameter_value as reporting_field FROM report_menu_parameter ";

if ($report_name) {

        $sql.= " WHERE report_name = '".$report_name."'";
?>
<script>
window.opener.document.mainform.from_date.className='pink'
window.opener.document.mainform.to_date.className='pink'
</script>
<?php

}

$firstresult = execSql($db,$sql,$debug) ;

$prerownum = 0;

while ($row = pg_fetch_array($firstresult,$prerownum)) {
        list($f1, $f2, $f3) = pg_fetch_row($firstresult, $prerownum) ;
        switch ($f2) {

        case 'report_date':
/*	echo "line ".$f1." - ".$f2." - ".$f3."<br>"; */
?>
<script>
window.opener.document.mainform.from_date.className='ltyellow'
window.opener.document.mainform.to_date.className='ltyellow'
</script>
<?php
        break;
        case 'amount':
?>
<script>
window.opener.document.mainform.gt_amt.className='ltyellow'
window.opener.document.mainform.lt_amt.className='ltyellow'
</script>
<?php
        break;
        case 'payment_type':
?>
<script>
window.opener.document.mainform.pay_method.className='ltyellow'
</script>
<?php
        break;
        case 'course_id':
?>
<script>
window.opener.document.mainform.course_id.className='ltyellow'
</script>
<?php
        break;
        case 'module_id':
?>
<script>
window.opener.document.mainform.module_id.className='ltyellow'
</script>
<?php
        break;
        case 'employee_id':
?>
<script>
window.opener.document.mainform.employee_id.className='ltyellow'
</script>
<?php
        break;
        default:
?>
<script>
window.opener.document.mainform.<?php echo $f2 ?>.className='ltyellow'
</script>
<?php
        }
$prerownum = $prerownum + 1;
}

$num_rows = count_table_field_access ($db, $header_table ,$where_clause);
echo "<FORM NAME=mainform METHOD=post ACTION=".$PHP_SELF.">";

$orient = "horizontal";

echo "<tr><td valign=top>";
include("inc/view_form_inc.php");
echo "</td></tr>";

echo "<tr><td>&nbsp;</td></tr>";
echo "<tr><td><input class=gray type=Button name=CLOSEWINDOW value='Close Window' onClick=\"window.close()\"></td></tr>";



?>
 </p>
  </form>

</blockquote>

</table>
</body>
</HTML>

