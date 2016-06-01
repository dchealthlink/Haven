<?php
// Ver 1.0 11-08-2002
// PHP4 & Curl code to do a HTTPS RAW POST TO paymentsgateway.net system 
// coded by Lance Phillips lance@mediaengine.com
// PHP.net Curl Reference http://www.php.net/manual/en/ref.curl.php

function auth_transaction($db, $output_transaction, $debug) {
// output transaction - this is dynamically created from form variables - for simplicity I have hard-coded it here.
/*

$agent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)";
$ref = "https://68.48.195.191/cashier/inc/php_curl1.php"; // Replace this URL with the URL of this script
ob_start();
$ch=curl_init();
if ($ch) {
        echo "<p>trying  = ".$output_transaction."</p>";
	curl_setopt($ch, CURLOPT_URL, "https://www.paymentsgateway.net/");
	curl_setopt($ch, CURLOPT_PORT, 6051);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_NOPROGRESS, 1);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION,0);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $output_transaction);
	curl_setopt($ch, CURLOPT_TIMEOUT, 120);
	curl_setopt($ch, CURLOPT_USERAGENT, $agent);
	curl_setopt($ch, CURLOPT_REFERER, $ref);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	// $buffer = curl_exec($ch);
	curl_exec($ch);
	curl_close($ch);

$process_result = ob_get_contents();

// close and clean output buffer
ob_end_clean();

// clean response data of whitespace, convert newline to ampersand for parse_str function and trim off endofdata
$clean_data = str_replace("\n","&",trim(str_replace("endofdata", "", trim($process_result))));

// parse the string into variablename=variabledata
parse_str($clean_data);
print_r($clean_data);


} else {

        echo "<p>did not make it  = ".$output_transaction."</p>";

}

// This section of the code is the change from Version 1.
// This allows this script to process all information provided by Authorize.net...
// and not just whether if the transaction was successful or not

// Provided in the true spirit of giving by Chuck Carpenter (Chuck@MLSphotos.com)

// This section of the code is the change from Version 1.
// This allows this script to process all information provided by Authorize.net...
// and not just whether if the transaction was successful or not

// Provided in the true spirit of giving by Chuck Carpenter (Chuck@MLSphotos.com)
// Be sure to email him and tell him how much you appreciate his efforts for PHP coders everywhere
// $return = preg_split("/[,]+/", "$buffer"); // Splits out the buffer return into an array so . . .

$buffer = ereg_replace("'","",$buffer);

// echo "<p>buffer = ".$buffer."</p>";



*/ 



// output url - i.e. the absolute url to the paymentsgateway.net script
$output_url = "https://www.paymentsgateway.net/cgi-bin/posttest.pl";
// Uncomment below for live
//$output_url = "https://www.paymentsgateway.net/cgi-bin/postauth.pl";

// start output buffer to catch curl return data
ob_start();

	// setup curl
		$ch = curl_init ($output_url);
	// set curl to use verbose output
		curl_setopt ($ch, CURLOPT_VERBOSE, 1);
	// set curl to use HTTP POST
		curl_setopt ($ch, CURLOPT_POST, 1);
	// set POST output
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $output_transaction);
	//execute curl and return result to STDOUT
		curl_exec ($ch);
	//close curl connection
		curl_close ($ch);

// set variable eq to output buffer
$process_result = ob_get_contents();

// close and clean output buffer
ob_end_clean();

// clean response data of whitespace, convert newline to ampersand for parse_str function and trim off endofdata
$clean_data = str_replace("\n","&",trim(str_replace("endofdata", "", trim($process_result))));

// parse the string into variablename=variabledata
parse_str($clean_data);
		
// output some of the variables

$response_sql = "INSERT INTO xa_pay_response_log (
		xa_id, 
		pay_seq, 
		response_timestamp, 
		response_code, 
		response_subcode, 
		approval_code, 
		avs_result_code, 
		transaction_id, 
		description, 
		amount, 
		method, 
		transaction_type, 
		first_name, 
		last_name "; 

$response_sql_values = " VALUES ('".
		$ecom_consumerorderid."',".
		$pg_merchant_data_2.",
		now(),'".
		$pg_response_type."','".
		$pg_response_code."','".
		$pg_authorization_code."','".
		$pg_avs_result."','".
		$pg_trace_number."','".
		$pg_response_description."',".
		$pg_total_amount.",'".
		$pg_merchant_data_1."','".
		$pg_transaction_type."','".
		$ecom_billto_postal_name_first."','".
		$ecom_billto_postal_name_last."'";

if ($pg_avs_method) {
	$response_sql.=", avs_method";
	$response_sql_values.=",'".$pg_avs_method."'";
}
if ($pg_mail_or_phone_order) {
	$response_sql.=", mail_or_phone_order";
	$response_sql_values.=",'".$pg_mail_or_phone_order."'";
}
if ($pg_billto_postal_name_company) {
	$response_sql.=", company";
	$response_sql_values.=",'".$pg_billto_postal_name_company."'";
}
if ($ecom_billto_postal_street_line1) {
	$response_sql.=", billing_address";
	$response_sql_values.=",'".$ecom_billto_postal_street_line1."'";
}
if ($ecom_billto_postal_city) {
	$response_sql.=", city";
	$response_sql_values.=",'".$ecom_billto_postal_city."'";
}
if ($ecom_billto_postal_stateprov) {
	$response_sql.=", state";
	$response_sql_values.=",'".$ecom_billto_postal_stateprov."'";
}
if ($ecom_billto_postal_postalcode) {
	$response_sql.=", zip_code";
	$response_sql_values.=",'".$ecom_billto_postal_postalcode."'";
}
if ($ecom_billto_postal_country) {
	$response_sql.=", country";
	$response_sql_values.=",'".$ecom_billto_postal_country."'";
}
if ($ecom_billto_telecom_phone_number) {
	$response_sql.=", phone";
	$response_sql_values.=",'".$ecom_billto_telecom_phone_number."'";
}
if ($ecom_billto_telecom_online_email) {
	$response_sql.=", email";
	$response_sql_values.=",'".$ecom_billto_online_email."'";
}
if ($pg_customer_ip_address) {
	$response_sql.=", customer_ip_address";
	$response_sql_values.=",'".$pg_customer_ip_address."'";
}

$response_sql.= ") ".$response_sql_values.")";

$ret_code = execSql($db, $response_sql, $debug);

if ($ret_code != 'error') {
	$ret_val = $pg_response_type.','.$pg_response_code.','.$pg_response_description;
} else {
	$ret_val = $ret_code;
}

return $ret_val;
*/
return 1;

}
?>

