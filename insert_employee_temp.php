<?
session_start();
include("inc/dbconnect.php");
session_unregister(tablename);


$menu_enabled = 1;
$header_table = "employee_temp";
$acc_method = "insert";
$flddisp = "Y";
/* $site_redirect = "department_confirm.php?department_id=".$department_id; */
$where_clause = "where table_name = 'employee_temp'";
if ($SUBMIT) {

$password = (dechex(crc32(time())));
}

include("inc/input_form_submit.php");

if ($MENU) {
	header("location: employee_menu.php");
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

   <h2>Please Enter Employee Information</h2></td></tr>

  <?php
   echo "<tr><td colspan=6><b>".$message_data."</b></td></tr>";

$header_table = "employee_temp";
echo "<FORM NAME=mainform METHOD=post ACTION=".$PHP_SELF." onSubmit='return ValidateForm()'>";

echo "<table>";
echo "<tr>";
echo "<td>Employee ID:</td><td><input type=text name=employee_id value='".$employee_id."'></td>";
echo "</tr>";
echo "<tr>";
echo "<td>Employee PW:</td><td><input type=password name=temp_word value='".$temp_word."'></td>";
echo "</tr>";
echo "<tr>";
echo "<td>Check Flag:</td><td><input type=text name=check_flag value=".$check_flag."></td>";
echo "</tr>";
echo "<tr>";
echo "<td>Fisma Group:</td><td><input type=text name=fisma_group value='".$fisma_group."'></td>";
echo "</tr>";
echo "<tr>";
echo "<td>Admin Group:</td><td><input type=text name=admin_group value='".$admin_group."'></td>";
echo "</tr>";
echo "<tr>";
echo "<td>IT Group:</td><td><input type=text name=it_group value='".$it_group."'></td>";
echo "</tr>";
echo "<tr>";
echo "<td colspan=2>&nbsp;</td>";
echo "</tr>";


?>
    <input type="hidden" name="tablename" value="<?php echo $header_table ?>">

          <tr><td colspan=7>
    <input class="gray" type="Submit" name="SEARCHQUERY" value="Search">&nbsp;
    <input class="gray" type="Submit" name="SUBMIT" value="Submit">&nbsp;
    <input class="gray" type="Submit" name="UPDATE" value="Update">&nbsp;
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

