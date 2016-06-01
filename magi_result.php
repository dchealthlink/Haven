<?php
session_start();
include("inc/dbconnect.php");


// if ($formsubmit) {

        $presql = 'SELECT count(*) from application WHERE applId = '.$_POST['applId'];
        $preresult = execSql($db,$presql,$debug) ;
        list($precount) = pg_fetch_row($preresult,0);

        if ($precount == 0) {

                $sql = "INSERT into application (applId, stateCd, appYear, name, postDate, status, statustimestamp) values (".$_POST['applId'].",'".$_POST['stateCd']."','".$_POST['appYear']."','".$_POST['applName']."', now()::date, 'P', now() ) ";
                $result = execSql($db,$sql,$debug) ;

        }

        $pcsql = "SELECT personid from person WHERE personssn = ('".$_POST['applSSN']."') or (upper(personfirstname) = upper('".$_POST['firstName']."') and personlastname = upper('".$_POST['lastName']."') and persondob = '".$_POST['applDOB']."')";
        $pcresult = execSql($db,$pcsql,$debug) ;
        list($perid) = pg_fetch_row($pcresult,0);

	if (!$perid) {

        	$presql = "SELECT coalesce(max(personid) + 1,1000000) as nextid from person ";
        	$preresult = execSql($db,$presql,$debug) ;
        	list($nextid) = pg_fetch_row($preresult,0);

                $sql = "INSERT into person (personid, personfirstname, personlastname, persondob, personssn) values (".$nextid.",upper('".$_POST['firstName']."'),upper('".$_POST['lastName']."'),'".$_POST['applDOB']."', '".$_POST['applSSN']."') ";
                $result = execSql($db,$sql,$debug) ;
		$perid = $nextid;

        }




