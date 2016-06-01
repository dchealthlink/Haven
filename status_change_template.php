<?
$message="**Please DO NOT REPLY to this message. E-mail support@".$app_locality.".org if you have any questions.\n\n";

$message.="========= GENERAL INFORMATION =========\n\n";

$message.="Notified by : ".$city_desc."\n";
$message.="Date/Time : ".$post_timestamp."\n\n";

$message.="========= STATUS INFORMATION =========\n";

$message.="Notification Id : ".$notification_id."\n";
$message.="Issue Id : ".$issue_id."\n";
$message.="Contact Phone : ".$contact_phone."\n";
$message.="Status : ".$status."\n";
$message.="Status Code : ".$status_code."\n";

if ($response_text) {

$message.="\n========= STATUS RESPONSE  =========\n";
$message.="Response : ".$response_text."\n";

}

?>
