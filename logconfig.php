<?php

error_reporting(E_ERROR);


$locality_sql = "select * from configuration where locality in (select locality from locality_config where active = '1' limit 1)";

        $locality_result = pg_exec($db,$locality_sql);

        if(pg_ErrorMessage($db))
                {
                DisplayErrMsg(sprintf("Error in executing %s statement", $locality_sql)) ;
                DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
                };

        $rownum = 0;

        while ($row = pg_fetch_array($locality_result,$rownum)) {
        list($app_locality, $config_field[$rownum], $config_field_value[$rownum]) = pg_fetch_row ($locality_result, $rownum);

        $$config_field[$rownum] = $config_field_value[$rownum];

        $rownum = $rownum+1;
        }


//change 'yes' to 'no' if you dont want emails sent to clients thanking them when invoices are paid
$emailoption = 'no';


// Display error messages
function DisplayErrMsg($message) {
printf("<BLOCKQUOTE><H2><FONT COLOR=\"#CC0000\">
	%s</FONT></H2></BLOCKQUOTE>\n", $message);
}
?>
