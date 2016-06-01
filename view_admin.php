<?
session_start();
include("inc/dbconnect.php");
$show_menu = "ON";

include("inc/index_header_inc.php");

?>
<html>

  Available <?php echo ucfirst($usertype) ?> Options:


  <blockquote>

  <?php


$sql="SELECT * from app_lookup where lookup_table = 'admin_menu' ";

switch ($usertype) {
	case "chd2":
	case "basic":
	case "intermediate":
	case "advanced":
		$sql.= " AND (lookup_field = '".$usertype."' ) order by sort_order";
	break;
	case "su":
	case "admin":
		$sql.= " AND lookup_field in ('admin','ALL') order by sort_order";
		break;
	case "vendor":
		$sql.= " order by sort_order";
		break;
	default:
		$sql.= " AND (lookup_field = '".$usertype."' OR lookup_field = 'ALL') order by sort_order";
	}

$result = execSql($db,$sql,$debug);

echo "<table border=0 cellspacing=0 cellpadding=2 bordercolor=#eeeeee width=600>";
$rownum = 0;
while ($row = pg_fetch_array($result,$rownum))
{
$test=$row[pg_fieldname($result,0)];

echo "<tr><td align=center><b><a href='".$row[pg_fieldname($result,4)]."'>".$row[pg_fieldname($result,2)]."</a></b></td><td>".$row[pg_fieldname($result,3)]."</td></tr>";

$rownum = $rownum + 1;
}
if ($usertype == 'admin' or $usertype == 'vendor' or $usertype == 'su') {
 echo "<tr><td align=center><a href=gen_notification.php><b>Notification</b></a></td><td>Simulate Cron for Notification</td></tr>";
 echo "<tr><td align=center><a href=change_password.php><b>Change Password</b></a></td><td>Change User Password</td></tr>"; 
?>
    <tr><td align=center><b><a href="#" onClick="javascript:window.open('test_download.php', 'tinyWindow', 'toolbar,scrollbars')" >Download File</a></b></td><td>Select File and Download</td></tr>
<?
}
?>
    <tr><td align=center><b>---------------</a></b></td><td align=left>------------------------------</td></tr>

    <tr><td align=center><b>Other <?php echo ucfirst($usertype) ?> Options</b><td>TBD</b></td>
    </table>


    <br>
    </p>
  </form>
</blockquote>
<?

include "inc/footer_inc.php";
?>
</body>
</head>
</HTML>
