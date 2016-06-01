<!--
As you must have guessed so far, PHP executables can run independently from the web server. If you want to run your PHP scripts as a replacement to Perl scripts they should be transparent to the system. At the head of the document, type #!/usr/bin/php, this will tell the unix system that it needs to run PHP interpreter for the following script - this line would be ignored when you run this script under windows environment and thus you can write scripts with do not depend upon the operating system.
#!/usr/bin/php -q
<?php
    // your PHP code
    // goes here
?>

Note : 
Don't forget to add the PHP tags in the script file, else PHP will not interpret it properly. If you want to suppress the PHP headers use #!/usr/bin/php -q, similarly you can also use any other PHP arguments

-->
<?php
session_start();
include("inc/dbconnect.php");
include("inc/libmail.php");

$outersql ="SELECT * from notification where pickup_timestamp is null " ;

$outerresult = pg_exec($db,$outersql);

if(pg_ErrorMessage($db))
        {
        DisplayErrMsg(sprintf("Error in executing %s statement", $outersql)) ;
        DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
        };

$outer_rownum = 0;

while ($row = pg_fetch_array($outerresult,$outer_rownum)) {
list($notification_id, $notice_cd, $notice_group_cd, $notice_level, $posting_process, $post_timestamp, $remove_timestamp, $pickup_timestamp, $notice_email, $notice_template,$notice_subject, $notice_text, $notice_phone, $notice_method_cd) = pg_fetch_row ($outerresult, $outer_rownum);
/*
$sql ="select notification_text from notice_text WHERE notification_id ='".$notification_id."'" ;

$result = pg_exec($db,$sql);

if(pg_ErrorMessage($db))
        {
        DisplayErrMsg(sprintf("Error in executing %s statement", $sql)) ;
        DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
        };
list($notification_text) = pg_fetch_row ($result, $rownum);
*/
$sql ="SELECT * from notice_data WHERE notification_id ='".$notification_id."'" ;

$result = pg_exec($db,$sql);

if(pg_ErrorMessage($db))
        {
        DisplayErrMsg(sprintf("Error in executing %s statement", $sql)) ;
        DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
        };

$rownum = 0;

while ($row = pg_fetch_array($result,$rownum)) {
list($notice_cd, $notice_field[$rownum], $notice_field_value[$rownum]) = pg_fetch_row ($result, $rownum);

$$notice_field[$rownum] = $notice_field_value[$rownum];
/*  echo "<p>notice field redirect : ".$notice_field[$rownum]." and value is ".$notice_field_value[$rownum]."</p>"; */

$rownum = $rownum+1;
}

/*
if (!$notice_email || !$cust_id || !$notice_template || !$notice_subject || !$campaign_id || !$campaign_prev_status || !$campaign_status) { echo "Necessary information is missing.  Please go back and enter the missing information." ;
exit;
}
*/


if ($notice_method_cd != "P") {

	$m= new Mail; // create the mail
	$m->From( "no_reply@ignitetrx.com" );
	$m->To( $notice_email );
	$m->Subject( $notice_subject );	

$message=createMessage($db, $notice_template, $notification_id );
//include ( $notice_template );

//	$message= "This is a test of the Mail class\n";
//	$message.="The campaign_id is : ".$campaign_id." \n";
//	$message.="The cust_id is : ".$cust_id." \n";
//	$message.="The campaign_status is : ".$campaign_status." \n";
	$message.="\n\n ".$notice_text."\n";

	$m->Body( $message);	// set the body


$sql ="select notice_employee_id, c.email from notice_group_employee n, employee c where n.notice_employee_id = c.employee_id and n.notice_group_cd='".$notice_group_cd."'" ;

$result = pg_exec($db,$sql);

if(pg_ErrorMessage($db))
        {
        DisplayErrMsg(sprintf("Error in executing %s statement", $sql)) ;
        DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
        };

$rownum = 0;

while ($row = pg_fetch_array($result,$rownum)) {
list($notice_contact_id, $contact_email) = pg_fetch_row ($result, $rownum);

	$m->Cc( $contact_email );

$rownum = $rownum+1;
}

	$m->Cc( "nvfoa@ignitetrx.com");
/*	$m->Bcc( "tfahey@ignitetrx.com"); */
	$m->Priority( $notice_level ) ;	 
//	$m->Attach( "/home/leo/toto.gif", "image/gif" ) ;	// attach a file of type image/gif


$sql ="select attach_name, attach_type from notification_attach where notification_id='".$notification_id."' ORDER BY attach_no" ;

$result = pg_exec($db,$sql);

if(pg_ErrorMessage($db))
        {
        DisplayErrMsg(sprintf("Error in executing %s statement", $sql)) ;
        DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
        };

$rownum = 0;

while ($row = pg_fetch_array($result,$rownum)) {
list($attach_name, $attach_type) = pg_fetch_row ($result, $rownum);

	$m->Attach( $attach_name, $attach_type) ;

$rownum = $rownum+1;
}

	$m->Send();	// send the mail 
	echo "the mail below has been sent:<br><pre>", $m->Get(), "</pre>";


} else {

$dest_filename = "/var/spool/asterisk/outgoing/".$notification_id.".call";
$load_filename = "/tmp/".$notification_id.".call";
$outfile = fopen($load_filename,"w") ;
$message = createMessage ($db, $notice_template, $notification_id );

fputs($outfile,$message);
fclose($outfile);
	echo "<p>the phone message for notification ".$notification_id." has been prepared</p>";
	if (!rename($load_filename,$dest_filename)) {
		print ("failed to copy to $dest_filename ...\n");
	}
/*
	  $scp_line = "cp \"/tmp/".$notification_id.".call\" \"/var/spool/asterisk/outgoing/.\"\r"; 
	showEcho('scpline is ',$scp_line);
$last_line = exec('$scp_line', $retval);
$last_line = exec('exit(0)', $retval);
*/
/* $last_line = system('$scp_line', $retval); */

// Printing additional info
/*
echo '
</pre>
<hr />Return value: ' . $retval;
*/


}
$updsql ="UPDATE notification set pickup_timestamp = now() WHERE notification_id = '".$notification_id."'" ;

$updresult = pg_exec($db,$updsql);

if(pg_ErrorMessage($db))
        {
        DisplayErrMsg(sprintf("Executing %s ", $updsql)) ;
        DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
        };

$outer_rownum = $outer_rownum+1;
}

?>	
