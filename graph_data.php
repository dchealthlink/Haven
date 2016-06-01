<?
session_start();
include("inc/dbconnect.php");

include("inc/header_inc.php");
$check_value = "account type";
if ($CASHIER) {
	$check_value = "cashier";
}
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
return (isInteger(s) && s.length >= minDigitsInIPhoneNumber);
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

   <h2>Transactions Data</h2>

<FORM NAME="mainform" METHOD="post" ACTION="<?php $PHP_SELF ?>">
<?

echo "<table border=1 align=center>";
echo "<td>";
include ("inc/graph.class.php");

   $myFirstGraph = new phpGraph;
/*   $myFirstGraph->SetBarImg("graphics/rasheisk.jpg"); */
   $myFirstGraph->SetBarImg($logo);
   $myFirstGraph->SetGraphTitle("Transactions by : ".$check_value);

/*

   $myFirstGraph->AddValue("Yes",4);
   $myFirstGraph->AddValue("No",5);
   $myFirstGraph->AddValue("I don't know",3);
*/
if ($check_value == 'status') {
/* $sql = "select sc.status_code, count(i.issue_id) as issue_count from status_code sc, issue i where sc.status = i.status  group by status_code"; */
$sql = "SELECT b.account_type, count(b.xa_id), sum(b.bill_amount - b.bill_balance) as bill_amount from xa_bill_log b, xa_log x WHERE x.xa_post_date like now()::date AND b.xa_id = x.xa_id GROUP BY b.account_type";

} else {
/* $sql = "select ".$check_value.", count(*) as issue_count from issue group by ".$check_value; */
$sql = "SELECT x.cashier_id, count(b.xa_id), sum(b.bill_amount - b.bill_balance) as bill_amount from xa_bill_log b, xa_log x WHERE x.xa_post_date like now()::date AND b.xa_id = x.xa_id GROUP BY x.cashier_id";
}
$result = pg_exec($db,$sql);

if(pg_ErrorMessage($db))
        {
        if ($debug) {
                DisplayErrMsg(sprintf("Executing %s ", $sql)) ;
        }
        DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
        };

$fieldnum = pg_numfields($result);
$num_rows = pg_numrows($result);

$rownum = 0;

while ($row = pg_fetch_array($result,$rownum))
{
                $term_value = ucfirst($row[pg_fieldname($result,0)]);
                $data_value = $row[pg_fieldname($result,1)];

   $myFirstGraph->AddValue($term_value,$data_value);
	$rownum = $rownum + 1;


}

   $myFirstGraph->SetShowCountsMode(1);
   $myFirstGraph->SetBarWidth(90);
   $myFirstGraph->SetBorderColor("#333333");
   $myFirstGraph->SetBarBorderWidth(1);
   $myFirstGraph->SetGraphWidth(300);
   /* $myFirstGraph->BarGraphHoriz(); */
   $myFirstGraph->BarGraphVert();
?>
</td>
</table>
<br>
<br>


</blockquote>

<table>
          <tr><td>&nbsp;</td>
    <td colspan=7>
    <input type="Submit" class="gray" name="ACCT_TYPE" value="By Account Type">&nbsp;
    <input type="Submit" class="gray" name="CASHIER" value="By Cashier">&nbsp;
    <input type="Submit" class="gray" name="PAGEHELP" value="Page Help" onClick="window.open('ph_graph_data.php','newWin','scrollbars=yes,status=no,toolbar=no,directories=no,resizable=no,screenX=100,screenY=400,top=100,left=400,width=400,height=500')">

        </td></tr>

<?
echo "</table>";

include "inc/footer_inc.php";
?>
</body>
</HTML>

