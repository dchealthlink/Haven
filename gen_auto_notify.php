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
include("inc/dbconnect.php");

$outersql ="select * from automated_notify where notify_generated is null" ;

$outerresult = pg_exec($db,$outersql);

if(pg_ErrorMessage($db))
        {
        DisplayErrMsg(sprintf("Error in executing %s statement", $outersql)) ;
        DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
        };

$outer_rownum = 0;

while ($row = pg_fetch_array($outerresult,$outer_rownum)) {
list($notify_serial, $notify_type, $notify_text, $notify_timestamp, $notify_generated, $notify_attachment) = pg_fetch_row ($outerresult, $outer_rownum);



$innersql ="select cn.citizen_key, c.email from citizen_notify cn, citizen c where cn.notify_type ='".$notify_type."' and cn.citizen_key = c.citizen_key" ;

showEcho('innersql is ',$innersql);
$innerresult = pg_exec($db,$innersql);

if(pg_ErrorMessage($db))
        {
        DisplayErrMsg(sprintf("Executing %s ", $innersql)) ;
        DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
        };

$inner_rownum = 0;

while ($row = pg_fetch_array($innerresult,$inner_rownum)) {

	showEcho('in inner row ',$inner_rownum);
list($citizen_key, $email) = pg_fetch_row ($innerresult, $inner_rownum);

        $not_code = "auto_notify";

        $sql = "SELECT to_char(now(),'YYMMDDHHMISSMS') as key_val, notice_subject, notice_text, notice_default_group_cd, notice_template, notice_level, now() FROM notice_code WHERE notice_cd = '".$not_code."'";
showEcho('sql1 is ',$sql);
        $result = pg_exec($db,$sql);
        if(pg_ErrorMessage($db))
                {
                DisplayErrMsg(sprintf("Executing %s ", $sql)) ;
                DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
                }

        list ($key_val, $notice_subject, $notice_text, $notice_default_group_cd, $notice_template, $notice_level, $post_timestamp ) = pg_fetch_row($result, 0);

        $sql = "INSERT into notification (
        notification_id,
        notice_cd,
        notice_group_cd,
        notice_subject,
        notice_text,
        notice_level,
        posting_process,
        post_timestamp,
        notice_email,
        notice_template) values
        ('".$key_val."','"
        .$not_code."','"
        .$notice_group_cd."','"
        .$notice_subject."','"
        .$notice_text."','"
        .$notice_level."','auto_notify','"
        .$post_timestamp."','"
        .$email."','"
        .$notice_template."')";

showEcho('sql is ',$sql);
        $result = pg_exec($db,$sql);
        if(pg_ErrorMessage($db))
                {
                DisplayErrMsg(sprintf("Executing %s ", $sql)) ;
                DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
                }
        $sql = "INSERT into notice_data values ('".$key_val."','user_login','".$email."')";
        $result = pg_exec($db,$sql);
        $sql = "INSERT into notice_data values ('".$key_val."','post_timestamp','".$post_timestamp."')";
        $result = pg_exec($db,$sql);
        $sql = "INSERT into notice_data values ('".$key_val."','municipality','".$app_locality."')";
        $result = pg_exec($db,$sql);
        $sql = "INSERT into notice_data values ('".$key_val."','city_desc','".$city_desc."')";
        $result = pg_exec($db,$sql);
        $sql = "INSERT into notice_data values ('".$key_val."','notify_type_desc','".$notify_type_desc."')";
        $result = pg_exec($db,$sql);
        $sql = "INSERT into notice_data values ('".$key_val."','notify_text','".$notify_text."')";
        $result = pg_exec($db,$sql);


        $sql = "INSERT into notification_attach values ('".$key_val."',0,'".$notify_attachment."','text/plain')";
        $result = pg_exec($db,$sql);


$inner_rownum = $inner_rownum + 1;

}

$updsql ="UPDATE automated_notify set notify_generated = 'Y' WHERE notify_serial = ".$notify_serial;

$updresult = pg_exec($db,$updsql);

if(pg_ErrorMessage($db))
        {
        DisplayErrMsg(sprintf("Executing %s ", $updsql)) ;
        DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
        };

$outer_rownum = $outer_rownum+1;
}

?>	
