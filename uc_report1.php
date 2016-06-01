<?php
session_start();
include "inc/dbconnect.php";
include("inc/index_header_inc.php");

?>
<html>
<tr><td></b><h2>Use Case Report</h2> 
<?

$data=array(
        array("id"=>1,"name"=>"mic-0001",        "parent"=>0),
        array("id"=>3,"name"=>"mic-0117",        "parent"=>1),
        array("id"=>4,"name"=>"mic-0122",             "parent"=>3),
        array("id"=>5,"name"=>"mic-0114",       "parent"=>3),
        array("id"=>2,"name"=>"mic-0102",        "parent"=>0),
        array("id"=>12,"name"=>"mic-0002",        "parent"=>0),
        array("id"=>13,"name"=>"mic-0017",        "parent"=>12),
        array("id"=>14,"name"=>"mic-0022",             "parent"=>13),
        array("id"=>15,"name"=>"mic-0014",       "parent"=>13),
        array("id"=>16,"name"=>"mic-0013",          "parent"=>0),
        array("id"=>17,"name"=>"mic-0018","parent"=>16)
    );

function tree($data, $mom = 0, $level = 0){
     foreach ($data as $row){
          if ($row['parent'] == $mom) {
               echo str_repeat("-", $level).$row['name']."<br>";
               tree($data, $row['id'], $level);
          } else { 
		$level = $level + 1;
	}
     }
}
function newtree($ucid,$db, $lvl, $cvl) {
	$xsql = "select a.action_value, a.usecaseid , u.usecasename, u.goalincontext, u.priority, u.uc_tier, u.usecaseversion, (select count(*) from use_case_action where usecaseid = a.action_value and action_type = 'subordinate') as tree from use_case_action a, use_case u where a.action_value= u.usecaseid and a.action_type = 'subordinate' and a.usecaseid = '".$ucid."' order by 1";
	$xresult = execSql($db, $xsql, $debug) ;
	$xrownum = 0;
//     				echo "<td><a href=uc_form.php?ucId=".$test.">".$test."</a></td>"; 
	while ($row = pg_fetch_array($xresult,$xrownum)) {
		list ($f1, $f2, $f3, $f4, $f5, $f6, $f7, $f8) = pg_fetch_row($xresult, $xrownum) ;
		if ($f8 > 0) {
			echo "<tr><td>".$lvl.".".$cvl."</td><td align=left><img src='/images/downarrow.png' width='20' height='20'></td><td><a href=uc_form.php?ucId=".$f1.">".$f1."</td><td>".$f7."</td><td>".$f3."</td><td>".$f4."</td><td>".$f5."</td><td>".$f6."</td></tr>";
			$lvl= $lvl + 1;
			$cvl= $cvl + 1;
		} else {
			if ($f1 == 'mic-0038') {
			$cvl = 1;
				echo "<tr><td>".$lvl.".".$cvl."</td><td align=right><img src='/images/rtangle2.png' width='20' height='20'></td><td><a href=uc_form.php?ucId=".$f1.">".$f1."</td><td>".$f7."</td><td>".$f3."</td><td>".$f4."</td><td>".$f5."</td><td>".$f6."</td></tr>";
			} else {
				echo "<tr><td>".$lvl.".".$cvl."</td><td align=left><img src='/images/rtangle.png' width='20' height='20'></td><td><a href=uc_form.php?ucId=".$f1.">".$f1."</td><td>".$f7."</td><td>".$f3."</td><td>".$f4."</td><td>".$f5."</td><td>".$f6."</td></tr>";
			}
		}
		newtree ($f1, $db, $lvl, $cvl) ;
		$xrownum = $xrownum + 1;
	}



}

//tree($data);
// newtree('mic-0002',$db);
echo "<br><br>";

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
if (!$search_where) {
	$search_where = " WHERE 1 = 1 ";
}
if (!$_GET['sord']) {
        $sord = 2;
} else {
        $sord = $_GET['sord'];
}



$sql="select (select count(*) from use_case_action where usecaseid = a.usecaseid and action_type = 'subordinate') as tree, a.usecaseid, a.usecaseversion as vers, a.usecasename, a.goalincontext, a.priority, a.uc_tier as tier, a.projectid as project from use_case a ";
$sql.= " WHERE a.projectid in (select projectid from project_user WHERE employee_id = '".$_SESSION['userid']."')";


$sql.=" ORDER BY ".$sord.",2,3 ";

