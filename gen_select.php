<?
session_start();
include("inc/dbconnect.php");

include("inc/header_inc.php");
/*
session_start();
if(!session_is_registered("ownerid"))
{
header("Location: index.htm");
exit;
}
if ($client_name !== 'admin')
{
header("Location: index.htm");
exit;
}
	*/
?>
<PARAM name="user.LocalClientPrinters" value="Laser">
<PARAM name="user.Laser.port" value="UNC-SERVERUNC-PRINTER">
<PARAM name="user.Laser.driver" value="HP LaserJet 5/5M PostScript">
<PARAM name="user.Laser.comment" value="WFCDefault">
<HTML>
<tr><td>
  <blockquote>
   <h1>Select Data</h1>
  <form method="post" action="gen_sql.php" TARGET="_top">
	<b>Select:</b><br>
<textarea name="sqlstring" rows="10" cols="150"></textarea><br><br>
<input type="hidden" name="formproc" value="gen_select">
<INPUT class="gray" TYPE="submit" NAME="submit" VALUE="Submit the Query">
&nbsp;&nbsp;
<INPUT class="gray" TYPE="reset" NAME="reset" VALUE="Clear the Query">
  </form>
<!-- </table> -->
</blockquote>
<?
echo "<p>";

include "inc/footer_inc.php";
?>
</body>
</HTML>
