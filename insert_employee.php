<?
session_start();
include("inc/dbconnect.php");

$menu_enabled = 1;
session_unregister(tablename);
$header_table = "employee";
$acc_method = "update";
$flddisp = "Y";
/* $site_redirect = "employee_confirm.php?employee_id=".$employee_id; */
$where_clause = "where table_name = 'employee'";
/*
if ($SUBMIT) {

$password = (dechex(crc32(time())));
}
*/
include("inc/input_form_submit.php");

include("inc/index_header_inc.php");
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
return (isInteger(s) && (s.length == minDigitsInIPhoneNumber || s.length == 4));
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
	
//	if (((Phone.value==null)||(Phone.value==""))&&(document.all.whichbutton.value!="SEARCH")){
//		alert("Please Enter your Phone Number")
//		Phone.focus()
//		return false
//	}
	if (Phone.value.length > 0){
		if (checkInternationalPhone(Phone.value)==false&&(document.all.whichbutton.value!="SEARCH")){
			alert("Please Enter a Valid Phone Number")
			Phone.value=""
			Phone.focus()
			return false
		}
	}
	return true
 }
</script>
</head>

   <h2>Please Enter Employee Information</h2></td></tr>

  <?php
   echo "<tr><td><b>".$message_data."</b></td></tr>";

$header_table = "employee";
$acc_method = "update";
echo "<FORM NAME=mainform METHOD=post ACTION=".$PHP_SELF." onSubmit='return ValidateForm()'>";


if ($employee_id) {

        $pgsql = "SELECT * from employee WHERE employee_id = '".$employee_id."'";

        $pgresult = execSql($db, $pgsql, $debug);

        $row = pg_fetch_array($pgresult, 0);

        $fieldnum = pg_numfields($pgresult);

        for($i=0;$i<$fieldnum; $i++) {
                $dummy=pg_fieldname($pgresult,$i);
                $$dummy=$row[pg_fieldname($pgresult,$i)];
        }

}

echo "<tr><td valign=top>";
include("inc/input_form_inc.php");
echo "</td></tr>";


?>
    <input type="hidden" name="tablename" value="<?php echo $header_table ?>">
	<input type="hidden" name="whichbutton" value="none" >

          <tr><td>
	<INPUT CLASS=GRAY TYPE=SUBMIT NAME=UPDATE VALUE=UPDATE ONCLICK="document.all.whichbutton.value = this.value; submit;">&nbsp;
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

