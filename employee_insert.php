<?php
session_start();
include("inc/dbconnect.php");

$menu_enabled = 1;
$header_table = "employee";
$acc_method = "insert";
$flddisp = "Y";
/* $site_redirect = "employee_confirm.php?employee_id=".$employee_id; */
$where_clause = "where table_name = 'employee'";
/*
if ($SUBMIT) {

$password = (dechex(crc32(time())));
$email = $employee_id ;
}
*/

include("inc/input_form_submit.php");
if ($SUBMIT) {

        $not_code = "new_user";

        $sql = "SELECT to_char(now(),'YYMMDDHHMISSMS') as key_val, notice_subject, notice_text, notice_default_group_cd, notice_template, notice_level, now() FROM notice_code WHERE notice_cd = '".$not_code."'";
        $result = execSql($db,$sql,$debug);
        if(pg_ErrorMessage($db))
                {
                DisplayErrMsg(sprintf("Executing %s ", $sql)) ;
                DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
                }

        list ($key_val, $notice_subject, $notice_text, $notice_default_group_cd, $notice_template, $notice_level, $post_timestamp ) = pg_fetch_row($result, 0);

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
        ('".$key_val."','"
        .$not_code."','"
        .$notice_group_cd."','"
        .$notice_subject."','"
        .$notice_text."','"
        .$notice_level."','new_employee','"
        .$post_timestamp."','"
        .$email."','"
        .$notice_template."')";

        $result = execSql($db,$sql,$debug);
        if(pg_ErrorMessage($db))
                {
                DisplayErrMsg(sprintf("Executing %s ", $sql)) ;
                DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
                }
        $sql = "INSERT into notice_data values ('".$key_val."','user_login','".$employee_id."')";
        $result = pg_exec($db,$sql);
        $sql = "INSERT into notice_data values ('".$key_val."','post_timestamp','".$post_timestamp."')";
        $result = pg_exec($db,$sql);
        $sql = "INSERT into notice_data values ('".$key_val."','municipality','".$app_locality."')";
        $result = pg_exec($db,$sql);
        $sql = "INSERT into notice_data values ('".$key_val."','city_desc','".$city_desc."')";
        $result = pg_exec($db,$sql);
        $sql = "INSERT into notice_data values ('".$key_val."','new_pw','".$password."')";
        $result = pg_exec($db,$sql);
        if(pg_ErrorMessage($db))
                {
                DisplayErrMsg(sprintf("Executing %s ", $sql)) ;
                DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
                }

}






include("inc/header_inc.php");
?>
<HTML>
<head>
<script language = "Javascript">

// Declaring required variables
var digits = "0123456789";
// non-digit characters which are allowed in phone numbers
var phoneNumberDelimiters = "()- ";
// characters which are allowed in international phone numbers
// (a leading + is OK)
var validWorldPhoneChars = phoneNumberDelimiters + "+";
// Minimum no of digits in an international phone no.
var minDigitsInIPhoneNumber = 10;

function isInteger(s)
{   var i;
    for (i = 0; i < s.length; i++)
    {   
        // Check that current character is number.
        var c = s.charAt(i);
        if (((c < "0") || (c > "9"))) return false;
    }
    // All characters are numbers.
    return true;
}

function stripCharsInBag(s, bag)
{   var i;
    var returnString = "";
    // Search through string's characters one by one.
    // If character is not in bag, append to returnString.
    for (i = 0; i < s.length; i++)
    {   
        // Check that current character isn't whitespace.
        var c = s.charAt(i);
        if (bag.indexOf(c) == -1) returnString += c;
    }
    return returnString;
}

function checkInternationalPhone(strPhone){
s=stripCharsInBag(strPhone,validWorldPhoneChars);
return (isInteger(s) && (s.length == minDigitsInIPhoneNumber || s.length == 3));
}


function echeck(str) {

		var at="@"
		var dot="."
		var lat=str.indexOf(at)
		var lstr=str.length
		var ldot=str.indexOf(dot)
		if (str.indexOf(at)==-1){
		   alert("Invalid E-mail ID")
		   return false
		}

		if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
		   alert("Invalid E-mail ID")
		   return false
		}

		if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		    alert("Invalid E-mail ID")
		    return false
		}

		 if (str.indexOf(at,(lat+1))!=-1){
		    alert("Invalid E-mail ID")
		    return false
		 }

		 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		    alert("Invalid E-mail ID")
		    return false
		 }

		 if (str.indexOf(dot,(lat+2))==-1){
		    alert("Invalid E-mail ID")
		    return false
		 }
		
		 if (str.indexOf(" ")!=-1){
		    alert("Invalid E-mail ID")
		    return false
		 }

 		 return true					
	}

function ValidateForm(){
	var emailID=document.frmSample.txtEmail
	
	if ((emailID.value==null)||(emailID.value=="")){
		alert("Please Enter your Email ID")
		emailID.focus()
		return false
	}
	if (echeck(emailID.value)==false){
		emailID.value=""
		emailID.focus()
		return false
	}
	return true
 }





function ValidateForm(){
	var Phone=document.mainform.phone
	
	if ((Phone.value==null)||(Phone.value=="")){
		alert("Please Enter your Phone Number")
		Phone.focus()
		return false
	}
	if (checkInternationalPhone(Phone.value)==false){
		alert("Please Enter a Valid Phone Number")
		Phone.value=""
		Phone.focus()
		return false
	}
	return true
 }
</script>
</head>

   <h2>Please Enter Employee Information<?php echo $message_data ?></h2></td></tr>

  <?php

/*
if($submit)
{
DisplayErrMsg(sprintf("Start time: %s",date("m-d-y h:i:s"))) ;
$sql = "COPY " . $table_name . " TO " . "'" . $file_name ."' USING DELIMITERS ';';";
$result = pg_exec($db, $sql);

$sql = "INSERT INTO LOG (log_name, log_type, log_level, log_dir, log_file,
        log_status) VALUES ('" . $table_name . "','Export',1,'"
         . dirname($file_name) ."','" . basename($file_name) . "','COMPLETE');";
$result = pg_exec($db, $sql);

DisplayErrMsg(sprintf("End Time  : %s", date("m-d-y h:i:s"))) ;
pg_freeresult($result);
echo "<p>Data from table " . $table_name . " To File: " . $file_name . " has been Exported</p>";

};
*/

$employee_status = "A";


$header_table = "employee";
echo "<FORM NAME=mainform METHOD=post ACTION=".$PHP_SELF." onSubmit='return ValidateForm()'>";

echo "<tr><td valign=top>";
include("inc/input_form_inc.php");
echo "</td></tr>";


?>
    <input type="hidden" name="tablename" value="<?php echo $header_table ?>">

          <tr><td>
    <input class="gray" type="Submit" name="SUBMIT" value="Submit">&nbsp;
    <input class="gray" type="reset" name="RESET" value="Reset">
        </td></tr>
 </p>
  </form>
</blockquote>
<?
include "inc/footer_inc.php";
?>
</table>
</body>
</HTML>

