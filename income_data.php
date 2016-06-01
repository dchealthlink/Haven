<?php 
session_start();
include ('inc/dbconnect.php');
$applid = $_GET['aId'];
$personid = $_GET['pId'];

if ($formSubmit) {

    foreach($_POST as $prop1 => $value1) {

        if ($value1) {
            switch ($prop1) {
                case 'applid':
                    $applid = $value1;
                    break;
                case 'personid':
                    $personid = $value1;
                    break;
                case 'formSubmit':
                case 'totalIncome':
                    break;
                default:

                    $presql = "SELECT count(*) from application_1040 WHERE applid = '".$_POST['applid']."' AND personid = ".$_POST['personid']." AND type_iteration = 0 and type_1040 = '".$prop1."'";
                    $preresult = pg_exec($db, $presql);
                    list($rowcount) = pg_fetch_row($preresult,0) ;
                    if ($rowcount > 0) {
                        $modsql = "UPDATE application_1040 SET amount = ".$value1." WHERE applid = '".$_POST['applid']."' AND personid = ".$_POST['personid']." AND type_iteration = 0 and type_1040 = '".$prop1."'";
                    } else {
                        $modsql = "INSERT INTO application_1040 (applid, personid, type_1040, type_iteration, wage_type, amount) values ('".$_POST['applid']."','".$_POST['personid']."','".$prop1."',0,null,'".$value1."')";
                    }
                    $result = pg_exec($db, $modsql);
                 }
            }
    }

?>
<script>
    window.close();
</script>
<?php
}

    $sql = "SELECT type_1040.line_number, type_1040.type_1040, type_1040.type_1040_desc, application_1040.amount FROM type_1040 LEFT OUTER JOIN application_1040 ON type_1040.type_1040 = application_1040.type_1040 and application_1040.applid = '".$applid."' and application_1040.personid = ".$personid." WHERE type_1040.income_adjust = 'I' order by type_1040.sort_order " ;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd"> 
<html> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"> 
<title>Adjustments</title> 

