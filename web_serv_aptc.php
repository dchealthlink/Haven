<?php
include ("inc/gen_functions_inc_test.php");
$outfile = fopen("/tmp/ws_".(date('Y-m-d')).".out","a+");
$db = pg_connect("host=localhost dbname=safehaven user=postgres") or die ("Unable to connect!");
/* require the user as the parameter */

        $posts = array();

$postdata = file_get_contents("php://input");
fputs($outfile,date('Y-m-d h:i:s')." 2. -- ".$postdata."\n\n");

$deresult = json_decode($postdata,true) ;
$posts = $deresult ;
	 
foreach($deresult as $prop => $value) {
	 echo $prop." -- ".$value."<br>";
	if (is_array($value) ) {
			$flds = "INSERT INTO tablename (applid,";
			$vals = ") values ( '".$applId."',";
		foreach($value as $prop1 => $value1) {
			if ($prop1 == 'householdSize') {
				$sql = " select a.tax_people, a.fpl_100, b.fpl_100 from annual_fpl a, annual_fpl b where a.tax_people = b.tax_people and (a.fpl_year = '2015' and b.fpl_year = '2014') and a.tax_people = ".$value1 ;
				echo $sql."<br><br>";
				$result = pg_exec($db, $sql);
				
				list ($we, $currfpl, $prevfpl) = pg_fetch_array($result,0);
				$flds.= "requestorMFPL,requestorAFPL,";
				$vals.= "'".$currfpl."','".$prevfpl."',";

			}
			$$prop1 = $value1 ;
			$flds.= $prop1.",";
			$vals.= "'".$value1."',";
		}
			if ($requestorAge >= 19 and $requestorAge <= 64 and $numberKids == 0) {
				$medicaidFpl = 215;
				$medicaidFplCategory = "Adults without Children Age 21 - 64";
			}
			if ($isParent == 'Y') {
				$medicaidFpl = 221;
				$medicaidFplCategory = "Parents and Caretaker Relatives";
			}
			if ($requestorAge == 19 or $requestorAge == 20) {
				$medicaidFpl = 221;
				$medicaidFplCategory = "Children Age 19-20";
			}
			if ($requestorAge < 19) {
				$medicaidFpl = 324;
				$medicaidFplCategory = "Children Under 19";
			}
			if ($isPregnant == 'Y') {
				$medicaidFpl = 324;
				$medicaidFplCategory = "Pregnant Women";
			}
			$aquery = "SELECT monthly_premium FROM annual_benchmark WHERE fpl_year = '2015' and ".$requestorAge." between start_age and end_age ";
		        $aresult = pg_exec($db, $aquery) ;
			list ($benchmarkAmount) = pg_fetch_array ($aresult, 0) ;
			$totalBenchmarkAmount = $totalBenchmarkAmount + $benchmarkAmount;


	$tempfpl = intval(($householdIncome / $prevfpl) * 100) ;
	echo "<br>hhI == ".$householdIncome." --- requestorAFPL == ".$prevfpl." --- tempfpl == ".$tempfpl."<br><br>";


	$sql = "select (((".$tempfpl." - start_fpl) / var1) * var2) + var3 from annual_contribution where ".$tempfpl." between start_fpl and end_fpl and fpl_year in (select max(fpl_year) from annual_contribution) limit 1";
	$result = pg_exec($db, $sql);
	list($applicablePercentage) = pg_fetch_array($result,0);
/*
			
	if ($tempfpl <= 133) {
		$applicablePercentage = 2.03;
	} elseif ( $tempfpl >= 133 and $tempfpl < 150) {
		$applicablePercentage = (($tempfpl - 133) / 17) + 3.05;
	} elseif ( $tempfpl >= 150 and $tempfpl < 200) {
		$applicablePercentage = (($tempfpl - 150) / 50) + 4.07;
	} elseif ( $tempfpl >= 200 and $tempfpl < 250) {
		$applicablePercentage = (($tempfpl - 150) / 50) + 6.41;
	} elseif ( $tempfpl >= 250 and $tempfpl < 300) {
		$applicablePercentage = (($tempfpl - 150) / 50) + 8.18;
	} else { 
		$applicablePercentage =  9.56;
	}
*/
		$applicableContribution = $householdIncome * ($applicablePercentage/100) ;
		$aptcAmount = ( $applicableContribution - ($benchmarkAmount)  ) ;
	
				$flds.= "eligibilityCategory,eligibilityFPL,benchmarkAmount,annualBenchmark,householdIncome,applicablePercentage,applicableContribution,aptcAmount";
				$vals.= "'".$medicaidFplCategory."','".$medicaidFpl."','".$benchmarkAmount."','".($benchmarkAmount * 12)."','".$householdIncome."','".$applicablePercentage."','".$applicableContribution."','".$aptcAmount."',";

	 		echo substr($flds,0,-1)." ".substr($vals,0,-1).")<br>";
	} else {
//	 echo $prop." -- ".$value."<br>";
	$$prop = $value;
	}
}

echo "<br><br>pct = ".$applicablePercentage." Household Income = ".$householdIncome."    and Total Benchmark = ".$totalBenchmarkAmount."    and applicable Contribution = ".$applicableContribution."<br><br>";


