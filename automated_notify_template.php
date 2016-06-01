<?
$message="**Please DO NOT REPLY to this message. E-mail support@".$app_locality.".org if you have any questions.\n\n";

$message.="========= GENERAL INFORMATION =========\n\n";

$message.="Notified by : ".$city_desc."\n";
$message.="Date/Time : ".$post_timestamp."\n\n";

$message.="========= STATUS INFORMATION =========\n";

$message.="Automated Notification Type : ".$notify_type_desc."\n";

if ($notify_text) {

$message.="\n========= NOTIFICATION  =========\n";
$message.="notify text : ".$notify_text."\n";

}

?>
