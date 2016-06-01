<?php
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
   <h1>Decode PW</h1>


  <?php

if($SUBMIT)
{
$key = "test";

$sql = "select new_password from app_user where user_id = '".$useid."'";
echo $sql;

$result = execSql($db, $sql, $debug);

list ($pulldata) = pg_fetch_row($result,0);


$crypttext = unencryptData_new($key, $pulldata);
showEcho ("crypttext is ",$crypttext);

};


?>
	<p>Please enter User ID</p>
  <form method="post" action="<?php echo $PHP_SELF?>">

      <p>
    Transaction ID:<br>
    <input type="text" size="10" name="useid">
    <br>
    Pay Seq:<br>
    <input type="text" size="6" name="pay_seq">
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
