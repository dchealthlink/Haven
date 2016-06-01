<?php
session_start();
include("inc/dbconnect.php");
include("inc/index_header_inc.php");



$menu_enabled = 0;
if(session_is_registered("key_attribute"))
{
        $$key_attribute = $key_value;
}

$menu_enabled=0;
if ($cust_id) {
        $sql_where_clause =" where cust_id = ".$cust_id ;
        $menu_enabled = 1;
        $key_attribute = "cust_id";
        $key_value = $cust_id;
}


$left_menu = display_menu_array($db,(substr($PHP_SELF, (strrpos($PHP_SELF, "/") + 1), 35)),$HTTP_REFERER,$menu_enabled, $userlevel);


?>
<HTML>
<head>
<script language = "Javascript">
function cursor(){
        mainform.existing.focus()
}
</script>
</head>
<body onload="cursor()">

  <blockquote>
   <h1>Change Password</h1>
  <?php

if ($cust_id) {
echo "<h1>Customer ID: ".$cust_id."</h1>";

}
if($submit)
{

	if ($new_pw == $new_pw_r) {

		/* $sql = "SELECT * FROM app_user where user_id = '".$form_user_id."' and password = '".$existing."'"; */
		$sql = "SELECT * FROM app_user where user_id = '".$form_user_id."' and (password = '".crypt($existing, $form_user_id)."' OR password = '".$existing."')"; 

		$result = pg_exec($db, $sql);

		$unique_cnt = pg_numrows($result);

		if ($unique_cnt == 0) {

			DisplayErrMsg(sprintf("Invalid password for user id : %s -- please retry", $form_user_id)) ;

		} else {

			pg_freeresult($result);

		        $encrypted_data = encryptData_old('test',$new_pw); 
			echo $encrypted_data."<br>";
		        $encrypted_pw = explode('SEPARATOR',$encrypted_data);
		        $escaped_next = pg_escape_bytea($encrypted_pw[1]); 

			$sql = "UPDATE app_user set new_password = '".(pg_escape_string($encrypted_data))."' WHERE user_id = '".$form_user_id."'"; 
/*			$sql = "UPDATE app_user set password = '".crypt($new_pw, $form_user_id)."' WHERE user_id = '".$form_user_id."'"; */

			echo $sql;
			
			$result = pg_exec($db, $sql); 
		
			if (pg_ErrorMessage($db)) {
				DisplayErrMsg(sprintf("Error in executing %s statement", $sql)) ;
				DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;  
			} else { 

				echo "<p>Password for User Name: ".$form_user_id." has been Updated</p>";
			}

		}

			pg_freeresult($result);

	} else {

		DisplayErrMsg(sprintf("Password mismatch for user name : %s -- please retry", $form_user_id)) ;
	};
};



$sql ="select user_id , user_name, user_type from app_user ";


switch ($usertype) {
	case "user":
		$sql.= " WHERE user_id = '".$userid."' order by user_id";
		break;
	case "su":
		$sql.= " WHERE user_id = '".$userid."' or user_type not in ('vendor','su') order by user_id";
		break;
	case "admin":
		$sql.= " WHERE user_id = '".$userid."' or user_type not in ('admin','vendor','su') order by user_id";
		break;
	case "vendor":
		$sql.= " order by user_id";
		break;
	default:
		$sql.= " WHERE user_id = '".$userid."' order by user_id";
	}
	

$result = pg_exec($db,$sql);

if(pg_ErrorMessage($db))
        {
	if ($debug) {
        DisplayErrMsG(sprintf("Error in executing %s statement", $sql)) ;
	}
        DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
        };

?>
  <form name="mainform" method="post" action="<?php echo $PHP_SELF?>">

      <p>
    User Name:<br>
<?
        echo"<select name=\"form_user_id\">";
/*        echo"<option selected value=\"\">"; */
        $l_rownum=0;

while ($row = pg_fetch_array($result,$l_rownum))
{
        $user_id = $row["user_id"];
	if ($user_type == "user") {
        	$user_type_ret = " ";
	} else {
        	$user_type_ret = " - ".$row["user_name"]." - ".$row["user_type"];
	}
	if ($user_id == $userid) {
        	echo "<option SELECTED value=".$user_id.">".$user_id.$user_type_ret ;
	} else {
        	echo "<option value=".$user_id.">".$user_id.$user_type_ret ;
	}
	$l_rownum = $l_rownum + 1;
}
echo "</select>";
?>
    <br>
    Existing Password:<br>
    <input type="password" size="15" name="existing">
    <br>
    New Password:<br>
    <input type="password" size="15" name="new_pw">
    <br>
    New Password(repeat):<br>
    <input type="password" size="15" name="new_pw_r">
    <br>

    <br>
    <input class="gray" type="Submit" name="submit" value="Submit">
    <input class="gray" type="Reset" name="reset" value="Reset">
    </p>
  </form>
</blockquote>
<!-- </td></table> -->
<?
include "inc/footer_inc.php";
?>
</td></table>
</body>
</HTML>
