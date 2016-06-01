<?php
session_start();

include("inc/dbconnect.php");
$show_menu = 'ON';
include("inc/index_header_inc.php");



 if ($HTTP_POST_VARS['action']) { ?> 
<HTML> 
<HEAD> 
<TITLE>File Upload Results</TITLE> 
</HEAD> 
<BODY BGCOLOR="WHITE" TEXT="BLACK"> 
<P><FONT FACE="Arial, Helvetica, sans-serif"><FONT SIZE="+1">File Upload 
    Results</FONT><BR><BR> 
<?php 
     
    $uploadpath = '/tmp/accruals/'; 
    $source = $HTTP_POST_FILES['file1']['tmp_name']; 
    $source1 = $HTTP_POST_FILES['file1']['name']; 
    $art_desc = $HTTP_POST_VARS['artifact_desc']; 
    $dest = ''; 

    if ( ($source != 'none') && ($source != '' )) { 

        $imagesize = getimagesize($source); 

        switch ( $imagesize[2] ) { 

            case 0: 

                echo '<BR> Image is unknown <BR>'; 
                echo '<BR> Name is '.$source1.' <BR>'; 
                $dest = $uploadpath.$source1; 
                break; 

            case 1: 
                echo '<BR> Image is a GIF <BR>'; 
                echo '<BR> Name is '.$source1.' <BR>'; 
                $dest = $uploadpath.$source1; 
                break; 
             
            case 2: 
                echo '<BR> Image is a JPG <BR>'; 
                echo '<BR> Name is '.$source1.' <BR>'; 
              /*  $dest = $uploadpath.uniqid('img').'.jpg';  */
                $dest = $uploadpath.$source1; 
                break; 
             
            case 3: 
                echo '<BR> Image is a PNG <BR>'; 
                echo '<BR> Name is '.$source1.' <BR>'; 
                $dest = $uploadpath.$source1; 
                break; 

        } 

	if ( $dest != '' ) { 

		if ( move_uploaded_file( $source, $dest ) ) { 

			echo 'File successfully stored.<BR>'; 

			$sql = "INSERT INTO imex_log (log_name, log_type, log_level, log_dir, log_file, log_status, log_timestamp, log_description) values ('temp_upload','cust_file',1,'".$uploadpath."','".$source1."','S',now(),'".$art_desc."')";

			$sql = ereg_replace("''","null",$sql);

			$result = pg_exec($db,$sql);
		} else { 

			echo 'File could not be stored.<BR>'; 

		} 

	}  

} else { 

echo 'File not supplied, or file too big.<BR>'; 

} 

?> 
<BR>
<b><INPUT class="gray" TYPE="button" VALUE="Close Window" onClick="javascript:window.close()">&nbsp;
<input class="gray" type="button" name="LOADDATA" value="LOAD DATA" onclick="javascript:window.open('load_accrual_data.php', 'loadWindow', 'toolbar,scrollbars')">&nbsp

<br><BR><A HREF="<?php echo $PHP_SELF ?>?bid_id=<?php echo $bid_id ?>&request_id=<?php echo $request_id ?>">Back</A> 
</FONT></P> 
</BODY> 
</HTML> 
<?php } else { ?> 

<HTML> 
<HEAD> 
<TITLE>File Upload</TITLE> 
</HEAD> 
<BODY BGCOLOR="WHITE" TEXT="BLACK"> 
<P><FONT FACE="Arial, Helvetica, sans-serif"><FONT SIZE="+1">File 
    Upload</FONT><BR><BR> 

Use the BROWSE button to 
select files to upload, then click the &quot;Upload&quot; button. After the 
files have been uploaded, you will see a results screen.<BR> 

<FORM METHOD="POST" ENCTYPE="multipart/form-data" 
      ACTION="<?php echo $PHP_SELF;?>"> 

<INPUT TYPE="HIDDEN" NAME="MAX_FILE_SIZE" VALUE="800000"> 
<INPUT TYPE="HIDDEN" NAME="action" VALUE="1"> 
<INPUT TYPE="HIDDEN" NAME="bid_id" VALUE="<?php echo $bid_id ?>"> 
<INPUT TYPE="HIDDEN" NAME="request_id" VALUE="<?php echo $request_id ?>"> 
<table>
<?php
/*
if (!$bid_id) {
	echo "<tr><td>Request Id:  </td><td><b>".$request_id."</b></td></tr>";
	echo "<tr><td>Vendor Id:  </td><td><b>".$vendor_id."</b></td></tr>";
} else {
	echo "<tr><td>Bid No:  </td><td><b>".$bid_id."</b></td></tr>";
}
*/
?>
<tr><td>File: </td><td><INPUT class="pink" TYPE="FILE" NAME="file1" SIZE="50"></td></tr>
<tr><td>Description: </td><td><TEXTAREA name="artifact_desc" rows="7" cols="70"></textarea></td></tr>
</table>


<BR> 
<INPUT class="gray" TYPE="SUBMIT" VALUE="Upload"> 
<INPUT class="gray" TYPE="button" VALUE="Close Window" onClick="javascript:window.close()"> 
</FORM> 
</FONT></P> 
<?
include "inc/footer_inc.php";

?>
</BODY> 
</HTML> 




<?php } ?> 
