<?php
session_start();
include("inc/dbconnect.php");

if ($formevaluate) {
  	header("location: magi_gen_array.php?applId=".$applId);
	exit;
}

if ($formsubmit) {

	$presql = 'SELECT count(*) from application WHERE applId = '.$_POST['applId'];
	$preresult = execSql($db,$presql,$debug) ;
	list($precount) = pg_fetch_row($preresult,0);

	if ($precount == 0) {

		$sql = "INSERT into application (applId, stateCd, appYear, name, postDate, status, statustimestamp, appaddressstreet, appaddresscity, appaddressstate) values (".$_POST['applId'].",'".$_POST['stateCd']."','".$_POST['appYear']."','".$_POST['applName']."', now()::date, 'P', now(), upper('".$_POST['addressStreet']."'), upper('".$_POST['addressCity']."'), '".$_POST['addressState']."'  ) ";
		$result = execSql($db,$sql,$debug) ;

	}

/*
        $pcsql = "SELECT personid from person WHERE personssn = ('".$_POST['applSSN']."') or (upper(personfirstname) = upper('".$_POST['firstName']."') and personlastname = upper('".$_POST['lastName']."') and persondob = '".$_POST['applDOB']."')";
        $pcresult = execSql($db,$pcsql,$debug) ;
        list($perid) = pg_fetch_row($pcresult,0);

        if (!$perid) {
*/
                $presql = "SELECT coalesce(max(personid) + 1,1000000) as nextid from person ";
                $preresult = execSql($db,$presql,$debug) ;
                list($nextid) = pg_fetch_row($preresult,0);

                $sql = "INSERT into person (personid, personfirstname, personlastname, persondob, personssn) values (".$nextid.",upper('".$_POST['firstName']."'),upper('".$_POST['lastName']."'),'".$_POST['applDOB']."', '".$_POST['applSSN']."') ";
                $result = execSql($db,$sql,$debug) ;
		$perid = $nextid ;
//        }


	$sql = "INSERT into application_person (applId, personId, isApplicant, applName, applAge, hrsWorked, isDisabled, isSTudent, isMedicareEntitled, isStateResident, isLTCAttest, isOtherClaimed, isInsured, isPriorInsured, isPublicEmpBenefit, isFormerFoster, isPregnant, isLast3Pregnant, isUSCitizen, isIncarcerated, isTaxRequired, monthlyWages, Wages, monthlyTaxableInterest, TaxableInterest, monthlyPensionAnnuities, PensionAnnuities, monthlyTaxExemptInterest, TaxExemptInterest, monthlyFarmIncome, FarmIncome, monthlyTaxRefunds, TaxRefunds, monthlyUnemployIncome, UnemployIncome, monthlyAlimony, Alimony, monthlyOtherIncome, OtherIncome, monthlyMagiDeductions, MagiDeductions, numchildren, isclaimedoos, priorinsuranceenddate, hadfostermedicaid, ageleftfoster, fosterstatecd, lawfullypresent, immigrationstatus, iseligible, amerasianstatus, vetstatus, traffickingvictim, immigrationdate, fiveyearbar, fiveyearbarmet, fortyquarters, immigrationdatetype, istempoos, nofixedaddress, addressstreet, addresscity, addressstate  ) values (";
        $sql.= "".$_POST['applId'] .",";
//        $sql.= "".$_POST['personId'].",";
        $sql.= "".$perid.",";
        $sql.= "'".$_POST['isApplicant']."',";
        $sql.= "'".$_POST['applName']."',";
        $sql.= "".$_POST['applAge'].",";
        $sql.= "".$_POST['hrsWorked'].",";
        $sql.= "'".($_POST['isDisabled'] ?: 'N') ."',";
        $sql.= "'".($_POST['isStudent'] ?: 'N') ."',";
        $sql.= "'".($_POST['isMedicareEntitled'] ?: 'N') ."',";
        $sql.= "'".($_POST['isStateResident'] ?: 'N') ."',";
        $sql.= "'".($_POST['isLTCAttest'] ?: 'N') ."',";
        $sql.= "'".($_POST['isOtherClaimed'] ?: 'N') ."',";
        $sql.= "'".($_POST['isInsured'] ?: 'N') ."',";
        $sql.= "'".($_POST['isPriorInsured'] ?: 'N') ."',";
        $sql.= "'".($_POST['isPublicEmpBenefit'] ?: 'N') ."',";
        $sql.= "'".($_POST['isFormerFoster'] ?: 'N') ."',";
        $sql.= "'".($_POST['isPregnant'] ?: 'N') ."',";
        $sql.= "'".($_POST['isLast3Pregnant'] ?: 'N') ."',";
        $sql.= "'".($_POST['isUSCitizen'] ?: 'N') ."',";
        $sql.= "'".($_POST['isIncarcerated'] ?: 'N') ."',";
        $sql.= "'".($_POST['isTaxRequired'] ?: 'N') ."',";
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
        $sql.= "'".($_POST['isPregnant'] == 'Y' ?  $_POST['numChildren'] : '' )."' ,";
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
        $sql.= "'".$_POST['immigrationdatetype']."',";
        $sql.= "'".$_POST['isTempOOS']."',";
        $sql.= "'".$_POST['noFixedAddress']."',";
        $sql.= "upper('".$_POST['addressStreet']."'),";
        $sql.= "upper('".$_POST['addressCity']."'),";
        $sql.= "'".$_POST['addressState']."'";

        $sql.= " )";
	$sql=str_replace("'on'","'Y'",$sql);
	$sql=str_replace("''","null",$sql);
	$result = execSql($db,$sql,$debug) ;

	for($j = 0; $j < count($crosspersonid)  ;$j++) {
		$relsql = "INSERT INTO application_relationship select '".$applId."', '".$crosspersonid[$j]."', relationship , null, '".$perid."', cross_relationship, null  from relationship where relationship =  '".$crossrelationship[$j]."'" ;
		if ($crosspersonid[$j]) {
			$relresult = execSql($db,$relsql,$debug) ;
		}
	}

	for($j = 0; $j < count($hhpersonid) ;$j++) {
		if ($hhpersonid[$j] == '99999') {
			$hhchecksql = "SELECT count(*) FROM application_household WHERE applid = '".$applId."' AND  personid = '".$perid."'";
			$hhcheckresult = execSql($db, $hhchecksql, $debug) ;
			list ($hhcheckcount) = pg_fetch_row($hhcheckresult,0);
			if ($hhcheckcount > 0) {
				$hhsql = "UPDATE application_household values set householdid = '".$hhrelationship[$j]."' WHERE applid =  '".$applId."' and personid = '".$perid."'" ;
			} else {
				$hhsql = "INSERT INTO application_household values ( '".$applId."', '".$perid."','".$hhrelationship[$j]."')" ;
			}
		} else {
			$hhchecksql = "SELECT count(*) FROM application_household WHERE applid = '".$applId."' AND  personid = '".$hhpersonid[$j]."'";
			$hhcheckresult = execSql($db, $hhchecksql, $debug) ;
			list ($hhcheckcount) = pg_fetch_row($hhcheckresult,0);
			if ($hhcheckcount > 0) {
				$hhsql = "UPDATE application_household values set householdid = '".$hhrelationship[$j]."' WHERE applid =  '".$applId."' and personid = '".$hhpersonid[$j]."'" ;
			} else {
				$hhsql = "INSERT INTO application_household values ( '".$applId."', '".$hhpersonid[$j]."','".$hhrelationship[$j]."')" ;
			}
		}
		if ($hhrelationship[$j]) {
			$hhresult = execSql($db,$hhsql,$debug) ;
		}
	}
	for($j = 0; $j < count($taxpersonid) ;$j++) { 
		if ($taxpersonid[$j] == '99999') {
			$checkperid = $perid;
		} else {
			$checkperid = $taxpersonid[$j];
		}
			$tchecksql = "SELECT count(*) FROM application_tax WHERE applid = '".$applId."' AND  personid = '".$checkperid."'";
			$tcheckresult = execSql($db, $tchecksql, $debug) ;
			list ($tcheckcount) = pg_fetch_row($tcheckresult,0);
			if ($tcheckcount > 0) {
				$taxsql = "UPDATE application_tax values set tax_no = '".$taxreturn[$j]."', filer_type = '".$taxfilertype[$j]."' WHERE applid =  '".$applId."' and personid = '".$checkperid."'" ;
			} else {
				$taxsql = "INSERT INTO application_tax values ( '".$applId."', ".$taxreturn[$j].",'".$taxfilertype[$j]."','".$checkperid."')" ;
			}
		
		if ($taxfilertype[$j]) {
			$taxresult = execSql($db,$taxsql,$debug) ;
		}
	}

}

header("location: magi_c.php?applId=".$applId);






?>

