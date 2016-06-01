<?php
include("inc/dbconnect.php");

echo "<table border=1>";
for ($i=0;$i<2500;$i++) {

$first = md5(rand());
$second = base64_encode($first);
$third = "AE" .substr($second, 0, 5);
/* $newpw = "AE" .substr(base64_encode(md5(rand())), 0, 5); */


$sql = "SELECT coalesce(count(new_pw),0) FROM pw_table WHERE new_pw = '".$third."'";

$result = execSql($db,$sql,$debug);

list($numrows) = pg_fetch_row($result,0);
 
if ($numrows > 0 ) {
	$sql = "INSERT INTO dupe_pw VALUES ('".$third."')";
echo "<tr><td>".$first."</td>";
echo "<td>".$second."</td>";
echo "<td>".$third."</td>";
echo "<td>".$numrows."</td>";
echo "</tr>";
} else {
	$sql = "INSERT INTO pw_table VALUES ('".$third."')";
}	

$result = execSql($db,$sql,$debug);


/* echo "pw is ".$newpw."<br>"; */
}
echo "</table>";
?>

