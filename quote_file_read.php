<?php
include ("inc/dbconnect.php");

$h = fopen("/tmp/watfull2.csv","r"); 
$wf = fopen("/tmp/out_watfull2.txt","w"); 
if (!$h) { 
   die("unable to open"); 
} else { 

	$in_quote = 0;
	$fldval="";

	/* while ($char = fgetc($h)) { */
	/* while ("\x0a" !== ($char = fgetc($h))) {  */
	while (!feof($h)) {
		$char = fgetc($h);

		if ("\x0a" !== $char) {

			if ($char == '"') {
				if ($in_quote == 0) {
					$in_quote = 1;
					$fldval = "";
				} else {
					$fldval= (trim($fldval))."!";
					echo $fldval."\n";
					$lineval.=$fldval;
					$in_quote = 0;
				}
			} else {
				if ($in_quote == 1) {
					$fldval.=$char;
				}
			}

		} else {
			echo $lineval."\n";
			fputs ($wf, $lineval."\n");
			$in_quote = 0;
			$fldval="";
			$lineval="";

		}

	}
fclose ($h);
fclose ($wf);


}
?>
