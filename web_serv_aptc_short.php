<?php
// include ("inc/gen_functions_inc_test.php");
$outfile = fopen("/tmp/ws_".(date('Y-m-d')).".out","a+");
/* require the user as the parameter */

$posts = array();

$postdata = file_get_contents("php://input");
fputs($outfile,date('Y-m-d h:i:s')." 2. -- ".$postdata."\n");

$deresult = json_decode($postdata,true) ;

foreach($deresult as $prop => $value) {
	$posts[$prop] = $value ;
}


if (intval($posts['user'])) {
//        $format = strtolower($_POST['responseFormat']) == 'json' ? 'json' : 'xml'; //xml is the default

        $db = pg_connect("host=localhost dbname=safehaven user=postgres") or die ("Unable to connect!");

//	$aquery = "SELECT fpl_100 FROM annual_fpl WHERE fpl_year in (select max(fpl_year) FROM annual_fpl) and tax_people =  ".$posts['householdSize']." limit 1" ;
	$aquery = "SELECT fpl_100 FROM annual_fpl WHERE fpl_year = '".$posts['requestYear']."' and tax_people =  ".$posts['householdSize']." limit 1" ;
fputs($outfile, "<==================================================================================================>\n");
fputs($outfile, $aquery."\n\n");
        $aresult = pg_exec($db, $aquery) ;
	list ($annual_fpl) = pg_fetch_array ($aresult, 0) ;

	$posts['Annual FPL'] = $annual_fpl;
	$tempfpl = intval(($posts['annualIncome'] / $annual_fpl) * 100) ;
	$posts['TempFPL'] = $tempfpl;


      //  $sql = "select (((".$tempfpl." - start_fpl) / var1) * var2) + var3 from annual_contribution where ".$tempfpl." between start_fpl and end_fpl and fpl_year in (select max(fpl_year) from annual_contribution) limit 1";
        $sql = "select (((".$tempfpl." - start_fpl) / var1) * var2) + var3 from annual_contribution where ".$tempfpl." between start_fpl and end_fpl and fpl_year = '".$posts['requestYear']."'  limit 1";
fputs($outfile, $sql."\n\n");

        $result = pg_exec($db, $sql);
        list($applicablePercentage) = pg_fetch_array($result,0);

	$posts['Expected Percentage'] = number_format($applicablePercentage,2) ;
	$expected_contribution = intval($posts['annualIncome'] * ( $applicablePercentage/100) ) ;
	$posts['Expected Contribution'] = $expected_contribution ;

	$posts['Monthly Premium'] = number_format($posts['annualBenchmark']/12,2);

	$aptc_amount = (($posts['annualBenchmark']) - $expected_contribution) / 12 ;
	$posts['Monthly APTC'] = $aptc_amount > 0 ? round($aptc_amount,2) : 0 ;

//	$aquery = "SELECT csr_per_cent FROM annual_csr WHERE csr_year in (select max(csr_year) from annual_csr) and ".$tempfpl." between start_fpl_level and end_fpl_level limit 1 " ;
	$aquery = "SELECT csr_per_cent FROM annual_csr WHERE csr_year = '".$posts['requestYear']."' and ".$tempfpl." between start_fpl_level and end_fpl_level limit 1 " ;
fputs($outfile, $aquery."\n");
fputs($outfile, "===================================================================================================>\n\n");
        $aresult = pg_exec($db, $aquery) ;
	list ($csr_per_cent) = pg_fetch_array ($aresult, 0) ;
	$posts['CSR Percent'] = $csr_per_cent;
	
	$format = $posts['responseFormat'];

        if($format == 'json') {
                header('Content-type: application/json');
                echo json_encode(array($posts));
                /* echo json_encode(array('posts'=>$posts));  */
        } else {
                header('Content-type: text/xml');
		$xoutput = '<posts>';
//                echo '<posts>';
		fputs($outfile,date('Y-m-d h:i:s')." <posts>\n");
                foreach($posts as $index => $post) {
                        fputs($outfile,"<".$index.">".htmlentities($post)."</".$index.">\n");
                        $xoutput.="<".$index.">".htmlentities($post)."</".$index.">";
                        if(is_array($post)) {
                                foreach($post as $key => $value) {
                                        echo '<'.$key.'>';
					fputs($outfile,"<".$key.">\n");
                                        if(is_array($value)) {
                                                foreach($value as $tag => $val) {
                                                        echo '<'.$tag.'>'.htmlentities($val).'</'.$tag.'>';
                                                }
                                        }
                                        echo '</'.$key.'>';
                                }
                        }
                }
                $xoutput.= '</posts>';
		fputs($outfile,date('Y-m-d h:i:s')." </posts>\n");
        }
		echo $xoutput;
        /* disconnect from the db */
        @pg_close($db);

}  else {
        echo "user name is ".$user."\n";
}
fclose($outfile);
?>