echo "<br><br><b>MONTHLY APTC == ".((($totalBenchmarkAmount * 12) - $applicableContribution) / 12)."</b><br><br>";


 if(isset($user) && intval($user)) {
//        $format = strtolower($_POST['responseFormat']) == 'json' ? 'json' : 'xml'; //xml is the default
        $user_id = $user; //no default



	$aquery = "SELECT fpl_100 FROM annual_fpl WHERE fpl_year = '2015' and tax_people =  ".$householdSize ;
        $aresult = pg_exec($db, $aquery) ;
	list ($annual_fpl) = pg_fetch_array ($aresult, 0) ;
	$posts['Annual FPL'] = $annual_fpl;
	$tempfpl = intval(($annualIncome / $annual_fpl) * 100) ;
	$posts['Temp FPL'] = $tempfpl;

/* ==================== medicaid fpl ============================ */
/*
	if ($age < 19) {
		$medicaidFpl = 324;
		$medicaidFplCategory = "Children Under 19";
	}
	if ($isPregnant == 'Y') {
		$medicaidFpl = 324;
		$medicaidFplCategory = "Pregnant Women";
	}
	if ($age == 19 or $age == 20) {
		$medicaidFpl = 221;
		$medicaidFplCategory = "Children Age 19-20";
	}
	if ($isParent == 'Y') {
		$medicaidFpl = 221;
		$medicaidFplCategory = "Parents and Caretaker Relatives";
	}
	if ($age >= 19 and $age <= 64 and $numberKids == 0) {
		$medicaidFpl = 215;
		$medicaidFplCategory = "Adults without Children Age 21 - 64";
	}
	if ($medicaidFpl) {
		$posts['Medicaid FPL'] = $medicaidFpl;
		$posts['Medicaid Eligibility Category'] = $medicaidFplCategory;
	}
*/
/* ==================== end medicaid fpl ============================ */

	$sql = "select (((".$tempfpl." - start_fpl) / var1) * var2) + var3 from annual_contribution where ".$tempfpl." between start_fpl and end_fpl and fpl_year in (select max(fpl_year) from annual_contribution) limit 1";
	echo $sql."<br>";
	$result = pg_exec($db, $sql);
	list($applicablePercentage) = pg_fetch_array($result,0);
/*
	if ($tempfpl <= 133) {
		$applicable_percentage = 2.03;
	} elseif ( $tempfpl >= 133 and $fpl < 150) {
		$applicable_percentage = (($tempfpl - 133) / 17) + 3.05;
	} elseif ( $tempfpl >= 150 and $fpl < 200) {
		$applicable_percentage = (($tempfpl - 150) / 50) + 4.07;
	} elseif ( $tempfpl >= 200 and $fpl < 250) {
		$applicable_percentage = (($tempfpl - 150) / 50) + 6.41;
	} elseif ( $tempfpl >= 250 and $fpl < 300) {
		$applicable_percentage = (($tempfpl - 150) / 50) + 8.18;
	} else { 
		$applicable_percentage =  9.66;
	}
*/
	$posts['Expected Percentage'] = $applicablePercentage ;
	$expected_contribution = intval($annualIncome * ( $applicablePercentage/100) ) ;
	$posts['Expected Contribution'] = $expected_contribution ;
/*
	$aquery = "SELECT monthly_premium FROM annual_benchmark WHERE fpl_year = '2015' and ".$age." between start_age and end_age ";
        $aresult = pg_exec($db, $aquery) ;
	list ($monthly_premium) = pg_fetch_array ($aresult, 0) ;
*/
	$monthly_premium = $monthlyBenchmark;
	$posts['Monthly Premium'] = $monthly_premium;

	$aptc_amount = (($monthly_premium * 12) - $expected_contribution) / 12 ;
	$posts['Monthly APTC'] = $aptc_amount > 0 ? round($aptc_amount,2) : 0 ;


	$checkfpl = intval(($annualIncome / $annual_fpl) * 100) ;
	$aquery = "SELECT csr_per_cent FROM annual_csr WHERE csr_year = '2015' and ".$checkfpl." between start_fpl_level and end_fpl_level " ;
        $aresult = pg_exec($db, $aquery) ;
	list ($csr_per_cent) = pg_fetch_array ($aresult, 0) ;
	$posts['CSR Percent'] = $csr_per_cent;
	$posts['Check FPL'] = $checkfpl;
	

        /* output in necessary format */
	$format = $responseFormat;

        if($format == 'json') {
                header('Content-type: application/json');
                echo json_encode(array($posts));
                /* echo json_encode(array('posts'=>$posts));  */
        }
        else {

                header('Content-type: text/xml');
                echo '<posts>';
                foreach($posts as $index => $post) {
                        if(is_array($post)) {
                                foreach($post as $key => $value) {
                                        echo '<',$key,'>';
                                        if(is_array($value)) {
                                                foreach($value as $tag => $val) {
                                                        echo '<',$tag,'>',htmlentities($val),'</',$tag,'>';
                                                }
                                        }
                                        echo '</',$key,'>';
                                }
                        }
                }
                echo '</posts>';

        }

        /* disconnect from the db */
        @pg_close($db);
 }  else {
        echo "user name is ".$user."\n";
/*
        echo "gotten user name is ".($_GET['user'])."\n";
        echo "gotten format is ".($_GET['format'])."\n";
*/
}
fclose($outfile);
?>

