<?php 
session_start();
include "inc/dbconnect.php";
include("inc/header_inc.php");

?>
<html>
<tr><td></b></h2>Outcome Data 
<?

if ($previous24) {

	$where_clause = $old_where_clause;
	if ($offsetval > 24) {
		$offsetval = $offsetval - 24;
	} else {
		$offsetval = 0;
	};
};


if ($first) {
	$where_clause = $old_where_clause;
	$offsetval = 0;
};

if ($next24) {

	$where_clause = $old_where_clause;
	$offsetval = $offsetval + 24;
};

if ($last) {
	$where_clause = $old_where_clause;
	$offsetval = $returnrows - 24;
};

?>
<form method="post" action="<?php echo $PHP_SELF?>">
<?

$sql="SELECT * FROM application_result "; 

$sql.=" ORDER BY 1";

$result = execSql($db,$sql,$debug);

$rownum = 0;
$numfields = pg_numfields($result);
$color = "#f5f5f5";
echo "<table valign=top>";
echo "<tr align=top bgcolor=#f5f5f5>";
for ($i=0;$i<$numfields;$i++) {

echo "<td><b>".(ucwords(ereg_replace("_", " ", pg_fieldname($result,$i))))."</b></td>";

}
echo "</tr>";

if (!$offsetval) {
$offsetval=0;
}


while ($row = pg_fetch_array($result,$rownum)) {
$fieldnum = pg_numfields($result);

$where_clause = "";
echo "<tr valign=top bgcolor=$color>";
for($i=0;$i<$fieldnum; $i++)
{

$test = $row[pg_fieldname($result,$i)];

if (!($numkeys = retrieve_keys($db,$tablename))) {
	$numkeys = 1;
}


if ($i == 0) {
	echo "<td><b><a href='search_application_output.php?appl_id=".$test."'>$test</a></b></td>";

} else {

 if (pg_fieldname($result,$i) == 'password') {
		echo "<td>**********</td>";
	} else {
		if (pg_fieldtype($result,$i) == 'numeric') {
			echo "<td align=right nowrap>$test</td>";
			$totval= $totval + $test;
			$totcount = $totcount + 1;
		} else {
			echo "<td nowrap>$test</td>";
		}
	}

};

};
	
if ($alternate == "1") {
	$color = "#f5f5f5";
	$alternate = "0";
	}
	else {
	$color = "#ffffff";
	$alternate = "1";
	}

$where_clause="";
$rownum = $rownum + 1;
echo "</tr>";
}
/* echo "<tr><td>Totals</td><td align=right>Records Returned:</td><td align=right>".$totcount."</td><td colspan=7 align=right>".$totval."</td></tr>"; */
echo "<input type=hidden name=offsetval value=".$offsetval.">";
echo "<input type=hidden name=tablename value=".$tablename.">";
echo "<input type=hidden name=returnrows value=".$returnrows.">";

if ($returnrows > 24) {

/*
	echo ("<table border=0 cellspacing=0 cellpadding=2 bordercolor=#eeeeee width=200>");
*/
  	echo ("<tr><td colspan=4><input class='gray' type='Submit' name='first' value='First'> ");
  	echo ("<input class='gray' type='Submit' name='previous24' value='Previous'> ");
  	echo ("<input class='gray' type='Submit' name='next24' value='Next'> ");
  	echo ("<input class='gray' type='Submit' name='last' value='Last'></td>");
	echo ("</tr>");
}

	echo "</table>";

include "inc/footer_inc.php";
?>

</body>
</HTML>



