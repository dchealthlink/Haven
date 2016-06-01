<?
session_start();
include("inc/dbconnect.php");
/*
if(!session_is_registered("key_attribute"))
{
header("Location: index.htm");
exit;
} else {
        $$key_attribute = $key_value;
}

$left_menu = display_menu_array($db,(ereg_replace("/","",$PHP_SELF)), $HTTP_REFERER);
*/

if($key_value) {
        $show_menu="ON";
} else {
        $show_menu="OFF";
}



include("inc/header_inc.php");
?>
<HTML>
<head>
<script language = "Javascript">
function LaunchHelp(winwidth, winheight) {
        myVWindow = window.open('request_password_help.php?show_menu=OFF', 'helpWindow', 'scrollbars,width='+winwidth+',height='+winheight);
                return true;
}
</script>
</head>
<tr><td>
  <blockquote>
   <h1>Request Password</h1>
	<p>Please enter your user id.  An administrator will be notified of your request.</p>


  <?php

if($SUBMIT)
{
/* ======================= notification ===================- */
$sql = "SELECT email, user_name, now() as post_timestamp, to_char(now(),'YYMMDDHHMISSMS') as key_val FROM app_user WHERE user_id = '".$user_id."'";

$result = pg_exec($db,$sql);
$num_rows = pg_num_rows($result);
if(pg_ErrorMessage($db))
         {
         DisplayErrMsg(sprintf("Executing %s ", $sql)) ;
         DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
         }

if ($num_rows == 1) {

	list ($user_email, $user_name, $post_timestamp, $key_val) = pg_fetch_row($result,0); 
/*
        $newpw = (dechex(crc32(time())));

        $sql ="UPDATE app_user set password = ";
        $sql.="'".(crypt($newpw, $user_id))."' ";
        $sql.=" WHERE user_id = '".$user_id."'";

        $result = pg_exec($db,$sql);

        if(pg_ErrorMessage($db))
                {
                DisplayErrMsg(sprintf("Executing %s ", $sql)) ;
                DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
                } 
*/

        $not_code = "password_request";

        $sql = "SELECT notice_subject, notice_text, notice_default_group_cd, notice_template, notice_level FROM notice_code WHERE notice_cd = '".$not_code."'";
	
        $result = pg_exec($db,$sql);
        if(pg_ErrorMessage($db))
                {
                DisplayErrMsg(sprintf("Executing %s ", $sql)) ;
                DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
                }

        list ($notice_subject, $notice_text, $notice_default_group_cd, $notice_template, $notice_level ) = pg_fetch_row($result, 0);

        $sql = "INSERT into notification (
        notification_id,
        notice_cd,
        notice_group_cd,
        notice_subject,
        notice_text,
        notice_level,
        posting_process,
        post_timestamp,
        notice_email,
        notice_template) values
        ('".$key_val."','".$not_code."','"
        .$notice_group_cd."','"
        .$notice_subject."','"
        .$notice_text."','"
        .$notice_level."','request_pw',now(),'"
        .$user_email."','"
        .$notice_template."')";

        $result = pg_exec($db,$sql);

        if(pg_ErrorMessage($db))
                {
                DisplayErrMsg(sprintf("Executing %s ", $sql)) ;
                DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
                }
        $sql = "INSERT into notice_data values ('".$key_val."','user_name','".$user_name."')";
        $result = pg_exec($db,$sql);
        $sql = "INSERT into notice_data values ('".$key_val."','post_timestamp','".$post_timestamp."')";
        $result = pg_exec($db,$sql);
        $sql = "INSERT into notice_data values ('".$key_val."','new_pw','".$newpw."')";
        $result = pg_exec($db,$sql);
        $sql = "INSERT into notice_data values ('".$key_val."','app_locality','".$app_locality."')";
        $result = pg_exec($db,$sql);
        $sql = "INSERT into notice_data values ('".$key_val."','city_desc','".$city_desc."')";
        $result = pg_exec($db,$sql);

	echo "<p>Password Request for User Name: ".$user_name." has been sent</p>";

	} else {
		DisplayErrMsg(sprintf("User not found for User ID : %s -- please retry", $user_id)) ;


/* ======================= end notification =============== */

};
};



?>
  <form method="post" action="<?php echo $PHP_SELF?>">

      <p>
    User ID:<br>
    <input type="text" size="35" name="user_id">
    <br>

    <br>
    <input class="gray" type="Submit" name="SUBMIT" value="Submit">&nbsp;
    <input class="gray" type="Reset" name="reset" value="Reset">
<?php
    echo "&nbsp;<INPUT CLASS=GRAY TYPE=BUTTON NAME=ViewHelp VALUE='Help' ONCLICK=LaunchHelp('450','350')>&nbsp;";
?>
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