<style type="text/css"> 
<!-- 
body { 
    font-family: Arial, Helvetica, sans-serif; 
    text-align:center; 
} 
p { 
    font-size: 14px; 
    line-height: 20px; 
} 
#main { 
    width:850px; 
    margin:0 auto; 
    padding:10px; 
    text-align:left; 
    border: 1px solid #000000; 
} 
--> 
</style> 
<script language = "Javascript">
function calculate_income() {

var f7 = document.getElementById("f7");
var f8a = document.getElementById("f8a");
var f8b = document.getElementById("f8b");
var f9a = document.getElementById("f9a");
var f10 = document.getElementById("f10");
var f11 = document.getElementById("f11");
var f12 = document.getElementById("f12");
var f13 = document.getElementById("f13");
var f14 = document.getElementById("f14");
var f15b = document.getElementById("f15b");
var f16b = document.getElementById("f16b");
var f17 = document.getElementById("f17");
var f18 = document.getElementById("f18");
var f19 = document.getElementById("f19");
var f20a = document.getElementById("f20a");
var f20b = document.getElementById("f20b");
var f21 = document.getElementById("f21");
var f22 = document.getElementById("totalIncome");

f22.value = parseInt(f7.value || "0" ) + parseInt(f8a.value  || "0" )  + parseInt(f8b.value  || "0" )   + parseInt(f9a.value || "0" ) + parseInt(f10.value || "0" ) + parseInt(f11.value || "0" ) + parseInt(f12.value || "0" ) + parseInt(f13.value || "0" ) + parseInt(f14.value || "0" ) + parseInt(f15b.value || "0" ) + parseInt(f16b.value || "0" ) + parseInt(f17.value || "0" ) + parseInt(f18.value || "0" ) + parseInt(f19.value || "0" )  + parseInt(f20a.value || "0" )   + parseInt(f20b.value || "0" ) + parseInt(f21.value || "0" )         ;  

 window.opener.mainform.Wages.value=(parseInt(f7.value) || "0");
 window.opener.mainform.monthlyWages.value=  ((parseInt(f7.value || "0"))/12).toFixed(2);

 window.opener.mainform.TaxableInterest.value=(parseInt(f8a.value) || "0");
 window.opener.mainform.monthlyTaxableInterest.value=  ((parseInt(f8a.value || "0"))/12).toFixed(2);

 window.opener.mainform.PensionAnnuities.value= parseInt(f9a.value || "0") + parseInt(f13.value || "0") + parseInt(f15b.value || "0") + parseInt(f16b.value || "0")  + parseInt(f20a.value || "0")   + parseInt(f20b.value || "0");
 window.opener.mainform.monthlyPensionAnnuities.value=  ((parseInt(f9a.value || "0") + parseInt(f13.value || "0") + parseInt(f15b.value || "0") + parseInt(f16b.value || "0")   + parseInt(f20a.value || "0")  + parseInt(f20b.value || "0"))/12).toFixed(2);

 window.opener.mainform.TaxExemptInterest.value=(parseInt(f8b.value) || "0");
 window.opener.mainform.monthlyTaxExemptInterest.value= ( (parseInt(f8b.value || "0"))/12).toFixed(2);

 window.opener.mainform.FarmIncome.value=(parseInt(f18.value) || "0");
 window.opener.mainform.monthlyFarmIncome.value= ( (parseInt(f18.value || "0"))/12).toFixed(2);

 window.opener.mainform.TaxRefunds.value=(parseInt(f10.value) || "0");
 window.opener.mainform.monthlyTaxRefunds.value=  ((parseInt(f10.value || "0"))/12).toFixed(2);

 window.opener.mainform.UnemployIncome.value=(parseInt(f19.value) || "0");
 window.opener.mainform.monthlyUnemployIncome.value= ( (parseInt(f19.value || "0"))/12).toFixed(2);

 window.opener.mainform.Alimony.value=(parseInt(f11.value) || "0");
 window.opener.mainform.monthlyAlimony.value=  ((parseInt(f11.value || "0"))/12).toFixed(2);

 window.opener.mainform.OtherIncome.value= parseInt(f12.value || "0") + parseInt(f14.value || "0") + parseInt(f17.value || "0") + parseInt(f21.value || "0");
 window.opener.mainform.monthlyOtherIncome.value=  ((parseInt(f12.value || "0") + parseInt(f14.value || "0") + parseInt(f17.value || "0") + parseInt(f21.value || "0"))/12).toFixed(2);


}
</script>
</head> 

<body> 
<!-- <body onLoad="javascript:window.resizeTo(425,400);return false;">  -->
<div id="main"> 
  <h2 style="text-align:center;margin-top:10px;">Income</h2> 

Adjusted Gross Income
<br><br>
 <form name="mainform" method="post" action="<?php echo $PHP_SELF ?>" >

<table bgcolor="#DCDCDC">


<?
$result = pg_exec($db, $sql) ;
$rownum = 0;
while ($row = pg_fetch_array($result,$rownum)) {
    list($lineno, $type1040, $type1040desc, $amt) = pg_fetch_row($result, $rownum) ;
    echo '<tr><td>'.$lineno.'</td><td>'.$type1040desc.':</td><td>'.$lineno.'</td><td> <input type="text" id="f'.$lineno.'" name="'.$type1040.'" size="6" value="'.(number_format($amt,0)).'" onchange="calculate_income();"> </td> <td>&nbsp;</td> ';
    $rownum = $rownum + 1;
}

?>

<tr><td>22</td><td><b>Total Income:</b></td><td>22</td><td> <input type="text" id="totalIncome" name="totalIncome" readonly size="6" > </td> <td>&nbsp;</td>
</tr>

</table>
<br>
<input class="gray" type="SUBMIT" name="formSubmit" value="submit" >&nbsp;
<input type="hidden" name="applid" value="<?php echo $applid ?>" >
<input type="hidden" name="personid" value="<?php echo $personid ?>" >



</div>   
<br><br>
<input class="gray" type="Button" name="WINDOWCLOSE" value="Window Close" onclick="javascript:window.close()">&nbsp;
</form>
</body> 
</html> 
