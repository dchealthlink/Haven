<?
$message="**Please DO NOT REPLY to this message. E-mail admin@".$municipality.".org if you have any questions.\n\n";
$message.="\nThe employee account for the user below has been established.  If this email is in error, please e-mail security@".$municipality.".org immediately.\n\n";

$message.="========= GENERAL INFORMATION =========\n\n";

$message.="Notifying Organization : ".$city_desc."\n";
$message.="Date/Time : ".$post_timestamp."\n\n";

$message.="========= CUSTOMER INFORMATION =========\n";
$message.="User Login : ".$user_login."\n";
$message.="Municipality : ".$city_desc."\n";
$message.="Password : ".$new_pw."\n";
?>
