<?
session_start();
include("inc/dbconnect.php");
// session_unregister("query_value");
if ($NEWSEARCH) {
header("Location: notification_menu.php");
exit;
}
if ($ADDPRODUCT) {
header("Location: select_vendor_product.php?vendor_id=".$vendor_id);
exit;
}
if ($ADDCONTACT) {
header("Location: select_vendor_contact.php?vendor_id=".$vendor_id);
exit;
}
if ($ADDLOCATION) {
header("Location: select_vendor_location.php?vendor_id=".$vendor_id);
exit;
}

$show_menu = "ON";
include("inc/header_inc.php");
	
?>
<HTML>

  <blockquote>
   <h1>Search Result</h1>
  <?php

if($submitsave)
{

	$sql1 = "INSERT INTO user_query VALUES ('".$userid."','".$query_name."','".$query_description."','".$query_value."')";

	$result = execSql($db, $sql1,$debug);

		if ($result != 'error') {
			echo "<p>Query : <b>".$query_name."</b> has been saved</p>";
		}
};

  /* <form method="post" action="<?php echo $PHP_SELF?>"> */

echo "<form method=post action=".$PHP_SELF.">"; 

if (!$search_where) {
/* 	$search_where = " (xa_timestamp::date like now()::date) "; */
 	$search_where = "1=1 "; 
}

$sql = "SELECT notice_template, notice_template_location, notice_template_text FROM notice_template WHERE ".$search_where;
if ($notice_template) {
	$sql.=" AND notice_template = '".$notice_template."' ";
}
$sql.=" ORDER BY notice_template limit 1000";

$result = execSql($db, $sql, $debug);

        $numrows = pg_numrows($result);
echo ("<tr><td>Notice Template Information</td></tr>");
if ($numrows > 0) {
        $numfields = pg_numfields($result);
} else {
        echo ("<tr><td><b>No Rows Returned - possible error</b></td></tr>");
}
echo ("</td></tr>");
echo "<tr><td valign=top>";
echo "<table border=1>";
if ($result) {
        echo("\n<TR BGCOLOR=\"f5f5f5\">");
        for ($i=0;$i<$numfields;$i++) {
        $fldname = pg_fieldname($result,$i);
        $fldname = ereg_replace("_"," ",$fldname);
        echo ("<Td><b>".(ucwords($fldname))."</b></Td>");
}

echo ("</TR>");
$color = "f5f5f5";

for ($i=0;$i<$numrows;$i++) {

        if (($i % 2) == 0) {
                echo ("\n<TR>");
        } else {
                echo ("\n<TR BGCOLOR=$color>");
        }
        $rowarr = pg_fetch_row($result,$i);
        for ($j=0;$j<$numfields;$j++) {
		$ftype = pg_field_type($result,$j);
                $val = $rowarr[$j];
		
                if ($val == "") {
                        $val = "&nbsp;";
                }

                if (pg_fieldname($result,$j) == 'password')  {
                        echo "<td>**********</td>";
                } else {
			if (pg_fieldname($result,$j) == 'status') {
				$temp_status = $val;
			}
			if ($j == 0) {
				if ($numrows > 1) {
					echo "<td><a href=search_notice_template_result.php?notice_template=".$val.">".$val."</a></td>"; 
				} else {
					echo "<td>".$val."</td>"; 
				}
				$temp_notice_template = $val;
			} else {
				if ($ftype == 'numeric') {
                        		echo "<td align=right>$val</td>";
				} else {
                        		echo "<td>".$val."</td>";
				}
			}
                }

        }
echo ("</TR>");
}
echo ("</table>");
}


if ($numrows==1) {

$notice_template = $rowarr[0];

$sql="SELECT template_fieldname as fieldname, fieldname_type as type, fieldname_length as length, fieldname_mandatory as mandatory, sort_order  FROM notice_template_field WHERE notice_template = '".$notice_template."' ORDER BY sort_order";
$result = execSql($db, $sql, $debug);

echo ("<tr><td>&nbsp;</td></tr>");
echo ("<tr><td>Notification Template Field Information</td></tr>");

if ($result) {
        $numrows = pg_numrows($result);
        $numfields = pg_numfields($result);
} else {
        echo ("<tr><td><b>No Rows Returned - possible error</b></td></tr>");
}
 echo "<tr><td valign=top>";
echo "<table border=1>";
if ($result) {
        echo("\n<TR BGCOLOR=\"f5f5f5\">");
        for ($i=0;$i<$numfields;$i++) {
        $fldname = pg_fieldname($result,$i);
        $fldname = ereg_replace("_"," ",$fldname);
        echo ("<Td><b>".(ucwords($fldname))."</b></Td>");
}
        echo ("<Td><b>Action</b></Td>");

echo ("</TR>");
$color = "f5f5f5";


if ($numrows > 0) {
for ($i=0;$i<$numrows;$i++) {

        if (($i % 2) == 0) {
                echo ("\n<TR>");
        } else {
                echo ("\n<TR BGCOLOR=$color>");
        }
        $rowarr = pg_fetch_row($result,$i);
        for ($j=0;$j<$numfields;$j++) {
		$ftype = pg_field_type($result,$j);
                $val = $rowarr[$j];
                if ($val == "" or $val == "  ") {
                        $val = "&nbsp;";
                }

                if (pg_fieldname($result,$j) == 'password')  {
                        echo "<td>**********</td>";
                } else {
				if ($ftype == 'numeric') {
                        		echo "<td align=right>$val</td>";
				} else {
                        		echo "<td>".$val."</td>";
				}
                }

        }

	echo "<td><a href=insert_notice_template_field.php?notice_template=".$notice_template."&template_fieldname=".$rowarr[0].">Update</a></td>"; 

echo ("</TR>");
}
} else {

        echo ("<tr><td colspan=10 align=center><b>No Rows Returned</b></td></tr>");

}


echo ("</table>");
}

}

echo "</td></tr>";
echo "<tr><td>&nbsp;</td></tr>";
echo "<tr><td>";

echo "<input class=gray type=Submit name=NEWSEARCH value='New Search'>&nbsp";
echo "<input type=hidden name=notice_template value=".$notice_template.">";

if ($vendor_id) {
        echo "<tr><td>";
        echo "<input class=gray type=Submit name=ADDPRODUCT value='Add Products'>&nbsp";
        echo "<input class=gray type=Submit name=ADDCONTACT value='Add Contacts'>&nbsp";
        echo "<input class=gray type=Submit name=ADDLOCATION value='Add Locations'>&nbsp";
        echo "</td></tr>";
}

?>

</td></tr>
    </p>
  </form>

</blockquote>
<?php

include "inc/footer_inc.php";
?>
</body>
</table>
</HTML>
