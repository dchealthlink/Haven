<?php
session_start();

include("inc/dbconnect.php");
include("inc/index_header_inc.php");


if ($SUBMIT) {
/* if ($fd = fopen ($file1, "r")){ */

         $size=filesize($file1);
         $fname = basename ($file1);
showEcho('file1',$file1);
/*
$contentType='application/octet-stream';
header("Pragma: ");
header("Cache-Control: ");
header("Content-type: $contentType");
header("Content-Disposition: attachment; filename=\"".$fname."\"");
header("Content-length:".$size);
*/
/* header("Content-length:".(string)(filesize($fullfilepath))); */
/*
$fd=fopen($file1,'r');
fpassthru($fd);
*/
$completeFilePath=$file1;
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
header("Content-type: application/octet-stream\nContent-Disposition: inline; filename=\"".$fname."\"\nContent-length: ".(string)(filesize($completeFilePath)));
$fd=fopen($completeFilePath,'r');
fpassthru($fd);




}
/* } */


 if ($HTTP_POST_VARS['action']) { ?> 
<HTML> 
<HEAD> 
<TITLE>File Upload Results</TITLE> 
</HEAD> 
<BODY BGCOLOR="WHITE" TEXT="BLACK"> 
<P><FONT FACE="Arial, Helvetica, sans-serif"><FONT SIZE="+1">File Upload 
    Results</FONT><BR><BR> 
<?php 
     
    $uploadpath = '/tmp/'; 
    $source = $HTTP_POST_FILES['file1']['tmp_name']; 
    $source1 = $HTTP_POST_FILES['file1']['name']; 
    $dest = ''; 

    if ( ($source != 'none') && ($source != '' )) { 
	list($width, $height, $upload_filetype, $attr) = getimagesize($source);
        $imagesize = getimagesize($source); 

/*        switch ( $imagesize[2] ) { */
        switch ( $upload_filetype ) { 

            case 0: 
                echo '<BR> Image is unknown <BR>'; 
                break; 
            case 1: 
                echo '<BR> Image is a GIF <BR>'; 
                break; 
            case 2: 
                echo '<BR> Image is a JPG <BR>'; 
                break; 
            case 3: 
                echo '<BR> Image is a PNG <BR>'; 
                break; 
            case 6: 
                echo '<BR> Image is a BMP <BR>'; 
                break; 
            case 7: 
                echo '<BR> Image is a TIFF <BR>'; 
                break; 
            case 8: 
                echo '<BR> Image is a TIFF <BR>'; 
                break; 
        } 
                echo '<BR> Name is '.$source1.' <BR>'; 
                $dest = $uploadpath.$source1; 

if ( $dest != '' ) { 

if ( move_uploaded_file( $source, $dest ) ) { 

echo 'File successfully stored.<BR>'; 

$sql = "insert into imex_log (log_name, log_type, log_level, log_dir, log_file, log_status, log_timestamp) values ('temp_upload','cust_file',1,'".$uploadpath."','".$source1."','S',now())";
$result = pg_exec($db,$sql);

echo "imagesize[0] is ".$width."<br>";
echo "imagesize[1] is ".$height."<br>";
echo "imagesize[2] is ".$upload_filetype."<br>";
echo "imagesize[3] is ".$attr."<br>";


} else { 

echo 'File could not be stored.<BR>'; 

} 

}  

} else { 
echo 'File not supplied, or file too big.<BR>'; 

} 

?> 
<BR><A HREF="<?php echo $PHP_SELF ?>">Back</A> 
</FONT></P> 
</BODY> 
</HTML> 
<?php } else { ?> 

<HTML> 
<HEAD> 
<TITLE>File Download</TITLE> 
</HEAD> 
<BODY BGCOLOR="WHITE" TEXT="BLACK"> 
<P><FONT FACE="Arial, Helvetica, sans-serif"><FONT SIZE="+1">File 
    Upload</FONT><BR><BR> 

If your browser is upload-enabled, you will see &quot;Browse&quot; (Netscape, 
Internet Explorer), or &quot;...&quot; (Opera) buttons below. Use them to 
select files to upload, then click the &quot;Upload&quot; button. After the 
files have been uploaded, you will see a results screen.<BR> 

/* <FORM METHOD="POST" ENCTYPE="multipart/form-data" 
      ACTION="<?php echo $PHP_SELF;?>"> */
 <FORM METHOD="POST" ACTION="<?php echo $PHP_SELF;?>"> 

<INPUT TYPE="HIDDEN" NAME="MAX_FILE_SIZE" VALUE="80000"> 
<INPUT TYPE="HIDDEN" NAME="action" VALUE="1"> 
File: <INPUT TYPE="TEXT" NAME="file1" SIZE="40"><BR><BR> 
<INPUT class="gray" TYPE="SUBMIT" NAME="SUBMIT" VALUE="Download"> 
</FORM> 
</FONT></P> 
<?
include "inc/footer_inc.php";

?>
</BODY> 
</HTML> 




<?php } ?> 
