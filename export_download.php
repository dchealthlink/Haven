<?php
include ("inc/qdbconnect.php");
$folder = $DOCUMENT_ROOT."/files/"; // the folder which you want to open
$folder = "/tmp/"; // the folder which you want to open

function select_files($dir, $dloadfile, $tochoose) {

    global $PHP_SELF;
    $teller = 0;
    if ($handle = opendir($dir)) {
        $mydir = "<p>Available Files for Download:</p>\n";
        $mydir .= "<form name=\"form1\" method=\"post\" action=\"".$PHP_SELF."\">\n";
        $mydir .= "  <select name=\"file_in_folder\">\n";
        $mydir .= "    <option value=\"\" selected>... \n";
        while (false !== ($file = readdir($handle))) {
            $files[] = $file;
        }
        sort($files);
        if ($dloadfile) {
                        $mydir .= "    <option value=\"".$dloadfile."\">";
                        $mydir .= (strlen($dloadfile) > 30) ? substr($dloadfile, 0, 30)."...\n" : $dloadfile."\n";
                        $teller++;
        } else {
                if ($tochoose == 'cron') {
                        foreach ($files as $val) {
                                if ($val != "." && $val != ".." && (stristr($val,".eight") OR stristr($val,".four") OR stristr($val,".csv") OR stristr($val,".prev"))) {
                                        $mydir .= "    <option value=\"".$val."\">";
                                        $mydir .= (strlen($val) > 30) ? substr($val, 0, 30)."...\n" : $val."\n";
                                        $teller++;
                                }
                        }
                } else {
                        foreach ($files as $val) {
/*                                if ($val != "." && $val != ".." && (stristr($val,".txt") OR stristr($val,".csv") OR stristr($val,".out"))) { */
                                if ($val != "." && $val != ".." ) {
                                        $mydir .= "    <option value=\"".$val."\">";
                                        $mydir .= (strlen($val) > 30) ? substr($val, 0, 30)."...\n" : $val."\n";
                                        $teller++;
                                }
                        }
                }
        }

        $mydir .= "  </select>";
        $mydir .= "<input type=\"submit\" name=\"download\" value=\"Download\">";
        $mydir .= "</form>\n";
        closedir($handle);
    }
    if ($teller == 0) {
        echo "No files!";
    } else {
        echo $mydir;
    }
}
if (isset($download)) {
    $fullPath = $folder.$_POST['file_in_folder'];
/* moved this from below */
$myfile = $_POST['file_in_folder'];

/* $fsize = filesize($myfile); */

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Content-Description: File Transfer");
/* header("Content-Type: $mtype"); */
header("Content-Type: application/force-download");
header("Content-disposition: attachment; filename=\"$myfile\"");
header("Content-Transfer-Encoding: binary");
/* header("Content-Length: " . $fsize); */


/*
header ("Content-Type: application/octet-stream");
header ("Content-Disposition: attachment; filename=$myfile");
*/
/* moved this from below */
//Exec moved to convert file prior to handle opening, otherwise file is still unix format
//      exec("/usr/bin/unix2dos -o ".$fullPath);
/* added by dave for debugging on April 19, 2007*/
    error_log(date("Ymd - H:i:s"). "This is the value of fullPath : " . $fullPath, 0);
/*
    $fd = fopen ($fullPath, "r") ;

*/
    if ($fd = fopen ($fullPath, "r")) {
        $fsize = filesize($fullPath);
        $path_parts = pathinfo($fullPath);
        $ext = strtolower($path_parts["extension"]);
/*
        switch ($ext) {
            case "png":
            header("Content-type: image/png");
            header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");
            break;
            case "zip":
            header("Content-type: application/zip");
            header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
            break;
            default;
            header("Content-type: application/octet-stream");
            header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
        }
*/
        //exec("/usr/bin/dos2unix ".$fd); //changed by dave for test
        header("Content-length: $fsize");
        header("Cache-control: private");
        while(!feof($fd)) {
            $buffer = fread($fd, 2048);
            echo $buffer;
        }
    }
    fclose ($fd);
/* moved this up
$myfile = $_POST['file_in_folder'];
header ("Content-Type: application/octet-stream");
header ("Content-Disposition: attachment; filename=$myfile");
*/
// readfile("$folder$myfile");

        $inssql = "INSERT INTO imex_log (log_name, log_type, log_level, log_dir, log_file, log_status, log_timestamp) values ('harris','download',1,'/tmp/download','".$myfile."','S',now() )";
        $insresult = execSql($db, $inssql, $debug);
    exit;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>File Download</title>

<style type="text/css">
<!--
body {
    font-family: Arial, Helvetica, sans-serif;
    text-align:center;
}
p {
    font-size: 14px;
    line-height: 20px;
}
#main {
    width:350px;
    margin:0 auto;
    padding:10px;
    text-align:left;
    border: 1px solid #000000;
}
-->
</style>
</head>

<body onLoad="javascript:window.resizeTo(425,555);return false;">
<div id="main">
  <h2 style="text-align:center;margin-top:10px;">File download </h2>
  <?php echo select_files($folder, $dloadfile, $choose); ?>
</div>
<br><br>
<input class="gray" type="Button" name="WINDOWCLOSE" value="Window Close" onclick="javascript:window.close()">&nbsp;

</body>
</html>

