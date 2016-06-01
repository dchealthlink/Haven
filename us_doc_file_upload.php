<?php
session_start();

include("inc/dbconnect.php");
$show_menu = "OFF";
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

    $uploadpath = 'documents/';
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
                echo '<BR> User Story Id is '.$usid.' <BR>';
                $dest = $uploadpath.$source1;


if ( $dest != '' ) {

if ( move_uploaded_file( $source, $dest ) ) {
@chmod($dest, 0644);

echo 'File successfully stored.<BR>';

$sql = "insert into imex_log (log_name, log_type, log_level, log_dir, log_file, log_status, log_timestamp) values ('temp_upload','prom note',1,'".$uploadpath."','".$source1."','S',now())";
$result = pg_exec($db,$sql);

if ($usid) {
        $asql = "insert into user_story_document (userstoryid, doc_type, doc_name, doc_dir, document_description) values ('".$usid."','".$doc_type."','".$source1."','".$uploadpath."','".$document_description."')";
}
        $aresult = execSql($db,$asql,$debug);
/*
echo "imagesize[0] is ".$width."<br>";
echo "imagesize[1] is ".$height."<br>";
echo "imagesize[2] is ".$upload_filetype."<br>";
echo "imagesize[3] is ".$attr."<br>";
*/
?>
        <script>
        window.opener.location.reload(true);
        </script>
<?php

} else {

echo 'File could not be stored.<BR>';

}

}

} else {
echo 'File not supplied, or file too big.<BR>';

}

?>
<BR><br>
<input type=Button name=CLOSEWINDOW value="Close Window" onClick="window.close()">

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

If your browser is upload-enabled, you will see &quot;Browse&quot; (Netscape,
Internet Explorer), or &quot;...&quot; (Opera) buttons below. Use them to
select files to upload, then click the &quot;Upload&quot; button. After the
files have been uploaded, you will see a results screen.<BR>

<FORM METHOD="POST" ENCTYPE="multipart/form-data"
      ACTION="<?php echo $PHP_SELF;?>">

<INPUT TYPE="HIDDEN" NAME="MAX_FILE_SIZE" VALUE="1000000">
<INPUT TYPE="HIDDEN" NAME="action" VALUE="1">
<INPUT TYPE="HIDDEN" NAME="usid" VALUE="<?php echo $_GET['usid'] ?>">
File Name: <INPUT TYPE="FILE" NAME="file1" SIZE="40"><BR><BR>
Document Type: <SELECT name=doc_type>
<option selected value=\"\">
<?php
$sql = "SELECT item_cd, item_description, item_translation FROM app_lookup WHERE lookup_table = 'generic' AND lookup_field = 'doc_type' ORDER BY sort_order ";

$result = execSql($db, $sql, $debug);

$rownum = 0;
        while ($row = pg_fetch_array($result,$rownum))
        {
                list($t_item_cd, $t_item_description, $t_item_translation) = pg_fetch_row($result,$rownum);
                echo "<option value='".$t_item_translation."'>".$t_item_description;
        $rownum = $rownum + 1;
        }





/*
<option value="html">HTML Document
<option value="image">Graphic Image
<option value="presentation">Presentation
<option value="spreadsheet">Spreadsheet
<option value="text">Text Document
<option value="word">Word Processing Document
<option value="other">Other
*/
?>
</select><br><br>
Description:&nbsp;&nbsp;
<textarea name=document_description rows=6 cols=80></textarea>
<br><br>

<INPUT TYPE="SUBMIT" VALUE="Upload">
<input type=Button name=CLOSEWINDOW value="Close Window" onClick="window.close()">

</FORM>
</FONT></P>
</BODY>
</HTML>

<?php } ?>

