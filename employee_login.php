<?php
include ("inc/dbconnect.php");
?>
<html>
<head>
<title>Time and Attendance (<?php echo $city_desc ?>) System - log in</title>
<link rel="stylesheet" href="inc/style.css" type="text/css">
</head>
<?php
$show_menu="OFF";
include ("inc/header_inc.php");
$show_menu="ON";

?>
<body bgcolor="#FFFFFF" text="#000000">

<blockquote>

<?
if ($message_data) {

echo "<h1>".$message_data."</h1></td></tr>";
}
?>
<tr><td valign=top>
<table width=50%>
  <form action="swipe_clocklog.php" method="post" name=login>
    <tr>
      <td width=45% align=center>
<a href="swipe_clocklog.php?emplogin=LOGIN"><img src="images/clock.gif" width="181" height="181" border="0" alt="Click to Login"></a>
</td><td width=10%>&nbsp;</td><td width=45% align=center>
<a href="swipe_clocklog.php?emplogout=LOGOUT"><img src="images/ready_leave.gif" width="181" height="181" border="0" alt="Click to Logout"></a>
</td></tr><tr><td align=center>
        <input class="gray" type="Submit" name="emplogin" value="Log In"></td>
	<td>&nbsp;</td>
	<td align=center>
        <input class="gray" type="Submit" name="emplogout" value="Log Out">
      </td>
	</tr>
<?

if ($msg=="invalid") {
 echo "<td><b>Case Sensitive</b></td>";

}
?>
    </tr>
<tr><td>&nbsp;</td></tr>
</table>


  </form>
</blockquote>
<?
/* include ("inc/footer_inc.php"); */
?>
</table>
</body>
</html>
