<?php
include ("inc/dbconnect.php");
$fp = fopen( '/var/lib/pgsql/backups/ht-041305.csv', 'r' );

while( !feof( $fp ) )
{
	$valline = fgets( $fp );
   $vars = explode(",",$valline);
/*    print $valline ;  */
	$value1 = ereg_replace("\"","",$vars[0]);
	if ($value1 == 'E') {

	$var15 =trim(ereg_replace('\"','',$vars[15]));
	$pos = strpos($var15,"-") ;
	if ($pos === false) {
		$var15ex[0] = "";
		$var15ex[1] = $var15;
	} else {
		$var15ex = explode("-",$var15);
		print $var15ex[0]." - ".$var15ex[1]."\n";  
		$dummy = substr($var15ex[0],0,3);

		if ($dummy == '53M' or $dummy == '53N' or $dummy == '53O' or $dummy == '53S' or $dummy == '53T' or $dummy == '53U' or $dummy == '53V') {
			$var15temp = $var15ex[0];
			$var15ex[0] = $var15ex[1];
			$var15ex[1] = $var15temp;
		print $var15ex[0]." - ".$var15ex[1]." NEW\n";   
		}
	}

        $ignoreline = fgets( $fp );
        $payseqline = fgets( $fp );
   	$payseqs = explode(",",$payseqline);


	$sql = "insert into ach_settle_data_test VALUES ('".
		trim(ereg_replace('\"','',$vars[1]))."','".
		trim(ereg_replace('\"','',$vars[2]))."','".
		trim(ereg_replace('\"','',$vars[3]))."','".
		trim(ereg_replace('\"','',$vars[4]))."','".
		trim(ereg_replace('\"','',$vars[5]))."','".
		trim(ereg_replace('\"','',$vars[6]))."','".
		trim(ereg_replace('\"','',$vars[7]))."','".
		trim(ereg_replace('\"','',$vars[8]))."','".
		trim(ereg_replace('\"','',$vars[9]))."','".
		trim(ereg_replace('\"','',$vars[10]))."',".
		$vars[11].",'".
		trim(ereg_replace('\"','',$vars[12]))."','".

		trim(ereg_replace('\"','',$vars[13]))."','";
		/* trim(ereg_replace('\"','',$vars[13]))."','". */
	
		if ($vars[14] == '""' and strlen($var15ex[1]) == 10) { 
			$sql.=trim(ereg_replace('\"','',$var15ex[1]))."','";

		} else {
/* 		trim(ereg_replace('\"','',$vars[14]))."','". */
			$sql.=trim(ereg_replace('\"','',$vars[14]))."','";
		}

	$sql.=trim(ereg_replace('\"','',$var15ex[1]))."','".
		trim(ereg_replace('\"','',$vars[16]))."','".
		trim(ereg_replace('\"','',$vars[17]))."','".
		trim(ereg_replace('\"','',$vars[18]))."','".
		trim(ereg_replace('\"','',$vars[19]))."','".
		trim(ereg_replace('\"','',$vars[20]))."','".
		trim(ereg_replace('\"','',$vars[21]))."','".
		trim(ereg_replace('\"','',$vars[22]))."','".
		trim(ereg_replace('\"','',$vars[23]))."','".
		trim(ereg_replace('\"','',$vars[24]))."','".
		trim(ereg_replace('\"','',$vars[25]))."','".
		trim(ereg_replace('\"','',$vars[26]))."','".
		trim(ereg_replace('\"','',$vars[27]))."','".
		$var15ex[0]."','ht-041305.csv',".
		trim(ereg_replace('\"','',$payseqs[2])).")";

	print $sql."\n\n";
	  $result = execSql($db, $sql, $debug);   
/*

	$sql = "SELECT count(*) FROM ach_settle_data_test WHERE ";
	$sql.= " authorization_code = '".(trim(ereg_replace('\"','',$vars[4])))."' AND ";
	$sql.= " response_date = '".(trim(ereg_replace('\"','',$vars[5])))."' AND ";
	$sql.= " transit_routing_number = '".(trim(ereg_replace('\"','',$vars[9])))."' AND ";
	$sql.= " account_number = '".(trim(ereg_replace('\"','',$vars[10])))."' AND ";
	$sql.= " external_transaction_id = '".(trim(ereg_replace('\"','',$var15ex[1])))."' AND ";
	$sql.= " load_filename = 'ht-040505.csv'";
	  $result = execSql($db, $sql, $debug);   

	$num_rows = pg_numrows($result);


	$sql = "UPDATE ach_settle_data_test SET pay_seq = ".(trim(ereg_replace('\"','',$payseqs[2])))." WHERE ";
	$sql.= " authorization_code = '".(trim(ereg_replace('\"','',$vars[4])))."' AND ";
	$sql.= " response_date = '".(trim(ereg_replace('\"','',$vars[5])))."' AND ";
	$sql.= " transit_routing_number = '".(trim(ereg_replace('\"','',$vars[9])))."' AND ";
	$sql.= " account_number = '".(trim(ereg_replace('\"','',$vars[10])))."' AND ";
	$sql.= " external_transaction_id = '".(trim(ereg_replace('\"','',$var15ex[1])))."' AND ";
	$sql.= " load_filename = 'ht-040505.csv'";

	if ($num_rows > 1) {
	 	print "FAILED - FAILED ".$sql."\n\n"; 
	} else {

	  $result = execSql($db, $sql, $debug);   
	}
*/
	}
}

fclose( $fp );
?>

