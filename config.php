<?

error_reporting(5);
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


$database = "radius";
$user = "username";
$pass = "password";
$hostname = "localhost";


$address = "123 Main Street <br>";
$address .= "Suite 5 <br>";
$address .= "Anywhere, VA <br>";
$address .= "20119 <br>";
$address .= "USA <br>";

$yourtitle = "Ignite TRX";

$payee = "Ignite TRX";
$due = "payment due in 30 days";

$site = "http://www.ignitetrx.com";

//change 'yes' to 'no' if you dont want emails sent to clients thanking them when invoices are paid
$emailoption = 'no';

// Display error messages
function DisplayErrMsg($message) {
printf("<BLOCKQUOTE><H2><FONT COLOR=\"#CC0000\">
	%s</FONT></H2></BLOCKQUOTE>\n", $message);
}
?>
