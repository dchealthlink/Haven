<?php
session_start();
include "inc/dbconnect.php";
include("inc/index_header_inc.php");

?>
<FORM NAME="mainform" METHOD="post" ACTION="<?php $PHP_SELF ?>">


            <td width="10%">&nbsp;</td>
            <td width="76%" align="left" valign="top">
              <h1>About Ignite TRX</h1>
		</td>
            <td width="14%">&nbsp; </td>

<?
/*

echo "<tr><td>Whatever the stuff is going to be</td>";
echo "</tr>";

?>


<tr>
<td>
<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE=SUBMIT></td><td>
<INPUT TYPE=RESET></td>
</tr></table>

<?
*/
echo "</tr>";
/* =========================== */
echo "<p>";
/*  include "inc/nav.inc"; */ 
include "inc/footer_inc.php";

?>
</table>
</form>
</body>
</HTML>


