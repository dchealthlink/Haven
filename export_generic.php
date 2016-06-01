<?php
include("inc/qdbconnect.php");

// $outfile = fopen("/tmp/single_appref_remainder_102415_323.txt","w") ;
// $outfile = fopen("/tmp/mult_appref_from_sarah_102415.txt","w") ;
//$outfile = fopen("/tmp/appref_from_sarah_102415_339.txt","w") ;
// $outfile = fopen("/tmp/PRODUCTION_AQHP_OCT242015_0810535_revised.txt","w") ;
// $outfile = fopen("/tmp/mult_appref_from_sarah_102415_with_vlp.txt","w") ;
// $outfile = fopen("/tmp/mult_appref_from_sarah_103015_with_vlp.txt","w") ;
// $outfile = fopen("/tmp/pranav_110515.txt","w") ;
// $outfile = fopen("/tmp/username_dedupe_110515.txt","w") ;
// $outfile = fopen("/tmp/enroll_pii_not_found_112415.txt","w") ;
// $outfile = fopen("/tmp/sarah_aptc_diff_122915.txt","w") ;
 $outfile = fopen("/tmp/curam_appref_income_092515.table","w") ;



$sql = "select distinct a.* from fordejavu_101715 a , single_appref_no_proj_assisted_102215 b where a.appref = b.appref and a.integratedcaseref = b.integratedcaseref  order by 1 limit 100 ";

$sql = "select a.* from fordejavu_101715 a, next100_102215 b where a.appref = b.appref and a.integratedcaseref = b.integratedcaseref order by 1 ";
$sql = "select distinct a.* from fordejavu_101715 a, master_list_for_preprod b where a.appref = b.appref and a.integratedcaseref = b.integratedcaseref and b.datasource = 'next_list_102315' ";
$sql = "select distinct a.* from fordejavu_101715 a, master_list_for_preprod b where a.appref = b.appref and a.integratedcaseref = b.integratedcaseref and b.datasource = 'next_list_102415' ";
$sql = "select distinct appref, integratedcaseref from next_list_102415_sarah order by 1";
$sql = "select distinct a.appref, a.integratedcaseref, a.firstname, a.lastname, a.aptc, a.lasthealthplan, a.nexthealthplan, a.nexthealthplanpremium, a.hpafterpremium, a.lastdentalplan, a.nextdentalplan, a.nextdentalplanpremium from enrollment_ic_appref_101715  a, next_list_102415_sarah b where a.appref = b.appref and a.integratedcaseref = b.integratedcaseref and not exists (select null from fordejavu_101715 c where a.appref = c.appref and a.integratedcaseref = c.integratedcaseref) order by  1,2";
$sql = "select * from fordejavu_102415_535 order by 1 ";
$sql = "select distinct a.appref, a.integratedcaseref, b.vlp from next_list_102415_sarah a, curam_ic_appref_101615 b where a.appref = b.appref and a.integratedcaseref = b.integratedcaseref and b.isprimary = 1 order by 1 ";
$sql = "select distinct a.appref, a.integratedcaseref, b.firstname, b.lastname, b.aptc, b.lasthealthplan, b.nexthealthplan, b.nexthealthplanpremium, b.hpafterpremium, b.lastdentalplan, b.nextdentalplan, b.nextdentalplanpremium, c.vlp from sarah_appref_out_102315 a, enrollmentinfo_101615 b, curam_ic_appref_101615 c where a.ssn = b.ssn  and a.datasource = 'mult_aptc_102715SCG_SB' and a.appref = c.appref and a.integratedcaseref = c.integratedcaseref and c.isprimary = 1 ";
$sql = " select distinct a.integratedcaseref, a.firstname, a.lastname, a.aptc, a.lasthealthplan, a.nexthealthplan, a.nexthealthplanpremium, a.hpafterpremium, a.lastdentalplan, a.nextdentalplan, a.nextdentalplanpremium, null as csreligibility, a.appref, b.itcmaxinstaxcreditamount as maxaptc from enrollment_ic_appref_101715 a, pranav_temp_110515 b where a.integratedcaseref = b.integratedcaseref and b.itcmaxinstaxcreditamount is not null  and a.integratedcaseref in (select icref from sean_list_110415 ) order by 1 ";
$sql = "select distinct a.username, a.concernrole_fullname, a.ssn, a.dob, a.appref, a.integratedcaseref, b.icstatuscode as icstatus, c.description, b.submitteddatetime as submitdate, b.lasttoucheddate from user_appref_110415  a, curam_ic_appref_101615 b, curam_code c where (b.icstatuscode = c.code and c.tabname = 'CaseStatus' ) and a.appref = b.appref and a.ssn in (select ssn from fordave_dupe_ssn_110515 ) order by 2,1 ";
$sql = "SELECT * from user_appref_prefinal_dedupe_110515 order by 1 ";
$sql = "select * from enroll_pii_112315_1016 a where not exists (select null from enroll_pii_112315_1119 b where a.fullname = b.fullname and a.dob = b.dob and a.ssn = b.ssn )";
$sql = "SELECT firstname, lastname, dob, ssn, aptc, lasthealthplan, nexthealthplan, nexthealthplanpremium, hpafterpremium, lastdentalplan, nextdentalplan, nextdentalplanpremium FROM sarah_aptc_10y_11n order by 1,2  ";
$sql = "SELECT * FROM curam_appref_income_092515  ";
        $result = pg_exec($db,$sql);

        $rownum = 0;
        $fieldnum = pg_numfields($result);

echo "started ".date("Y-m-d H:i:s")."\n";

$color = "#f5f5f5";
// echo "<table valign=top>";
// echo "<tr align=top bgcolor=#f5f5f5>";
$lineval="";
for ($i=0;$i<$fieldnum;$i++) {

// echo "<td><b>".(ucwords(ereg_replace("_", " ", pg_fieldname($result,$i))))."</b></td>";
	$lineval.= pg_fieldname($result,$i).'|';

}
//        $lineval = substr($lineval,0,-1);
        fputs($outfile, $lineval."\n");
// echo "</tr>";



        while ($row = pg_fetch_array($result,$rownum)) {
                                /* fputs($fsp, str_pad($row[pg_fieldname($result,0)],9," ")); */
                        $lineval = "";

                // echo "<tr valign=top bgcolor=$color>";
                for($i=0;$i<$fieldnum; $i++) {

                        $test = $row[pg_fieldname($result,$i)];
			if (pg_fieldtype($result,$i) == 'varchar'  OR pg_fieldtype($result,$i) == 'date' or pg_fieldtype($result,$i) == 'text') {
	                        $lineval.=$test.'|';
			} else {
        	                $lineval.=$test.'|';
			}

                        // echo "<td nowrap>$test</td>";
		}


                if ($alternate == "1") {
                        $color = "#f5f5f5";
                        $alternate = "0";
                } else {
                        $color = "#ffffff";
                        $alternate = "1";
                }

  //                      $lineval = substr($lineval,0,-1);

                                 /* fputs($outfile, $lineval);  */
                                 fputs($outfile, $lineval."\n");


        $where_clause="";


        $rownum = $rownum + 1;

        }
        fclose($outfile);
echo "rows ==  ".$rownum."\n";
echo "ended ".date("Y-m-d H:i:s")."\n";
?>

