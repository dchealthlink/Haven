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

    $sql = "SELECT type_1040.line_number, type_1040.type_1040, type_1040.type_1040_desc, application_1040.amount FROM type_1040 LEFT OUTER JOIN application_1040 ON type_1040.type_1040 = application_1040.type_1040 and application_1040.applid = '".$applid."' and application_1040.personid = ".$personid." WHERE type_1040.income_adjust = 'A' order by type_1040.sort_order " ;

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
    width:800px; 
    margin:0 auto; 
    padding:10px; 
    text-align:left; 
    border: 1px solid #000000; 
} 
--> 
</style> 
<script language = "Javascript">
function calculate_adjustments() {

    var f23 = document.getElementById("f23");
    var f24 = document.getElementById("f24");
    var f25 = document.getElementById("f25");
    var f26 = document.getElementById("f26");
    var f27 = document.getElementById("f27");
    var f28 = document.getElementById("f28");
    var f29 = document.getElementById("f29");
    var f30 = document.getElementById("f30");
    var f31a = document.getElementById("f31a");
    var f32 = document.getElementById("f32");
    var f33 = document.getElementById("f33");
    var f34 = document.getElementById("f34");
    var f35 = document.getElementById("f35");
    var f36 = document.getElementById("totalAdjustment");

    f36.value = parseInt(f23.value || "0" ) + parseInt(f24.value  || "0" ) + parseInt(f25.value || "0" ) + parseInt(f26.value || "0" ) + parseInt(f27.value || "0" ) + parseInt(f28.value || "0" ) + parseInt(f29.value || "0" ) + parseInt(f30.value || "0" ) + parseInt(f31a.value || "0" ) + parseInt(f32.value || "0" ) + parseInt(f33.value || "0" ) + parseInt(f34.value || "0" ) + parseInt(f35.value || "0" ) ;  

    window.opener.mainform.MagiDeductions.value=(parseInt(f36.value) || "0");
    window.opener.mainform.MagiDeductions.readOnly=true;

}
</script>
</head> 

<body> 
<!-- <body onLoad="javascript:window.resizeTo(425,400);return false;">  -->
<div id="main"> 
  <h2 style="text-align:center;margin-top:10px;">Adjustments</h2> 

Adjusted Gross Income
<br><br>

<form name="mainform" method="post" action="<?php echo $PHP_SELF ?>" >

<table bgcolor="#DCDCDC">


<?
$result = pg_exec($db, $sql) ;
$rownum = 0;
while ($row = pg_fetch_array($result,$rownum)) {
    list($lineno, $type1040, $type1040desc, $amt) = pg_fetch_row($result, $rownum) ;
    echo '<tr><td>'.$lineno.'</td><td>'.$type1040desc.':</td><td>'.$lineno.'</td><td> <input type="text" id="f'.$lineno.'" name="'.$type1040.'" value="'.$amt.'" size="6" onchange="calculate_adjustments();"> </td> <td>&nbsp;</td> ';
    $rownum = $rownum + 1;
}

?>
<tr><td>36</td><td><b>Total Adjustments:</b></td><td>36</td><td> <input type="text" id="totalAdjustment" name="totalAdjustment" readonly size="6" > </td> <td>&nbsp;</td>
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
