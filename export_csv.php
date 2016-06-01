<?php
include("inc/qdbconnect.php");

$outfile = fopen("/tmp/glue_to_curam081415.csv","w") ;

$sql = "SELECT policyno, fullname, birthday, appreference, typecode, gender, zip, planname, carrier, premium, totalcost, aptc, startdate, enddate, motivation, metal, programcode, status, age, agegroup, pdc FROM enrollappdata ORDER BY lastname, firstname LIMIT 1000";

        $result = pg_exec($db,$sql);

        $rownum = 0;
        $fieldnum = pg_numfields($result);

$color = "#f5f5f5";
echo "<table valign=top>";
echo "<tr align=top bgcolor=#f5f5f5>";
$lineval="";
for ($i=0;$i<$fieldnum;$i++) {

echo "<td><b>".(ucwords(ereg_replace("_", " ", pg_fieldname($result,$i))))."</b></td>";
	$lineval.= '"'.pg_fieldname($result,$i).'",';

}
        $lineval = substr($lineval,0,-1);
        fputs($outfile, $lineval."\n");
echo "</tr>";


/* ------------------------------------------------------------------------------------------------------------- */

		$headersql = "SELECT 'foundtype' as found_type, concernrolename, dob, appref, producttype,  ssn, integratedcaseref, casereference, null as nocoll, null as nocoll, null as nocoll, submitteddatetime, null as nocoll, motivationtype, null as nocoll, null as nocoll, null as nocoll, null as nocoll, null as nocoll, null as nocoll   FROM all_cases_in_curam WHERE 1=0";

        	$hresult = pg_exec($db,$headersql);

        	$ifieldnum = pg_numfields($hresult);
				$lineval= '';
		for ($h=0;$h<$ifieldnum;$h++) {
			if (pg_fieldname($hresult,$h) != 'nocoll') {
				$lineval.= '"'.pg_fieldname($hresult,$h).'",';
				echo "<td><b>".(ucwords(ereg_replace("_", " ", pg_fieldname($hresult,$h))))."</b></td>";
			} else {
				$lineval.= ',';
			}
		}
		echo "</tr>";
        	$lineval = substr($lineval,0,-1);
        	fputs($outfile, $lineval."\n");

/* ------------------------------------------------------------------------------------------------------------- */



        while ($row = pg_fetch_array($result,$rownum)) {
                                /* fputs($fsp, str_pad($row[pg_fieldname($result,0)],9," ")); */
                        $lineval = "";

                echo "<tr valign=top bgcolor=$color>";
                for($i=0;$i<$fieldnum; $i++) {

                        $test = $row[pg_fieldname($result,$i)];
			if ($i == 3) {
				$appref = $test;
			}
			if ($i == 1) {
				$thefullname = $test;
			}
			if (pg_fieldtype($result,$i) == 'varchar'  OR pg_fieldtype($result,$i) == 'date') {
	                        $lineval.='"'.$test.'",';
			} else {
        	                $lineval.=$test.',';
			}

                        echo "<td nowrap>$test</td>";
		}





                if ($alternate == "1") {
                        $color = "#f5f5f5";
                        $alternate = "0";
                } else {
                        $color = "#ffffff";
                        $alternate = "1";
                }

                        $lineval = substr($lineval,0,-1);

                                 /* fputs($outfile, $lineval);  */
                                 fputs($outfile, $lineval."\n");


        $where_clause="";


/* ------------------------------------------------------------------------------------------------------------- */

        	$irownum = 0;
		$innersql = "SELECT case when appref = '".$appref."' then 'appref' when concernrolename = '".$thefullname."' then 'fullname' else 'other' end as foundtype, concernrolename, dob, appref, producttype,  ssn, integratedcaseref, casereference, null, null, null, submitteddatetime, null, motivationtype, null, null, null, null, null, null   FROM all_cases_in_curam WHERE appref = '".$appref."' OR concernrolename = '".$thefullname."'";

        	$iresult = pg_exec($db,$innersql);

        	$ifieldnum = pg_numfields($iresult);

		$color = "#f5f5f5";
		echo "<tr align=top bgcolor=#f5f5f5>";
  
        	while ($irow = pg_fetch_array($iresult,$irownum)) {

                              /* fputs($fsp, str_pad($row[pg_fieldname($result,0)],9," ")); */

                        $ilineval = "";
                	echo "<tr valign=top bgcolor=$color>";
                	for($j=0;$j<$ifieldnum; $j++) {

                	        $itest = $irow[pg_fieldname($iresult,$j)];
			if (pg_fieldtype($iresult,$j) == 'varchar'  OR pg_fieldtype($iresult,$j) == 'date') {
	                        $ilineval.='"'.$itest.'",';
			} else {
        	                $ilineval.=$itest.',';
			}

	                        echo "<td nowrap>$itest</td>";
			}
                        $ilineval = substr($ilineval,0,-1);

                                 fputs($outfile, $ilineval."\n");
			$irownum = $irownum + 1;
		}

/* ------------------------------------------------------------------------------------------------------------- */
        $rownum = $rownum + 1;

        }
        fclose($outfile);
?>




