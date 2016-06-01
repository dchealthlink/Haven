<?
session_start();
include("inc/dbconnect.php");


if($key_value) {
        $show_menu="ON";
} else {
        $show_menu="OFF";
}



include("inc/header_inc.php");
?>
<HTML>
<tr><td>
  <blockquote>
   <h1>Decode Value</h1>


  <?php

if($SUBMIT)
{

$outdata = explode('-',$in_data);

showEcho ("first is ",$outdata[0]);
showEcho ("second is ",$outdata[1]);

};


?>
	<p>Please enter Transaction ID</p>
  <form method="post" action="<?php echo $PHP_SELF?>">

      <p>
    Transaction ID:<br>
    <input type="text" size="30" name="in_data">
    <br>

    <br>
    <input class="gray" type="Submit" name="SUBMIT" value="Submit">
    <input class="gray" type="Reset" name="reset" value="Reset">
    </p>
  </form>
</blockquote>
</td>
<!-- </table> -->
<?
include "inc/footer_inc.php";
?>
</body>
</HTML>