//         $sql = "INSERT into application_person (applId, personId, isApplicant, applAge, hrsWorked, isDisabled, isSTudent, isMedicareEntitled, isStateResident, isLTCAttest, isOtherClaimed, isInsured, isPriorInsured, isPublicEmpBenefit, isFormerFoster, isPregnant, isLast3Pregnant, isUSCitizen, isIncarcerated, isTaxRequired, monthlyWages, Wages, monthlyTaxableInterest, TaxableInterest, monthlyPensionAnnuities, PensionAnnuities, monthlyTaxExemptInterest, TaxExemptInterest, monthlyFarmIncome, FarmIncome, monthlyTaxRefunds, TaxRefunds, monthlyUnemployIncome, UnemployIncome, monthlyAlimony, Alimony, monthlyOtherIncome, OtherIncome, monthlyMagiDeductions, MagiDeductions, numChildren ) values (";
        $sql = "insert into application_person (applId, personId, isApplicant, applName, applAge, hrsWorked, isDisabled, isSTudent, isMedicareEntitled, isStateResident, isLTCAttest, isOtherClaimed, isInsured, isPriorInsured, isPublicEmpBenefit, isFormerFoster, isPregnant, isLast3Pregnant, isUSCitizen, isIncarcerated, isTaxRequired, monthlyWages, Wages, monthlyTaxableInterest, TaxableInterest, monthlyPensionAnnuities, PensionAnnuities, monthlyTaxExemptInterest, TaxExemptInterest, monthlyFarmIncome, FarmIncome, monthlyTaxRefunds, TaxRefunds, monthlyUnemployIncome, UnemployIncome, monthlyAlimony, Alimony, monthlyOtherIncome, OtherIncome, monthlyMagiDeductions, MagiDeductions, numchildren, isclaimedoos, priorinsuranceenddate, hadfostermedicaid, ageleftfoster, fosterstatecd, lawfullypresent, immigrationstatus, iseligible, amerasianstatus, vetstatus, traffickingvictim, immigrationdate, fiveyearbar, fiveyearbarmet, fortyquarters, immigrationdatetype  ) values (";

        $sql.= "".$_POST['applId'] .",";
        $sql.= "".$perid.",";
        $sql.= "'".$_POST['isApplicant']."',";
        $sql.= "'".$_POST['applName']."',";
        $sql.= "".$_POST['applAge'].",";
        $sql.= "".$_POST['hrsWorked'].",";
        $sql.= "'".$_POST['isDisabled']."',";
        $sql.= "'".$_POST['isStudent']."',";
        $sql.= "'".$_POST['isMedicareEntitled']."',";
        $sql.= "'".$_POST['isStateResident']."',";
        $sql.= "'".$_POST['isLTCAttest']."',";
        $sql.= "'".$_POST['isOtherClaimed']."',";
        $sql.= "'".$_POST['isInsured']."',";
        $sql.= "'".$_POST['isPriorInsured']."',";
        $sql.= "'".$_POST['isPublicEmpBenefit']."',";
        $sql.= "'".$_POST['isFormerFoster']."',";
        $sql.= "'".$_POST['isPregnant']."',";
        $sql.= "'".$_POST['isLast3Pregnant']."',";
        $sql.= "'".$_POST['isUSCitizen']."',";
        $sql.= "'".$_POST['isIncarcerated']."',";
        $sql.= "'".$_POST['isTaxRequired']."',";
        $sql.= "".($_POST['monthlyWages'] ? $_POST['monthlyWages']  : 0 ).",";
        $sql.= "".($_POST['Wages'] ? $_POST['Wages']  : 0).",";
        $sql.= "".($_POST['monthlyTaxableInterest'] ? $_POST['monthlyTaxableInterest']  : 0 ).",";

        $sql.= "".($_POST['TaxableInterest'] ?: 0 ).",";
        $sql.= "".($_POST['monthlyPensionAnnuities'] ?: 0 ).",";
        $sql.= "".($_POST['PensionAnnuites'] ?: 0 ).",";
        $sql.= "".($_POST['monthlyTaxExemptInterest'] ?: 0).",";
        $sql.= "".($_POST['TaxExemptInterest'] ?: 0).",";
        $sql.= "".($_POST['monthlyFarmIncome'] ?: 0).",";
        $sql.= "".($_POST['FarmIncome'] ?: 0).",";
        $sql.= "".($_POST['monthlyTaxRefunds'] ?: 0).",";
        $sql.= "".($_POST['TaxRefunds'] ?: 0).",";
        $sql.= "".($_POST['monthlyUnemployIncome'] ?: 0).",";
        $sql.= "".($_POST['UnemployIncome'] ?: 0).",";
        $sql.= "".($_POST['monthlyAlimony'] ?: 0).",";
        $sql.= "".($_POST['Alimony'] ?: 0).",";
        $sql.= "".($_POST['monthlyOtherIncome'] ?: 0).",";
        $sql.= "".($_POST['OtherIncome'] ?: 0).",";
        $sql.= "".($_POST['monthlyMagiDeductions'] ?: 0).",";

        $sql.= "".($_POST['MagiDeductions'] ?: 0 )." ,";
        $sql.= "'".($_POST['numChildren'])."' ,";
        $sql.= "'".$_POST['isClaimedOOS']."',";
        $sql.= "'".$_POST['priorInsuranceEndDate']."',";
        $sql.= "'".$_POST['hadFosterMedicaid']."',";
        $sql.= "'".$_POST['ageLeftFoster']."',";
        $sql.= "'".$_POST['fosterStateCd']."',";
        $sql.= "'".$_POST['lawfullyPresent']."',";
        $sql.= "'".$_POST['immigrationStatus']."',";
        $sql.= "'".$_POST['isEligible']."',";
        $sql.= "'".$_POST['amerasianStatus']."',";
        $sql.= "'".$_POST['vetStatus']."',";
        $sql.= "'".$_POST['traffickingVictim']."',";
        $sql.= "'".$_POST['immigrationDate']."',";
        $sql.= "'".$_POST['fiveYearBar']."',";
        $sql.= "'".$_POST['fiveYearBarMet']."',";
        $sql.= "'".$_POST['fortyQuarters']."',";
        $sql.= "'".$_POST['immigrationdatetype']."'";

        $sql.= " )";
        $sql=str_replace("'on'","'Y'",$sql);
        $sql=str_replace("''","null",$sql);

        $result = execSql($db,$sql,$debug) ;
// echo $sql."<br><br>";


        $relcount = count($crosspersonid) ;
	if ($relcount > 0) {

        for($j = 0; $j < $relcount;$j++) {
//                $relsql = "INSERT INTO application_relationship select '".$applId."', '".$crosspersonid[$j]."', relationship , null, '".$applPersonId."', cross_relationship, null  from relationship where relationship = '".$crossrelationship[$j]."'" ;
                $relsql = "INSERT INTO application_relationship select '".$applId."', '".$crosspersonid[$j]."', relationship , null, '".$perid."', cross_relationship, null  from relationship where relationship = '".$crossrelationship[$j]."'" ;
                $relresult = execSql($db,$relsql,$debug) ;
        }
	}
if ($formsubmit) {
// header("location: magi_c.php?applId=".$applId);


}





$show_menu="ON";

 include("inc/index_header_inc.php"); 
?>
<HTML>
<head>
<script language = "Javascript">
</script>
</head>
<tr><td>
  <blockquote>
   <h1>MAGI in the Cloud - POC <?php echo $rep_name ?></h1>
