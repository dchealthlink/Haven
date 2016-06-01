<?
$load_filename = "/tmp/".$notification_id.".call";
$outfile = fopen($load_filename,"w") ;
$phone_num_only = ereg_replace('-','',$phone);
if (strlen($phone_num_only) > 4) {
	$phone_num_only = "91".$phone_num_only;
}
$message="channel: local/".$phone_num_only."@default\n";
$message.="MaxRetries: 2\n";				
$message.="RetryTime: 5\n";			
$message.="WaitTime: 30\n";		
$message.="Context: default\n";	
$message.="Priority: 1\n";
$message.="Application: macro\n";
$message.="Data: vnout|".$app_locality."/identify|".$issue_id."|".$app_locality."/".$status_code."|".$app_locality."/questions|".$contact_phone."|".$app_locality."/thankyou\n"; 
/* $message.="Data: vnout|laurel/identify|".$issue_id."|laurel/".$status_code."|laurel/questions|".$contact_phone."|laurel/thankyou\n"; */
$message.="CallerID: ".$notification_id."\n";
fputs($outfile,$message);
fclose($outfile);
?>
