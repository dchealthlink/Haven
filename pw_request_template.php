<?
$message="**Please DO NOT REPLY to this message. E-mail admin@".$app_locality.".org if you have any questions.\n\n";
$message.="\nThe Password below has been provided based on the users request.  If this is in error, please e-mail security@".$app_locality.".org immediately.\n\n";

$message.="========= GENERAL INFORMATION =========\n\n";

$message.="Notifying Organization : ".$city_desc."\n";
$message.="Date/Time : ".$post_timestamp."\n\n";

$message.="========= CUSTOMER INFORMATION =========\n";
$message.="Notification ID : ".$notification_id."\n";
$message.="Password : ".$new_pw."\n";
?>