<br><a href="search_application_gen.php?appl_id=<?php echo $applId ?>">Review Application</a>

 <form name="mainform" method="post" action="magi_c.php">

	<table border=0 cellspacing=0 cellpadding=2 bordercolor=#eeeeee width=900> 

<?php


//  echo "<tr><td colspan=6><B>Additional Information:</B></td></tr>";
 echo "<tr><td colspan=6>&nbsp;</td></tr>";
?>

<br>

<?

if ($formevaluate) {
}




$jsonData = array(
    'State' => $_POST['stateCd'],
    'Application Year' => filter_input(INPUT_POST, 'appYear', FILTER_VALIDATE_INT) ,
    'Name' => $_POST['applName'],
    'People' => array ([
        'Is Applicant' => ($_POST['isApplicant']? 'Y' : 'N'),
        'Lives In State' => ($_POST['isStateResident'] ? 'Y' : 'N'),
        'Required to File Taxes' => ($_POST['isTaxRequired'] ? 'Y' : 'N'),
        'US Citizen Indicator' => ($_POST['isUSCitizen'] ? 'Y' : 'N'),
        'Applicant Age' => (int)$_POST['applAge'],
        'Hours Worked Per Week' => (int)$_POST['hrsWorked'],
        'Applicant Attest Blind or Disabled' => ($_POST['isDisabled']? 'Y' : 'N'),
        'Student Indicator' => ($_POST['isStudent']? 'Y' : 'N'),
        'Medicare Entitlement Indicator' => ($_POST['isMedicareEntitled']? 'Y' : 'N'),
        'Incarceration Status' => ($_POST['isIncarcerated']? 'Y' : 'N'),
        'Claimed as Dependent by Person Not on Application' => ($_POST['isOtherClaimed']? 'Y' : 'N'),
        'Applicant Attest Long Term Care' => ($_POST['isLTCAttest']? 'Y' : 'N'),
        'Has Insurance' => ($_POST['isInsured']? 'Y' : 'N'),
        'State Health Benefits Through Public Employee' => ($_POST['isPublicEmpBenefit']? 'Y' : 'N'),
        'Prior Insurance' => ($_POST['isPriorInsured']? 'Y' : 'N'),
        'Applicant Pregnant Indicator' => ($_POST['isPregnant']? 'Y' : 'N'),
        'Number of Children Expected' => ($_POST['isPregnant']? 1 : 0),
        'Applicant Post Partum Period Indicator' => ($_POST['isLast3Pregnant']? 'Y' : 'N'),
        'Former Foster Care' => ($_POST['isFormerFoster']? 'Y' : 'N'),
        'Applicant Age >= 90' => ($_POST['applAge'] >= 90 ? 'Y' : 'N'),
        'Person ID' => ( $perid ? (int)$perid : 0),
	'Claimer Is Out of State' => ($_POST['isClaimdeOOS']? 'Y' : 'N'),
	'Prior Insurance End Date' => ($_POST['priorInsuranceEndDate']),
	'Had Medicaid During Foster Care' => ($_POST['hadFosterMedicaid']? 'Y' : 'N'),
	'Age Left Foster Care' => (int)$_POST['ageLeftFoster'] ,
	'Foster Care State' => $_POST['fosterStateCd'] ,
        'Income' => array (
        	'Monthly Income' => 0,
        	'Wages, Salaries, Tips' => ( $_POST['Wages'] ? (int)$_POST['Wages'] : 0),
        	'Capital Gain or Loss' => ( $_POST['CapitalGainLoss'] ? (int)$_POST['CapitalGainLoss'] : 0),
        	'Taxable Interest' => ( $_POST['TaxableInterest'] ? (int)$_POST['TaxableInterest'] : 0),
        	'Pensions and Annuities Taxable Amount' => ( $_POST['PensionsAnnuities'] ? (int)$_POST['PensionAnnuities'] : 0),
        	'Tax-Exempt Interest' => ( $_POST['TaxExemptInterest'] ? (int)$_POST['TaxExemptInterest'] : 0),
        	'Farm Income or Loss' => ( $_POST['FarmIncome'] ? (int)$_POST['FarmIncome'] : 0),
        	'Taxable Refunds, Credits, or Offsets of State and Local Income Taxes' => ( $_POST['TaxRefunds'] ? (int)$_POST['TaxRefunds'] : 0),
        	'Unemployment Compensation' => ( $_POST['UnemployIncome'] ? (int)$_POST['UnemployIncome'] : 0),
        	'Alimony' => ( $_POST['Alimony'] ? (int)$_POST['Alimony'] : 0),
        	'Other Income' => ( $_POST['OtherIncome'] ? (int)$_POST['OtherIncome'] : 0),
        	'MAGI Deductions' => ( $_POST['MagiDeductions'] ? (int)$_POST['MagiDeductions'] : 0)

                ),
	'Lawful Presence Attested' => ($_POST['lawfullyPresent']? 'Y' : 'N'),
	'Immigration Status' => ($_POST['immigrationStatus']),
	'Refugee Status' => ($_POST['isEligible']? 'Y' : 'N'),
	'Amerasian Immigrant' => ($_POST['amerasianStatus']? 'Y' : 'N'),
	'Veteran Status' => ($_POST['vetStatus']? 'Y' : 'N'),
	'Victim of Trafficking' => ($_POST['traffickingVictim']? 'Y' : 'N'),
	'Seven Year Limit Start Date' => $_POST['immigrationDate'],
	'Five Year Bar Applies' => ($_POST['fiveYearBar']? 'Y' : 'N'),
	'Five Year Bar Met' => ($_POST['fiveYearBarMet']? 'Y' : 'N'),
	'Applicant Has 40 Title II Work Quarters' => ($_POST['fortyQuarters']? 'Y' : 'N'),
        'Relationships' => []
  ]),
    'Physical Households' => array ([
        'Household ID' => 'Household1',
        'People' => array ([
                'Person ID' => ( $_POST['applPersonId'] ? (int)$_POST['applPersonId'] : 0) ] ) ])        ,
    'Tax Returns' => array([
                'Filers' => [],
                'Dependents' => []] )
);


