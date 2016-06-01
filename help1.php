<?php
session_start();
include ("inc/dbconnect.php"); 
$show_menu="OFF";
/* include ("inc/config.php");   */
/* include ("inc/header_inc.php"); */
?>
<html>
<head>
<!--This line must be included as the swfobject.js file is referenced by the javascript below-->
                <script type="text/javascript" src="swfobject.js"> </script>
<!--End of swfobject.js definition-->

<title>POC System</title>
<link rel="stylesheet" href="inc/style.css" type="text/css">
</head>
<?php
$show_menu="OFF";
/* include ("inc/index_header_inc.php"); */
$show_menu="OFF";

$select_screen = ereg_replace("/","",$current_screen); 
$sql = "SELECT help_file FROM screen_help WHERE screen_name = '".$select_screen."' and (user_type = '".$usertype."' OR user_type = 'ALL') ORDER BY sort_order LIMIT 1";
$result = execSql ($db, $sql, $debug) ;
$numrows = pg_num_rows($result);

if ($numrows == 0) {
	if (file_exists(substr($current_screen,1))) { 
		$flv_name = substr($current_screen,1);
	} else {
		$flv_name = "avatar/no_helpf.flv" ; 
	}
} else {
	list($flv_name) = pg_fetch_row($result,0);
}	

?>
<body bgcolor="#FFFFFF" text="#000000">

<blockquote>

<!--This is where you setup the DIV. Notice the ID - this is the name of the DIV that is referenced by the Javascript below-->
        <div id="AlterEgosPlayer" align="left">Avatar Here</div>  <!--Replace this DIV ID with your own DIV ID if required-->
<!--End of DIV definition-->

<!--Please note the DIV must be before the Javascript -->
        <script type="text/javascript">
                        var so = new SWFObject("AlterEgos.com.swf", "main", "270", "280", "8", "#000000");
                        so.addParam("allowFullScreen", "true");
                        so.addVariable("MediaLink", "<?php echo $flv_name ?>");
                        so.addVariable("image", "images/legacy_fisma_mp_p1f.jpg");
                        so.addVariable("playOnStart", "true");
                        so.addParam("wmode", "transparent");
                        so.addVariable("startVolume", "50");
                        so.addVariable("loopMedia", "false");
                        so.write("AlterEgosPlayer");
                </script>
<br>
<input type="button" class="gray" onClick="window.close()" value="Close Window">
  </form>
</blockquote>
</body>
</html>
