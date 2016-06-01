<?php
session_start();
/* include ("inc/dbconnect.php"); */
$show_menu="OFF";
include ("inc/config.php");
/* include ("inc/header_inc.php"); */
?>
<html>
<head>
<!--This line must be included as the swfobject.js file is referenced byt the javascript below-->
                <script type="text/javascript" src="swfobject.js"> </script>
<!--End of swfobject.js definition-->

<title>Cashiering (Harris) System - log in</title>
<link rel="stylesheet" href="inc/style.css" type="text/css">
<script language="">
<!--
function cursor(){document.login.name.focus();}
// -->
</script>
</head>
<?php
$show_menu="OFF";
include ("inc/index_header_inc.php");
$show_menu="ON";

?>
<body bgcolor="#FFFFFF" text="#000000" onLoad=cursor()>

<blockquote>

<?
if ($msg=="invalid") {

echo "<h2>Login Failed</h2>";
echo "<h1>Please check your user name and password</h1></td></tr>";
} else {
echo "<br>";
echo "<h2>".$msg."</h2>";
echo "<h1>Please log in</h1></td></tr>";

}
?>
<tr><td valign=top>
<table>
  <form action="login.php" method="post" name=login>
    <tr>
      <td>Username</td>
      <td>
        <input type="Text" name="name" value="<?php echo $name ?>" size="25">
      </td>
    </tr>
    <tr>
      <td height="6">Password</td>
      <td height="6">
        <input type="password" name="password" size="15">
        <input type="hidden" name="incoming" value="admin">
      </td>
    </tr>
    <tr>
      <td>
        <input type="Submit" name="submit" value="Enter">
      </td>
<?

if ($msg=="invalid") {
 echo "<td><b>Case Sensitive</b></td>";

}


echo "</tr>";
echo "<tr><td>&nbsp;</td></tr>";
/*
 <tr><td colspan=2>Make Online Payment - <a href="guest_payment.php"> Click Here</a></td></tr>
 <tr><td colspan=2>To Register - <a href="citizen_insert.php"> Click Here</a></td></tr>
*/
?>
<tr><td colspan=2>Can't remember your password - <a href="request_password.php"> Click Here</a></td></tr>
</table>

<!--This is where you setup the DIV. Notice the ID - this is the name of the DIV that is referenced by the Javascript below-->
        <div id="AlterEgosPlayer" align="right">Powered By AlterEgos.com</div>  <!--Replace this DIV ID with your own DIV ID if required-->
<!--End of DIV definition-->

<!--Please note the DIV must be before the Javascript -->
        <script type="text/javascript">
                        var so = new SWFObject("AlterEgos.com.swf", "main", "360", "400", "8", "#000000");
                        so.addParam("allowFullScreen", "true");
                        so.addVariable("MediaLink", "logon_page.flv");
                        so.addVariable("image", "test_avatar1.jpg");
                        so.addVariable("playOnStart", "true");
                        so.addParam("wmode", "transparent");
                        so.addVariable("startVolume", "50");
                        so.addVariable("loopMedia", "false");
                        so.write("AlterEgosPlayer");
                </script>


  </form>
</blockquote>
<?
/* include ("inc/footer_inc.php"); */
?>
</table>
</body>
</html>
