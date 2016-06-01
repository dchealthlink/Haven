<?
include("inc/dbconnect.php");

$sql = "DELETE FROM department_admin WHERE department_id = '".$department_id."' and employee_id = '".$employee_id."'";

$result = execSql($db,$sql,$debug);

header( "Location: select_department_admin.php?search_emp_id=".$employee_id);
?>
