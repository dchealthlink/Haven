<?php
session_start();
include("inc/dbconnect.php");

if ($formsubmit) {

	$presql = 'SELECT count(*) from application WHERE applId = '.$_POST['applId'];
	$preresult = execSql($db,$presql,$debug) ;
	list($precount) = pg_fetch_row($preresult,0);

	if ($precount == 0) {

		$sql = "INSERT into application (applId, stateCd, appYear, name, postDate, status, statustimestamp) values (".$_POST['applId'].",'DC','".$_POST['requestYear']."','".$_POST['applName']."', now()::date, 'P', now()  ) ";
		$result = execSql($db,$sql,$debug) ;

	}


for ($i = 0; $i < count($_POST['aptc_array']); $i++) {


// from magi_add
                $presql = "SELECT coalesce(max(personid) + 1,1000000) as nextid from person ";
                $preresult = execSql($db,$presql,$debug) ;
                list($nextid) = pg_fetch_row($preresult,0);

                $sql = "INSERT into person (personid, personfirstname, personlastname, persondob, personssn) values (".$nextid.",upper('".(substr($aptc_array[$i][0],0,strripos($aptc_array[$i][0],' ')  ))."'),upper('".(substr($aptc_array[$i][0],strripos($aptc_array[$i][0],' ') + 1 ))."'),'".$aptc_array[$i][1]."', null ) ";
                $result = execSql($db,$sql,$debug) ;
                $newi = $nextid ;
		$temprelarray[$i] = $newi ;

	$sql = "INSERT into application_person (applId, personId, isApplicant, applName, applAge, hrsWorked, isDisabled, isSTudent, isMedicareEntitled, isStateResident, isLTCAttest, isOtherClaimed, isInsured, isPriorInsured, isPublicEmpBenefit, isFormerFoster, isPregnant, isLast3Pregnant, isUSCitizen, isIncarcerated, isTaxRequired, monthlyWages, Wages, monthlyTaxableInterest, TaxableInterest, monthlyPensionAnnuities, PensionAnnuities, monthlyTaxExemptInterest, TaxExemptInterest, monthlyFarmIncome, FarmIncome, monthlyTaxRefunds, TaxRefunds, monthlyUnemployIncome, UnemployIncome, monthlyAlimony, Alimony, monthlyOtherIncome, OtherIncome, monthlyMagiDeductions, MagiDeductions, numchildren, isclaimedoos, priorinsuranceenddate, hadfostermedicaid, ageleftfoster, fosterstatecd, lawfullypresent, immigrationstatus, iseligible, amerasianstatus, vetstatus, traffickingvictim, immigrationdate, fiveyearbar, fiveyearbarmet, fortyquarters, immigrationdatetype  ) values (";
        $sql.= "".$_POST['applId'] .",";
        $sql.= "".$newi.",";
        $sql.= "'Y',";
//        $sql.= "'".$aptc_array[$i][0]."',";
        $sql.= "'".$_POST['applName']."',";
        $sql.= "'".$aptc_array[$i][2]."',";
        $sql.= "'".($aptc_array[$i][3] ?: 0) ."',";
        $sql.= "'".($_POST['isDisabled'] ?: 'N') ."',";
        $sql.= "'".($_POST['isStudent'] ?: 'N') ."',";
        $sql.= "'".($_POST['isMedicareEntitled'] ?: 'N') ."',";
        $sql.= "'".($_POST['isStateResident'] ?: 'Y') ."',";
        $sql.= "'".($_POST['isLTCAttest'] ?: 'N') ."',";
        $sql.= "'".($_POST['isOtherClaimed'] ?: 'N') ."',";
        $sql.= "'".($_POST['isInsured'] ?: 'N') ."',";
        $sql.= "'".($_POST['isPriorInsured'] ?: 'N') ."',";
        $sql.= "'".($_POST['isPublicEmpBenefit'] ?: 'N') ."',";
        $sql.= "'".($_POST['isFormerFoster'] ?: 'N') ."',";
        $sql.= "'".$aptc_array[$i][6]."',";
        $sql.= "'".($_POST['isLast3Pregnant'] ?: 'N') ."',";
        $sql.= "'".($_POST['isUSCitizen'] ?: 'Y') ."',";
        $sql.= "'".$aptc_array[$i][9]."',";
        $sql.= "'".($_POST['isTaxRequired'] ?: 'Y') ."',";
        $sql.= "".($_POST['monthlyWages'] ? $_POST['monthlyWages']  : 0 ).",";
        $sql.= "'".$aptc_array[$i][5]."',";
//        $sql.= "".$_POST['personId'].",";
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
        $sql.= "'".($aptc_array[$i][6] == 'Y' ?  $aptc_array[$i][7] : '' )."' ,";
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




	$sql = "INSERT INTO application_household values ('".$applId."','".$newi."','household1')";
	$result = execSql($db,$sql,$debug) ;

	$sql = "INSERT INTO application_tax values ('".$applId."','1','".$aptc_array[$i][8]."',".$newi.")";
	$result = execSql($db,$sql,$debug) ;
}

	for($j = 0; $j < count($relarray)  ;$j++) {
		$relsql = "INSERT INTO application_relationship select '".$applId."', '".$temprelarray[$relarray[$j][3]]."', relationship , null, '".$temprelarray[$relarray[$j][4]]."', cross_relationship, null  from relationship where relationship =  '".$relarray[$j][1]."'" ;
		if ($relarray[$j][0]) {
			$relresult = execSql($db,$relsql,$debug) ;
		}
	}

}

  	header("location: magi_gen_array.php?applId=".$applId);

?>

