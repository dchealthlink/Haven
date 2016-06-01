<?php
session_start();
include "inc/dbconnect.php";
include("inc/index_header_inc.php");
$_SESSION['where_clause'] = '';
$_SESSION['tablename'] = '';

/*
session_unregister("where_clause");
session_unregister("tablename");

if(!session_is_registered("userid"))
{
header("Location: itlogin.php");
exit;
}
*/
?>
<html>
<tr><td>

  </b></h2><? echo (ucwords($tablename)) ?> Data 
<?

/*
$ret_code = valid_application_level ($db, $tablename, $usertype);
if ($ret_code == 0) {
	DisplayErrMsg(sprintf("Invalid User Type for table %", $tablename));
	echo "<script>";
	echo "history.back()";
	echo "</script>";
}
*/
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

if ($usertype =='admin' or $usertype == 'su') {
	$sql="SELECT c.relname, a.attname, a.attnum, a.attlen, a.atttypmod, a.attnotnull, t.typname ";
	$sql.="FROM pg_class c, pg_attribute a, pg_type t  ";
	$sql.="WHERE c.relname = '".$tablename."' and c.oid = a.attrelid and a.attnum > 0 and ";
	$sql.="a.atttypid = t.oid order by 1, 3";
} else {
	$sql="SELECT c.relname, a.attname, a.attnum, a.attlen, a.atttypmod, a.attnotnull, t.typname ";
	$sql.="FROM pg_class c, pg_attribute a, pg_type t , table_field_access ta ";
	$sql.="WHERE c.relname = '".$tablename."' and c.oid = a.attrelid and a.attnum > 0 and ";
	$sql.="(c.relname = ta.table_name and a.attname = ta.field_name and access_type = 'table_view') and ";
	$sql.="a.atttypid = t.oid order by 1, 3";
}

$result = pg_exec($db,$sql);

if(pg_ErrorMessage($db))
	{
	if ($debug) {
		DisplayErrMsg(sprintf("Error in executing %s statement", $sql)) ;
	}
	DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
	};

$rownum = 0;
$column_list = '';
$color = "#f5f5f5";
echo "<table valign=top>";
echo "<tr align=top bgcolor=#f5f5f5>";
while ($row = pg_fetch_array($result,$rownum)) {
	$uscore = "_";
	$lbreak = " ";

	$column_list.= ' '.$row[pg_fieldname($result,1)].', ';

	echo "<td><b>".(ucwords(ereg_replace($uscore, $lbreak, $row[pg_fieldname($result,1)])))."</b></td>";

	$rownum = $rownum + 1;
}
	$column_list = substr($column_list,0,-2);

echo "</tr>";

/* -------------------------- */


/* -------------------------- */
if (!$offsetval) {
$offsetval=0;
}

if (strlen($where_clause) > 0) {
	$sql="SELECT ".$column_list." from ".$tablename." ".$where_clause." order by 1, 2 limit 24 offset ".$offsetval ;
	$sql1="SELECT count(*) as unique_cnt from ".$tablename." ".$where_clause ;
//	session_unregister("where_clause");
	$_SESSION['where_clause'] = '';
	$where_clause = null;
//	session_register("where_clause");

} else {
	$sql="SELECT ".$column_list." from ".$tablename." ";
	$sql.=" order by 1, 2 limit 24 offset ".$offsetval ;
	$sql1="SELECT count(*) as unique_cnt from ".$tablename ;
} 


if(pg_ErrorMessage($db))
	{
	if ($debug) {
		DisplayErrMsg(sprintf("Error in executing %s statement", $sql)) ;
	}
	DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
	};

pg_freeresult($result);
// session_register("old_where_clause");
$old_where_clause = $where_clause;
/*
session_unregister("where_clause");
session_unregister("tablename");
*/
$result = execSql($db,$sql, $debug);

if (!$returnrows) {
	$result1 = execSql($db,$sql1,$debug);
	$row = pg_fetch_array($result1, 0);
	$returnrows = $row["unique_cnt"];
};

$rownum = 0;
while ($row = pg_fetch_array($result,$rownum))
{
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

for($j=0;$j<$numkeys; $j++) {

	$where_clause.=pg_fieldname($result,$j);

	$where_clause.="=".chr(33).chr(33).str_replace(" ","%20",$row[pg_fieldname($result,$j)]).chr(33).chr(33).chr(64).chr(64); 

};
$where_clause = substr($where_clause,0,strlen($where_clause) - 2);

echo "<td><b><a href='mod_template.php?tablename=".$tablename."&search=1&search_where_clause=".$where_clause."'>$test</a></b></td>";

} else {

 if (pg_fieldname($result,$i) == 'password') {
		echo "<td>**********</td>";
	} else {
		echo "<td>$test</td>";
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

/* this is a mod */
for ($innerloop = 0; $innerloop < count ($res_array); ++$innerloop)
{
/* echo "<td><b>$res_array[$innerloop]</b></td>"; */

if ($typ_array[$innerloop]=="modify") {
	if (($tablename == "template" and ($row[pg_fieldname($result,0)] == "ast" or $row[pg_fieldname($result,0)] == "isdnst" or $row[pg_fieldname($result,0)] == "isdnmt"))) {
	echo "<td>&nbsp</td>";
	} else {
	echo "<td><b><a href='mod_relation.php?tablename=".$tablename."&child_table=".$res_array[$innerloop]."&where_clause=".$where_clause."'>".$res_array[$innerloop]."</a></b></td>";
	}
} else {
	if (($tablename == "template" and ($row[pg_fieldname($result,0)] == "ast" or $row[pg_fieldname($result,0)] == "isdnst" or $row[pg_fieldname($result,0)] == "isdnmt"))) {
	echo "<td><a href='view_supe_templates.php?tablename=".$tablename."&child_table=".$res_array[$innerloop]."&where_clause=".$where_clause."'>".$res_array[$innerloop]."</a></td>";
	} else {
	echo "<td><a href='view_relation.php?tablename=".$tablename."&child_table=".$res_array[$innerloop]."&where_clause=".$where_clause."'>".$res_array[$innerloop]."</a></td>";
	}
}

}

if ($res_array == 0) {
	echo "<td>&nbsp</td>";
}
$where_clause="";
$rownum = $rownum + 1;
echo "</tr>";
}
echo "<input type=hidden name=offsetval value=".$offsetval.">";
echo "<input type=hidden name=tablename value=".$tablename.">";
echo "<input type=hidden name=returnrows value=".$returnrows.">";
/*
echo "</table>";
*/
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

echo "<tr><td colspan=2><a href='mod_template.php?tablename=".$tablename."&search=0'>add ".$tablename." data</a></td></tr>";
	echo "</table>";

include "inc/footer_inc.php";
?>

</body>
</HTML>