$result = execSql($db,$sql,$debug);

$rownum = 0;
$numfields = pg_numfields($result);
$color = "#f5f5f5";
echo "<table valign=top width=75%>";
echo "<tr align=top bgcolor=#f5f5f5>";
echo "<td>ALL</td>";
for ($i=0;$i<$numfields;$i++) {

echo "<td><b><a href=uc_report1.php?sord=".($i + 1).">".(ucwords(ereg_replace("_", " ", pg_fieldname($result,$i))))."</a></b></td>";

}
echo "</tr>";

if (!$offsetval) {
$offsetval=0;
}


while ($row = pg_fetch_array($result,$rownum)) {
	$fieldnum = pg_numfields($result);

	$where_clause = "";
	echo "<tr valign=top bgcolor=$color>";
	for($i=0;$i<$fieldnum; $i++) {

		$test = $row[pg_fieldname($result,$i)];

		if (!($numkeys = retrieve_keys($db,$tablename))) {
			$numkeys = 1;
		}
		if ($button == $row[pg_fieldname($result,1)]) {
			$whichbutton = "downarrow.png";
		} else {
			$whichbutton = "rightarrow.png";
		}

		switch ($i) {
			case 0:
				if ($row[pg_fieldname($result,0)] > 0){
					echo '<td nowrap><input type="button" name="buttonall" value="ALL"></button>';
					echo '<td><button name="button" value="'.$row[pg_fieldname($result,1)].'" stype="border:none;"><img src="/images/'.$whichbutton.'" width="15" height="15"  alt="action 1" /></button></td>';
				} else {
     					echo "<td colspan=2>&nbsp;</b></td>";
				} 
			break;
			case 1:
     				$comvalue = "in=1&mid=".$test."&uid=".$row[pg_fieldname($result,2)];
     				$encrypted_text = encryptHref(session_id(),$comvalue);

     				echo "<td><a href=uc_form.php?ucId=".$test.">".$test."</a></td>"; 

			break;
			default :
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
	} else {
		$color = "#ffffff";
		$alternate = "1";
	}

	$where_clause="";
	$rownum = $rownum + 1;

	if ($button == $row[pg_fieldname($result,1)]) {
newtree($row[pg_fieldname($result,1)],$db);
	}
/*
$irownum = 0;
	if ($button == $row[pg_fieldname($result,1)]) {
		$innersql="select (select count(*) from use_case_action where usecaseid = a.usecaseid and action_type = 'subordinate') as tree, a.usecaseid, a.usecaseversion as vers, a.usecasename, a.goalincontext, a.priority, a.uc_tier as tier, a.projectid as project from use_case a ";
		$innersql.= " WHERE a.usecaseid in (select action_value from use_case_action where action_type = 'subordinate' and usecaseid = '".$button."') AND a.projectid in (select projectid from project_user WHERE employee_id = '".$_SESSION['userid']."')";
		$innerresult = execSql($db, $innersql, $debug);

		while ($row = pg_fetch_array($innerresult,$irownum)) {
		$ifieldnum = pg_numfields($innerresult);

		$where_clause = "";
		echo "<tr valign=top bgcolor=$color>";
		for($j=0;$j<$ifieldnum; $j++)
		{

			$test = $row[pg_fieldname($innerresult,$j)];
			switch ($j) {
			case 0:
				if ($row[pg_fieldname($innerresult,0)] > 0){
					echo '<td>&nbsp;</td><td><button name="button" value="'.$row[pg_fieldname($result,1)].'" stype="border:none;"><img src="/images/rightarrow.png" width="15" height="15"  alt="action 1" /></button></td>';
				} else {
					echo '<td>&nbsp;</td><td align=right><img src="/images/rtangle.png" width="20" height="20"></td>';
				} 
			break;
			default :
				if (pg_fieldtype($innerresult,$j) == 'numeric') {
					echo "<td align=right nowrap>$test</td>";
					$totval= $totval + $test;
					$totcount = $totcount + 1;
				} else {
				echo "<td nowrap>$test</td>";
			}

		$irownum = $irownum + 1;

};
};
					echo '<tr><td colspan=9>&nbsp;</td></tr>';
};


}
*/


echo "</tr>";
}
echo "<tr><td colspan=2 align=left>Records Returned:</td><td align=right>".$rownum."</td><td colspan=7 align=right>&nbsp;</td></tr>";
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



