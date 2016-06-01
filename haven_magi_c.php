<?php
session_start();
include("inc/dbconnect.php");

$show_menu="ON";

 include("inc/index_header_inc.php"); 


?>
<HTML>
<head>
<style type="text/css">
   input.asLabel
   {
      border: none;
      background: transparent;
   }
</style>
<script language = "Javascript">
function calculate_wages(updfield)
{

var e = document.getElementById("wagePeriod");

 if (updfield == 'monthlyWages' || updfield == 'Wages' ) {
	var calcField = e.options[e.selectedIndex].value;
} else {
	var calcField = 12 ;
}

   if ( updfield.substring(0,5)  == 'month') {
	var allwages = document.getElementById(updfield.substring(7)) ; 
	var justmonthlywages = document.getElementById(updfield) ;
	allwages.value = parseInt(parseInt(justmonthlywages.value) * calcField); 
   } else {
	var justmonthlywages = document.getElementById('monthly'+updfield) ;
	var allwages = document.getElementById(updfield) ;
	if (allwages.value) {
		justmonthlywages.value = parseInt(parseInt(allwages.value) / calcField) ; 
	} else {
		justmonthlywages.value = null ; 
	}
   }

}
function hideshow(which){
	alert ('which is '+which.style.display);
	if (!document.getElementById)
return
	if (which.style.display=="block")
		which.style.display="none"
	else
	which.style.display="block"
}
function showhiderow() {
                            if (document.getElementById('adiv').style.display == 'none') {
                                document.getElementById("adiv").style.display = '';
                            } else {
                                document.getElementById("adiv").style.display = 'none'; 
                            }
}
function showhidecitizen() {
                            if (document.getElementById('isUSCitizen').checked) {
                                document.getElementById("citizendiv").style.display = 'none';
                            } else {
                                document.getElementById("citizendiv").style.display = ''; 
                            }
}
function showhidelawful() {
                            if (document.getElementById('lawfuldiv0').style.display == 'none') {
                                document.getElementById("lawfuldiv0").style.display = '';
                            } else {
                                document.getElementById("lawfuldiv0").style.display = 'none'; 
                                document.getElementById("immigrationdiv2").style.display = 'none';
                            }
}
function showhideimmigration() {

	var e = document.getElementById("immigrationStatus");
	var fld = document.getElementById("immigrationDateType");

	var immigrationSelect = e.options[e.selectedIndex].value;
                            if (parseInt(immigrationSelect) > 0) {
                                document.getElementById("immigrationdiv2").style.display = '';
				
				switch (parseInt(immigrationSelect)) {
				case 1:
				break;
				case 2:
					document.getElementById("immigrationDateType").value = 'Asylum Grant Date';
				break;
				case 3:
					document.getElementById("immigrationDateType").value = 'Refugee Admit Date';
				break;
				case 4:
					document.getElementById("immigrationDateType").value = 'Status Grant Date';
				break;
				case 9:
					document.getElementById("immigrationDateType").value = 'Deportation Withheld Date';
				break;
				default:
					document.getElementById("immigrationDateType").value = '';
				}



                            } else {
                                document.getElementById("immigrationdiv2").style.display = 'none'; 
                            }
}
function showhideimmigrationdate() {
		var amerasiancheck = document.getElementById("amerasianStatus");
                            if (amerasiancheck.checked) {
				document.getElementById("immigrationDateType").value = 'Entry Date';
                            } else {
                            }
}
function showcurrentperson() {
		var fname = document.getElementById("firstName");
		var lname = document.getElementById("lastName");
		document.getElementById("currenttaxperson").value = fname.value.toUpperCase()+' '+lname.value.toUpperCase();
                if (document.getElementById("firstName") && document.getElementById("lastName")) {
                       document.getElementById("taxreturndiv").style.display = '';
                       document.getElementById("filertypediv").style.display = '';
                       document.getElementById("hhlabeldiv").style.display = '';
                       document.getElementById("householddiv").style.display = '';
                } else {
                       document.getElementById("taxreturndiv").style.display = 'none'; 
                       document.getElementById("filertypediv").style.display = 'none'; 
                       document.getElementById("hhlabeldiv").style.display = 'none';
                       document.getElementById("householddiv").style.display = 'none';
                }
		document.getElementById("currentperson").value = fname.value.toUpperCase()+' '+lname.value.toUpperCase();
		document.getElementById("currentrelperson").value = fname.value.toUpperCase()+' '+lname.value.toUpperCase();
}
function calculateAge(dateString) { // birthday is a date
	if (dateString.value.length == 8) {
		var dateString1 = dateString.value.substring(0,4)+'-'+dateString.value.substring(4,6)+'-'+dateString.value.substring(6,8);
	} else {
  		var dateString1 = dateString.value;
	}
  var birthday = +new Date(dateString1);
  var applAge = document.getElementById("applAge");
  var age =  ~~((Date.now() - birthday) / (31557600000));
	if (age >= 0) {
	applAge.value = age;
	}
}
function check_hrsWorked() {
    var return_hrsWorked=false
    var inp02=document.mainform.hrsWorked.value
    if (inp02=="") {
     alert("Field: Hours Worked is Mandatory -- please enter")
    } else {
     return_hrsWorked=true
    }
    return return_hrsWorked
}
function check_firstName() {
    var return_firstName=false
    var inp02=document.mainform.firstName.value
    if (inp02=="") {
     alert("Field: First Name is Mandatory -- please enter")
    } else {
     return_firstName=true
    }
    return return_firstName
}
function check_lastName() {
    var return_lastName=false
    var inp02=document.mainform.lastName.value
    if (inp02=="") {
     alert("Field: Last Name is Mandatory -- please enter")
    } else {
     return_lastName=true
    }
    return return_lastName
}
function check_applDOB() {
    var return_applDOB=false
    var inp02=document.mainform.applDOB.value
    if (inp02=="") {
     alert("Field: DOB is Mandatory -- please enter")
    } else {
     return_applDOB=true
    }
    return return_applDOB
}
function chkForm1() {
   varF1B=check_firstName();
   if (varF1B==false) {
       document.mainform.firstName.focus() ;
       return false ;
   }
   varF1C=check_lastName();
   if (varF1C==false) {
       document.mainform.lastName.focus() ;
       return false ;
   }
   varF1D=check_applDOB();
   if (varF1D==false) {
       document.mainform.applDOB.focus()
       return false
   }
   varF1A=check_hrsWorked();
   if (varF1A==false) {
       document.mainform.hrsWorked.focus()
       return false
   }
return true;
}
function ValidateForm(){
        if (chkForm1()==false){
                return false
        } else {
                return true
        }
}