$datastring = json_encode($jsonData);
 print_r($jsonData);
 echo "<br>";
 echo "<br>ds ====>       ".$datastring."<br><br>";

 $ch = curl_init('http://54.166.30.111/determinations/eval');
// $ch = curl_init('http://10.4.64.151:3000');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
// curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $datastring);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Accept: application/json',
    'Content-Length: ' . strlen($datastring))
);

$result = curl_exec($ch);

// echo "<br><br>".$result."<br><br>";

$deresult = json_decode($result,true) ;

foreach($deresult as $prop => $value) {
        if ( is_array($value)) {
                echo "<br><br> Level0: ".$prop." ==> ";
                foreach($value as $prop1 => $value1) {
                        if ( is_array($value1)) {
                        echo "<br><br>Level1:".$prop1." ==> ";
                                foreach($value1 as $prop2 => $value2) {
                                        if (is_array($value2) ) {
                                        echo "<br><br>Level2: ".$prop2." ==> ";
                                                foreach($value2 as $prop3 => $value3) {
                                                        if (is_array($value3) ) {
                                                        echo "<br><br>Level3: ".$prop3." ==>";
								$fldarray = 'applId, personId,'.$prop2.',';
								$dataarray = "'".$_POST['applId']."','".$personID."','".$prop3."',";
                                                                foreach($value3 as $prop4 => $value4) {
									$fldarray.= str_replace(" ","",$prop4).',' ;
									$dataarray.= "'".$value4."',";
                                                                        echo '<br>'.$prop4.' : '.$value4;
                                                                }
								if (stristr($fldarray,'Determinations')) {
									$exsql = 'insert into application_determination ('.substr($fldarray,0,-1).') VALUES ('.substr($dataarray,0,-1).')';
									$exresult = execSql($db, $exsql, $debug) ;
//									echo '<br>'.$exsql.'<br>';
								}
								
                                                        } else {
								$prop2x = $prop2;
                                                                echo '<br>Level3a: '.$prop3.' : '.$value3;
                                                		$l3asql = "INSERT INTO application_result values ( '".$_POST['applId']."','".$personID."','".$prop2."', '".$prop3."' , '".$value3."')";
						$exresult = execSql($db, $l3asql, $debug) ;
                                                        }
                                                }
                                        } else {
                                                echo '<br>Level2a: '.$prop2.' : '.$value2;
                                                $l2asql = "INSERT INTO application_result values ( '".$_POST['applId']."','".$personID."','".$prop2x."', '".$prop2."' , '".$value2."')";
						$exresult = execSql($db, $l2asql, $debug) ;
						if ($prop2 == 'Person ID') {
							$personID = $value2 ;
						}
                                        }
                                }
                        } else {
                                echo '<br>Level1a: '.$prop1.' : '.$value1;
                        }
                }
        } else {
                echo '<br/>Level0a: '. $prop .' : '. $value;
        }
}


?>




    <tr><td align=center colspan=2><b>---------------</a></b></td><td align=left colspan=2>------------------------------</td></tr>


    <tr>
    <td colspan=2><input class="gray" type="Submit" name="formreturn" value="return"></td></tr>
</table>
    </p>
  </form>
</blockquote>
<?

include "inc/footer_inc.php";
?>
</body>
</HTML>
