<?php
session_start();
include("inc/dbconnect.php");

$show_menu="ON";

 include("inc/index_header_inc.php"); 
?>
<HTML>
<head>
</head>
<tr><td>
  <blockquote>
   <h1>APTC check:</h1>

   <form name="mainform" method="post" action="call_ws_inc.php">

	<table border=0 cellspacing=0 cellpadding=2 bordercolor=#eeeeee width=700> 

        <tr><td>APTC Json:</td><td><TEXTAREA name="datastring" rows="15" cols="110"></textarea>
	</td></tr>

<?

echo "<tr><td colspan=6>&nbsp;</td></tr>";

echo "<br><br>";

?>



    <tr>
    <td colspan=2><input class="gray" type="Submit" name="submit" value="Submit"></td></tr>
    </table>
    </p>
    </form>
</blockquote>
<?

include "inc/footer_inc.php";
?>
</body>
</HTML>