</script>
</head>
<tr><td>
  <blockquote>
   <h1>HAVEN - POC <?php echo $rep_name ?></h1>

<!-- <form name="mainform" method="post" action="magi_result.php"> -->
<!-- <form name="mainform" method="post" action="magi_add.php" onSubmit="return ValidateForm(this);">  -->
 <form name="mainform" method="post" action="haven_magi_add.php" > 

	<table border=0 cellspacing=0 cellpadding=2 bordercolor=#eeeeee width=900> 


<?

if (!$applId) {
$presql = "SELECT max(applId) + 1 from application WHERE postDate = now()::date ";
$preresult = execSql($db, $presql, $debug) ;
list($applId) = pg_fetch_row($preresult, 0);
	if (!$applId) {
		$applId = (date("y") * 10000000) + ((date("z") + 1) * 10000) + 1 ;
	}
	$personId = 1;
	$applPersonId = ($applId * 10000) + $personId ;
	$showMulti = 0;
	$readoption = '';
} else {

	$readoption = 'readonly';
	$presql = "SELECT max(personid) + 1 from application_person WHERE applid = '".$applId."' ";
	$preresult = execSql($db, $presql, $debug) ;
	list($personId) = pg_fetch_row($preresult, 0);
	$applPersonId = ($applId * 10000) + $personId ;

	$showMulti = 1;

	$presql = "select ap.personid, p.personfirstname||' '||p.personlastname, ap.isapplicant, ap.applname, ap.applage, p.persondob, ap.wages, a.status, a.statustimestamp , a.statecd, a.appyear, a.name FROM application_person ap, person p, application a WHERE ap.personid = p.personid and ap.applid = a.applid and ap.applid = ".$applId." order by 2 ";
	$preresult = execSql($db, $presql, $debug) ;
        $prownum = 0;
                                                echo "<tr><td colspan=19><table border=1>";
                                                echo "<tr>";
                                                echo "<td>Appl ID</td>";
                                                echo "<td>Name</td>";
                                                echo "<td>Applicant</td>";
                                                echo "<td>Name</td>";
                                                echo "<td>Age</td>";
                                                echo "<td>D.O.B.</td>";
                                                echo "<td>Wages</td>";
                                                echo "<td>Status</td>";
                                                echo "<td>Timestamp</td>";
                                                echo "</tr>";
        while($row = pg_fetch_array($preresult, $prownum)) {
        	list ($vpersonId, $vpersName, $visApplicant, $vapplName, $vapplAge, $vapplDOB, $Wages, $vstatus, $vstattimestamp, $stateCd, $appYear, $vname) = pg_fetch_row($preresult, $prownum);
                                                echo "<tr>";
                                                echo "<td>".$applId."</td>";
                                                echo "<td>".$vpersName."</td>";
                                                echo "<td>".$visApplicant."</td>";
                                                echo "<td>".$vapplName."</td>";
                                                echo "<td>".$vapplAge."</td>";
                                                echo "<td>".$vapplDOB."</td>";
                                                echo "<td>".$Wages."</td>";
                                                echo "<td>".$vstatus."</td>";
                                                echo "<td>".$vstattimestamp."</td>";
                                                echo "</tr>";
                                                $prownum = $prownum + 1;
                                        }
                                                echo "</table></td></tr>";


}


