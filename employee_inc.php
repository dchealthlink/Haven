<?php
if ($employee_id) {

        $pgsql = "SELECT e.employee_id, e.first_name, e.last_name, e.department_id,  e.email, e.employee_type, e.status  from employee e WHERE employee_id = '".$employee_id."' ";

        $pgresult = execSql($db, $pgsql, $debug);

        $row = pg_fetch_array($pgresult, 0);

        $fieldnum = pg_numfields($pgresult);

        for($i=0;$i<$fieldnum; $i++) {
                $dummy=pg_fieldname($pgresult,$i);
                $$dummy=$row[pg_fieldname($pgresult,$i)];
        }

}


echo "<table border=0 width=550>";
if ($boxlocation) {
	echo "<tr><td colspan=3 align=center>".$boxlocation."</td></tr>";
}
if ($boxlabel) {
	echo "<tr><td colspan=3 align=center>".$boxlabel."</td></tr>";
}
echo "</table>";
echo "<table border=1 width=550>";

        echo "<tr>";
	echo "<td align=left>";
	echo "Employee ID:&nbsp;";
	echo "<b>".$employee_id."</b>";
	echo "</td>";

	echo "<td align=left>";
	echo "First Name:&nbsp;";
	echo "<b>".$first_name."</b>";
	echo "</td>";

	echo "<td align=left>";
	echo "Last Name:&nbsp;";
	echo "<b>".$last_name."</b>";
	echo "</td>";

        echo "<tr>";

	echo "<td colspan=2 align=left>";

	echo "Department:&nbsp;";
        echo "<b>".$department_id."</b>";
	if ($department_name) {
		echo " - <b>".$department_name."</b>";
	}
	echo "</b></td>";
        echo "<td align=left>";
        echo "Emp Type:&nbsp;";
        echo "<b>".$employee_type."</b>";
        echo "</td></tr>";

        echo "<tr>";

	echo "<td colspan=2 align=left>"; 
	echo "Email:&nbsp;";
	echo "<b>".$email."</b>";
	echo "</td>";

        echo "<td align=left>";
        echo "Status:&nbsp;";
        echo "<b>".$status."</b>";
        echo "</td>";


echo "</tr></table>";
?>