?>



    <tr><td>State:
<?php
 echo "<img src='images/btn_tinyquestion.gif' ALT=\"What's This?\" onClick=\"javascript:window.open('view_report_parameter.php?report_name='+mainform.reportname.value, 'listWindow', 'screenX=300,screenY=300,width=700,height=400,scrollbars'); return false;\"></td><td>";

?>


  <select name="stateCd">
  <option value="<? echo $stateCd ?>" selected><? echo $stateCd ?></option>
  <?
	if ($readoption != 'readonly') {
  $reportname_all = pg_exec($db,"SELECT state, state_name from states  order by sort_order");
$rownum = 0;
  while ($reportname_row = pg_fetch_array($reportname_all, $rownum))
  {
  $item_description = $reportname_row["state_name"];
  $item_cd = $reportname_row["state"];
  $item_translation = $reportname_row["state"];
$rownum = $rownum + 1;
  echo "<option value='$item_cd'>$item_description</option>";
  }
	}
  ?>
  </select>

</td><td>
    Application Year:<br>(year starts Apr 1)</td><td>


  <select name="appYear">
  <option value="<? echo $appYear ?>" selected><? echo $appYear ?></option>
  <?
	if ($readoption != 'readonly') {
  $date_param_all = pg_exec($db,"SELECT item_cd, item_description from app_lookup 
	WHERE lookup_table = 'generic' and lookup_field = 'appyear'");
$rownum = 0;
  while ($date_param_row = pg_fetch_array($date_param_all, $rownum))
  {
  $item_description = $date_param_row["item_description"];
  $item_cd = $date_param_row["item_cd"];
$rownum = $rownum + 1;
  echo "<option value='$item_cd'>$item_description</option>";
  }
	}
  ?>
  </select>

          </td>
<td> Name:</td><td>
    <input type="text" name="applName" size="20" maxlength="60" value="<?php echo $vname ?>"  <?php echo $readoption ?>></td>
</tr>
<tr>
<td colspan=8>&nbsp;</td>
</tr>
<tr>
<td> First Name:</td><td>
    <input type="text" id="firstName" name="firstName" size="15" maxlength="30" onchange="showcurrentperson();"></td>
<td> Last Name:</td><td>
    <input type="text" id="lastName" name="lastName" size="15" maxlength="30" onchange="showcurrentperson();"></td>
<td> <b>DOB:</b></td><td>
    <input type="text"  name="applDOB" size="11" maxlength="10" onblur="BisDate(this,'N');" onchange="calculateAge(this);"  ></td>
</tr>
<tr>
<td> Hours worked per week:</td><td>
        <select name="hrsWorked">
        	<option selected value=0>0
<?
	for ($i=1;$i < 100; $i++) {
		echo "<option value=".$i.">".$i ;
	}
?>
        </select>
    </td>
<td>&nbsp;</td><td>&nbsp;</td>
<td> SSN:</td><td>
    <input type="text" name="applSSN" size="11" maxlength="11"></td>
</tr>
<tr>
<td>
    Is this individual<br>applying for insurance?:</td><td>
    <input type="checkbox" name="isApplicant" checked ></td>
    <input type="hidden" name="applId" value="<?php echo $applId ?>"></td>
    <input type="hidden" name="personId" value="<?php echo $personId ?>"></td>
    <input type="hidden" name="applPersonId" value="<?php echo $applPersonId ?>"></td>
    <input type="hidden" name="name" value="<?php echo $applId."-".$applPersonId ?>"></td>
<td>
    <b>Age:</b></td><td>
    <input type="text" class="asLabel" id="applAge" name="applAge" size="3" readonly></td>
</tr>
<tr>
<td> <b>DC Resident:</b></td><td> <input type="checkbox" name="isStateResident" checked> </td>
<td> <b>Has insurance:</b></td><td> <input type="checkbox" name="isInsured" > </td>
<td> <b>Pregnant:</b></td><td> <input type="checkbox" name="isPregnant"  onchange="showhiderow();"> </td>
</tr>
<tr id="adiv" style="display:none">
<td colspan=4>&nbsp;</td>
<td> <b>Children<br>Expected:</b></td><td> 
        <select name="numChildren">
        	<option selected value=1>1
        	<option value=2>2
        	<option value=3>3
        	<option value=4>4
        	<option value=5>5
        	<option value=6>6
        	<option value=7>7
        	<option value=8>8
        	<option value=0>0
        </select>
</td>
<td colspan=2>&nbsp;</td> 
</tr>
<tr>
<td> <b>US citizen:</b></td><td> <input type="checkbox" id="isUSCitizen" name="isUSCitizen" checked onchange="showhidecitizen();" > </td>
<td> <b>Incarcerated:</b></td><td> <input type="checkbox" name="isIncarcerated" > </td>
<td> <b>Tax filer</b>:</td><td> <input type="checkbox" name="isTaxRequired" > </td>
</tr>
<tr id="citizendiv" style="display:none">
<td> <b>Lawfully present<br>in U.S.</b>:</td><td> <input type="checkbox" name="lawfullyPresent"  onchange="showhidelawful();">
</td>
<!-- <td colspan=4>&nbsp;</td> -->
<td id="lawfuldiv0" style="display:none" colspan=2>Immigration Status:<br>
        <select id="immigrationStatus" name="immigrationStatus" onchange="showhideimmigration();">
        	<option selected value=> 
        	<option value='01'>Lawful Permanent Resident
        	<option value='02'>Asylee
        	<option value='03'>Refugee
        	<option value='04'>Cuban/Haitian Entrant
        	<option value='05'>Paroled into the U.S. for at least one year
        	<option value='06'>Conditional entrant granted before 1980
        	<option value='07'>Battered non-citizen, spouse, child or parent
        	<option value='08'>Victim of trafficking
        	<option value='09'>Granted withholding of deportation
        	<option value='10'>Member of a federally recognized Indian tribe
        	<option value='10'>American Indian born in Canada
        	<option value='11'>Other
        </select>
</td>
</tr>


<tr id="immigrationdiv2" style="display:none">
<td> <b>Five Year Bar<br>applies to applicant:</b></td><td> <input type="checkbox" id="fiveYearBar" name="fiveYearBar"  > </td>
<td> <b>Five Year Bar<br>has been met:</b></td><td> <input type="checkbox" name="fiveYearBarMet" > </td>
</tr>


<tr>
<td colspan=6>&nbsp;</td>
</tr>
<tr><td colspan=6><table>
<tr><td>
        <select name="wagePeriod" id="wagePeriod" onchange="calculate_wages('Wages');">
        	<option selected value=12>monthly
        	<option value=52>weekly
        	<option value=26>bi-weekly
        	<option value=6>bi-monthly
        	<option value=1>annually
        </select>
 Wages:</td><td> <input type="text" id="monthlyWages" name="monthlyWages" size="6"  onchange="calculate_wages('monthlyWages');"> </td> 
<!-- <td> Monthly Wages:</td><td> <input type="text" id="monthlyWages" name="monthlyWages" size="8"  onchange="calculate_wages('monthlyWages');"> </td> -->
<td>&nbsp;</td>
<td> Annual Wages:</td><td> <input type="text" id="Wages" name="Wages" size="7"  onchange="calculate_wages('Wages');"> </td>
</tr>
<tr>
<td> Monthly taxable interest:</td><td> <input type="text" id="monthlyTaxableInterest" name="monthlyTaxableInterest" size="6" onchange="calculate_wages('monthlyTaxableInterest');"> </td>
<td>&nbsp;</td>
<td> Annual taxable interest:</td><td> <input type="text" id="TaxableInterest" name="TaxableInterest" size="7" onchange="calculate_wages('TaxableInterest');"> </td>
</tr>
<tr>
<td> Monthly pensions and annuities taxable amount:</td><td> <input type="text" id="monthlyPensionAnnuities" name="monthlyPensionAnnuities" size="6" onchange="calculate_wages('monthlyPensionAnnuities');"> </td>
<td>&nbsp;</td>
<td> Annual pensions and annuities taxable amount:</td><td> <input type="text" id="PensionAnnuities" name="PensionAnnuities" size="7" onchange="calculate_wages('PensionAnnuities');"> </td>
</tr>
<tr>
<td> Monthly tax-exempt interest:</td><td> <input type="text" id="monthlyTaxExemptInterest" name="monthlyTaxExemptInterest" size="6" onchange="calculate_wages('monthlyTaxExemptInterest');"> </td>
<td>&nbsp;</td>
<td> Annual tax-exempt interest:</td><td> <input type="text" id="TaxExemptInterest" name="TaxExemptInterest" size="7" onchange="calculate_wages('TaxExemptInterest');"> </td>
</tr>
<tr>
<td> Monthly farm income or loss:</td><td> <input type="text" id="monthlyFarmIncome" name="monthlyFarmIncome" size="6" onchange="calculate_wages('monthlyFarmIncome');"> </td>
<td>&nbsp;</td>
<td> Annual farm income or loss:</td><td> <input type="text" id="FarmIncome" name="FarmIncome" size="7" onchange="calculate_wages('FarmIncome');"> </td>
</tr>
<tr>
<td> Monthly taxable refunds, credits, or offsets of state <br>and local income taxes:</td><td> <input type="text" id="monthlyTaxRefunds" name="monthlyTaxRefunds" size="6" onchange="calculate_wages('monthlyTaxRefunds');"> </td>
<td>&nbsp;</td>
<td> Annual taxable refunds, credits, or offsets of state <br>and local income taxes:</td><td> <input type="text" id="TaxRefunds" name="TaxRefunds" size="7" onchange="calculate_wages('TaxRefunds');"> </td>
</tr>
<tr>
<td> Monthly unemployment compensation:</td><td> <input type="text" id="monthlyUnemployIncome" name="monthlyUnemployIncome" size="6" onchange="calculate_wages('monthlyUnemployIncome');"> </td>
<td>&nbsp;</td>
<td> Annual unemployment compensation:</td><td> <input type="text" id="UnemployIncome" name="UnemployIncome" size="7" onchange="calculate_wages('UnemployIncome');"> </td>
</tr>
<tr>
<td> Monthly alimony:</td><td> <input type="text" id="monthlyAlimony" name="monthlyAlimony" size="6" onchange="calculate_wages('monthlyAlimony');"> </td>
<td>&nbsp;</td>
<td> Annual alimony:</td><td> <input type="text" id="Alimony" name="Alimony" size="7" onchange="calculate_wages('Alimony');"> </td>
</tr>
<tr>
<td> Monthly adjustments:</td><td> <input type="text" id="monthlyMagiDeductions" name="monthlyMagiDeductions" size="6" onchange="calculate_wages('monthlyMagiDeductions');"> </td>
<td>&nbsp;</td>
<td> Annual adjustments:</td><td> <input type="text" id="MagiDeductions" name="MagiDeductions" size="7" onchange="calculate_wages('MagiDeductions');"> </td>
</tr>
</table>
</td>
</tr>
<tr>
<td colspan=6>&nbsp;</td>
</tr>
<?php
/*
  $esql = "SELECT employee_id, last_name||',  '||first_name FROM employee ";
	if ($usertype == 'basic' or $usertype == 'intermediate' or $usertype == 'advanced' or $usertype == 'chd2') {
		$esql.=" WHERE employee_id = '".$userid."' ";
	}
	$esql.=" ORDER BY last_name, first_name ";

$eresult = execSql($db, $esql, $debug);
echo "<tr><td>Employee: </td><td>";

        echo"<select name=\"employee_id\">";
	
	if ($usertype == 'admin' or $usertype == 'su' or $usertype == 'supervisor' or $usertype == 'support') {
        	echo"<option selected value=\"\">";
	}
        $e_rownum=0;
while ($row = pg_fetch_array($eresult,$e_rownum))
{
        list($temp_emp_id, $temp_emp_name) = pg_fetch_row($eresult,$e_rownum);
                echo "<option value=".$temp_emp_id.">".$temp_emp_name;
        $e_rownum = $e_rownum + 1;
}
echo "</select></td>";




  $lcsql = "SELECT department_id, department_name FROM department ORDER BY department_id ";

$lcresult = execSql($db, $lcsql, $debug);
echo "<td>Department: </td><td>";

        echo"<select name=\"department_id\">";
        echo"<option selected value=\"\">";
        $l_rownum=0;
while ($row = pg_fetch_array($lcresult,$l_rownum))
{
        list($temp_resp_code, $temp_resp_desc) = pg_fetch_row($lcresult,$l_rownum);
                echo "<option value=".$temp_resp_code.">".$temp_resp_code." - ".$temp_resp_desc;
        $l_rownum = $l_rownum + 1;
}
echo "</select></td></tr>";



  $ppsql = "SELECT course_id, course_name FROM course ORDER BY 1";

$ppresult = execSql($db, $ppsql, $debug);
echo "<td>Course: </td><td>";

        echo"<select name=\"course_id\">";
        echo"<option selected value=\"\">";
        $p_rownum=0;
while ($row = pg_fetch_array($ppresult,$p_rownum))
{
        list($temp_course_id, $temp_course_name) = pg_fetch_row($ppresult,$p_rownum);
                echo "<option value=".$temp_course_id.">".$temp_course_name;
        $p_rownum = $p_rownum + 1;
}
echo "</select></td>";


  $ppsql = "SELECT module_id, module_name FROM module order by 1";

$ppresult = execSql($db, $ppsql, $debug);
echo "<td>Module: </td><td>";

        echo"<select name=\"module_id\">";
        echo"<option selected value=\"\">";
        $p_rownum=0;
while ($row = pg_fetch_array($ppresult,$p_rownum))
{
        list($temp_module_id, $temp_module_name) = pg_fetch_row($ppresult,$p_rownum);
                echo "<option value=".$temp_module_id.">".$temp_module_name." (".$temp_module_id.")";
        $p_rownum = $p_rownum + 1;
}
echo "</select></td>";
echo "</tr>";

*/

 echo "<tr><td colspan=6>&nbsp;</td></tr>";
/*
 echo "<tr><td>Amount Greater Than (>):</td><td><input class=pink type=text name=gt_amt maxlength=9 size=10></td>";
 echo "<td>Amount Less Than (<):</td><td><input class=pink type=text name=lt_amt maxlength=9 size=10></td></tr>";
 echo "<tr><td>Payment Type: </td><td>";

        echo"<select name=\"pay_method\">";
        echo"<option selected value=\"\">";

	$pay_method_all = pg_exec($db,"SELECT pay_method, pay_method_desc FROM pay_method ORDER BY sort_order");
	$rownum = 0;
  	while ($pay_method_row = pg_fetch_array($pay_method_all, $rownum)) {
		$item_description = $pay_method_row["pay_method_desc"];
		$item_cd = $pay_method_row["pay_method"];
		$rownum = $rownum + 1;
		echo "<option value='$item_cd'>$item_description</option>";
	}

echo "</select></td>";
$cashsql ="SELECT cashier_id, cashier_name FROM cashier WHERE cashier_status = 'A' ORDER BY 1";

$cashresult = execSql($db, $cashsql, $debug);
echo "<td>Cashier: </td><td>";

        echo"<select name=\"cashier_id\">";
        echo"<option selected value=\"\">";
        $l_rownum=0;
while ($row = pg_fetch_array($cashresult,$l_rownum))
{
        list($temp_cashier_id, $cashier_name) = pg_fetch_row($cashresult,$l_rownum);
        if ($cashier_id == $temp_cashier_id) {
                echo "<option selected value=".$temp_cashier_id.">".$temp_cashier_id." - ".$cashier_name;
        } else {
                echo "<option value=".$temp_cashier_id.">".$temp_cashier_id." - ".$cashier_name;
        }
        $l_rownum = $l_rownum + 1;
}
echo "</select></td></tr>";
*/
?>

<!-- </table> -->
<br>
<!--	<table border=0 cellspacing=0 cellpadding=2 bordercolor=#eeeeee width=600> -->
<?
  /*  <tr><td align=center><b><a href='' onClick="javascript:$report=calls_by_account">Calls by Account</a></b></td> */
?>

<?

$sql="SELECT * from app_lookup where lookup_table = 'report_menux' order by sort_order";

$result = pg_exec($db,$sql);
if(pg_ErrorMessage($db))
        {
        if ($debug) {
                DisplayErrMsg(sprintf("Error in executing %s statement", $sql)) ;
        }
        DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
        };


echo "<br>";
$rownum = 0;
/* echo "<table border=0 cellspacing=0 cellpadding=2 bordercolor=#eeeeee width=600>";
*/

while ($row = pg_fetch_array($result,$rownum))
{
$test=$row[pg_fieldname($result,0)];

echo "<tr><td align=center colspan=2><b><a href='".$row[pg_fieldname($result,4)]."'>".$row[pg_fieldname($result,2)]."</a></b></td><td colspan=2>".$row[pg_fieldname($result,3)]."</td></tr>";

$rownum = $rownum + 1;
}

$sql="SELECT * from user_query where user_id='".$userid."' order by query_name";

$result = pg_exec($db,$sql);
if(pg_ErrorMessage($db))
        {
        if ($debug) {
                DisplayErrMsg(sprintf("Error in executing %s statement", $sql)) ;
        }
        DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
        };


echo "<br>";
$rownum = 0;

while ($row = pg_fetch_array($result,$rownum))
{
$test=$row[pg_fieldname($result,0)];

echo "<tr><td align=center colspan=2><b><a href='run_user_query.php?query_name=".$row[pg_fieldname($result,1)]."'>".$row[pg_fieldname($result,1)]."</a></b></td><td colspan=2>".$row[pg_fieldname($result,2)]."</td></tr>";

$rownum = $rownum + 1;
}


?>




    <tr><td align=center colspan=2><b>---------------</a></b></td><td align=left colspan=2>------------------------------</td></tr>

<?
	if ($showMulti == 1) {
		echo '<tr><td>For:</td><td>';
		echo "<input class=asLabel type=text id=currentrelperson name=currentperson readonly></td></tr>";

  	$persql = "SELECT ap.applid, ap.personid, p.personfirstname||' '||p.personlastname, ru.relationship  from person p, application_person ap left outer join relationship_union ru on ap.applid = ru.applid and ap.personid = ru.personid  WHERE ap.personid = p.personid and ap.applId = '".$applId."' order by 3";
  	$persql = "SELECT ap.applid, ap.personid, p.personfirstname||' '||p.personlastname  from person p, application_person ap   WHERE ap.personid = p.personid and ap.applId = '".$applId."' order by 3";
	
	$perresult = execSql($db, $persql, $debug) ;
        $prownum = 0;
        while($prow = pg_fetch_array($perresult, $prownum)) {
        	list ($papplid, $ppersonId, $papplname, $prelationship) = pg_fetch_row($perresult, $prownum);
		echo '<tr><td>Person:</td><td>'.$papplname.'</td>';

		echo "<td>is a/an </td><td>";
                echo '<input type="hidden" name="crosspersonid['.$prownum.']" value="'.$ppersonId.'">';
		
  		echo '<select name="crossrelationship['.$prownum.']">';
 		echo '<option value="'.$no_prelationship.'" >'.$no_prelationship.'</option>';
 
  			$relationship_all = pg_exec($db,"SELECT relationship from relationship order by sort_order "); 
			$rownum = 0;
				while ($relationship_row = pg_fetch_array($relationship_all, $rownum)) {
  					$item_description = $relationship_row["relationship"];
  					$item_cd = $relationship_row["relationship"];
					$rownum = $rownum + 1;
  					echo "<option value='$item_cd'>$item_description</option>";
  				}
  		echo "</select>";
		echo "</td></tr>";
		$prownum = $prownum + 1;
	}

    echo '<tr><td align=center colspan=2><b>---------------</b></td><td align=left colspan=2>------------------------------</td></tr>';

  	$hhsql = "SELECT distinct a.applid, a.personid, p.personfirstname||' '||p.personlastname, b.householdid  from person p, application_person a left outer join application_household b on a.applid = b.applid and a.personid = b.personid WHERE a.personid = p.personid and a.applId = '".$applId."' order by 3, a.personid, b.householdid ";

	$hhresult = execSql($db, $hhsql, $debug) ;
	$hhcount = pg_num_rows($hhresult) ;
        $hrownum = 0;
        while($hrow = pg_fetch_array($hhresult, $hrownum)) {
        	list ($happlid, $hpersonId, $hpersonname, $hhouseholdid) = pg_fetch_row($hhresult, $hrownum);
		echo '<tr><td>Person:</td><td>'.$hpersonname.'</td>';

		echo "<td>Household</td><td>";
                echo '<input type="hidden" name="hhpersonid['.$hrownum.']" value="'.$hpersonId.'">';
		
  		echo '<select name="hhrelationship['.$hrownum.']">';
 		echo '<option selected value="'.$hhouseholdid.'" >'.$hhouseholdid.'</option>';
// 		echo '<option selected value="'.$householdid.'" >'.$crossrelationship.'</option>';
 
  			$relationship_all = pg_exec($db,"SELECT householdid as relationship from household order by householdid limit ".$hhcount); 
			$rownum = 0;
				while ($relationship_row = pg_fetch_array($relationship_all, $rownum)) {
  					$item_description = $relationship_row["relationship"];
  					$item_cd = $relationship_row["relationship"];
					$rownum = $rownum + 1;
  					echo "<option value='$item_cd'>$item_description</option>";
  				}
  		echo "</select>";

		echo "</td></tr>";
		$hrownum = $hrownum + 1;
	}
		echo "<tr><td>";
		echo "Person:</td><td><input class=asLabel type=text id=currentperson name=currentperson readonly></td>";
		echo '<td id="hhlabeldiv" style="display:none">Household</td><td id="householddiv" style="display:none">';
                echo '<input type="hidden" name="hhpersonid['.($hrownum).']" value="99999">';
  		echo '<select name="hhrelationship['.($hrownum).']">';
 		echo '<option value="'.$hhrelationship.'" >'.$hhrelationship.'</option>';
 
  			$relationship_all = pg_exec($db,"SELECT householdid as relationship from household order by householdid limit ".$hhcount); 
			$rownum = 0;
				while ($relationship_row = pg_fetch_array($relationship_all, $rownum)) {
  					$item_description = $relationship_row["relationship"];
  					$item_cd = $relationship_row["relationship"];
					$rownum = $rownum + 1;
  					echo "<option value='$item_cd'>$item_description</option>";
  				}
  		echo "</select>";
		echo "</td></tr>";


    echo '<tr><td align=center colspan=2><b>---------------</b></td><td align=left colspan=2>------------------------------</td></tr>';


}
		echo "<tr><td colspan=2>";
		echo "Person:</td><td>Tax Return</td><td>Filer Type</td</tr>";
  	$taxsql = "SELECT ap.applid, ap.personid, p.personfirstname||' '||p.personlastname, at.tax_no, at.filer_type  from person p, application_person ap  left outer join application_tax at on ap.applid = at.applid and ap.personid = at.personid WHERE ap.personid = p.personid and ap.applId = '".$applId."' order by 3";
	
	$taxresult = execSql($db, $taxsql, $debug) ;
	$taxrows = pg_num_rows($taxresult) ;
        $trownum = 0;
        while($trow = pg_fetch_array($taxresult, $trownum)) {
        	list ($tapplid, $tpersonId, $tapplname, $ttax_no, $tfiler_type) = pg_fetch_row($taxresult, $trownum);
		echo '<tr><td colspan=2>'.$tapplname.'</td>';

		echo '<td>';
                echo '<select name="taxreturn['.($trownum).']">';
 		echo '<option value="'.$ttax_no.'" >Tax Return: '.$ttax_no.'</option>';
                for ($j = 1; $j <= ($taxrows + 1); $j++) {
                       echo "<option value='".$j."'>Tax Return: ".$j."</option>";
                }
                echo "</select>";
                echo "</td><td>";

                echo '<input type="hidden" name="taxpersonid['.$trownum.']" value="'.$tpersonId.'">';
		
  		echo '<select name="taxfilertype['.$trownum.']">';
 		echo '<option value="'.$tfiler_type.'" >'.(substr($tfiler_type,0,-1)).'</option>';
 
  			$filer_type_all = pg_exec($db,"SELECT item_cd, item_description from app_lookup where lookup_table = 'application_tax' and lookup_field = 'filer_type' order by sort_order "); 
			$rownum = 0;
				while ($filer_type_row = pg_fetch_array($filer_type_all, $rownum)) {
  					$item_description = $filer_type_row["item_description"];
  					$item_cd = $relationship_row["item_cd"];
					$rownum = $rownum + 1;
  					echo "<option value='".$item_cd."'>$item_description</option>";
  				}
  		echo "</select>";
		echo "</td></tr>";
		$trownum = $trownum + 1;
	}
		
		echo "<tr>";
		echo "<td colspan=2><input class=asLabel type=text id=currenttaxperson name=currenttaxperson readonly></td>";
		echo '<td id="taxreturndiv" style="display:none">';
  		echo '<select name="taxreturn['.($trownum).']">';
 		echo '<option value="'.$taxrelationship.'" >'.$taxrelationship.'</option>';
		for ($j = 1; $j <= ($taxrows + 1); $j++) {
                       echo "<option value='".$j."'>Tax Return: ".$j."</option>";
		}	
  		echo "</select>";
		echo '</td><td id="filertypediv" style="display:none">';

                echo '<input type="hidden" name="taxpersonid['.($trownum).']" value="99999">';
  		echo '<select name="taxfilertype['.($trownum).']">';
 		echo '<option value="'.$taxrelationship.'" >'.$taxrelationship.'</option>';
                        $filer_type_all = pg_exec($db,"SELECT item_cd, item_description from app_lookup where lookup_table = 'application_tax' and lookup_field = 'filer_type' order by sort_order ");
                        $rownum = 0;
                                while ($filer_type_row = pg_fetch_array($filer_type_all, $rownum)) {
                                        $item_description = $filer_type_row["item_description"];
                                        $item_cd = $filer_type_row["item_cd"];
                                        $rownum = $rownum + 1;
                                        echo "<option value='$item_cd'>$item_description</option>";
                                }
 
  		echo "</select>";
		echo "</td></tr>";
?>

    <tr>
    <td colspan=1><input class="gray" type="Submit" name="formsubmit" value="Submit" onclick="return ValidateForm()"></td>
              <td><input class="gray" type="Submit" id="formevaluate" name="formevaluate" value="Evaluate" ></td></tr>
</table>
    </p>
  </form>
</blockquote>
<?

include "inc/footer_inc.php";
?>
</body>
</HTML>
