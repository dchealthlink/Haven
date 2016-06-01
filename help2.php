<?php
session_start();
include ("inc/dbconnect.php"); 
$show_menu="OFF";
/* include ("inc/header_inc.php"); */
	$sql = "select max(slide_num) FROM module_slide WHERE module_id ='".$mid."'";
	$sqlresult = execSql($db, $sql, $debug) ;
	list ($maxnum) = pg_fetch_row ($sqlresult,0) ;

if ($GOTOSLIDE AND $GOTOSLIDENUM) {

	if ($GOTOSLIDENUM < 1 OR $GOTOSLIDENUM > $maxnum) {
		$testnum = 1;
	} else {
		$testnum = $GOTOSLIDENUM ;
	}
} else {

	if (!$testnum) {
		$testnum = 1;
	}
}
	if ($NEXTONE) {
		$testnum = $testnum + 1;
		if ($testnum > $maxnum) {
			$testnum = 1;
		}
	}
	if ($PREVONE) {
		if ($testnum == 1) {
			$testnum = $maxnum;
		} else {
			$testnum = $testnum - 1;
		}
	}

	if ($FIRSTONE) {
		$testnum = 1;
	}

	if ($LASTONE) {
		$testnum = $maxnum ;
	}

	if ($testnum == $maxnum) {
		$lastdisabled = 'disabled';
		$nextdisabled = 'disabled';
		$firstdisabled = '';
		$prevdisabled = '' ;
	}
	if ($testnum == 1) {
		$lastdisabled = '';
		$nextdisabled = '';
		$firstdisabled = 'disabled';
		$prevdisabled = 'disabled' ;
	}

?>
<html>
<head>
<!--This line must be included as the swfobject.js file is referenced byt the javascript below-->
                <script type="text/javascript" src="swfobject.js"> </script>
<!--End of swfobject.js definition-->

<title>POC System</title>
<link rel="stylesheet" href="inc/style.css" type="text/css">
<script language="">
<!--
function cursor(){document.login.name.focus();}
// -->
</script>
</head>
<?php
$show_menu="OFF";
/* include ("inc/index_header_inc.php"); */
$show_menu="OFF";

echo "<form method=post ACTION=help2.php>";


$sql = "select module_avatar, module_object, avatar_height, avatar_width, object_height, object_width FROM module_slide WHERE module_id = '".$mid."' AND slide_num = ".$testnum ;
$sqlresult = execSql($db, $sql, $debug) ;

list ($flv_name, $testdoc, $av_height, $av_width, $obj_height, $obj_width) = pg_fetch_row ($sqlresult,0) ;


?>
<body bgcolor="#FFFFFF" text="#000000" onLoad=cursor()>

<blockquote>
<table><tr>

<?
echo '<td rowspan=3>';
/* echo '<object type="application/pdf" data="'.$testdoc.'" width="'.$obj_width.'" height="'.$obj_height.'"></object>'; */
echo '<iframe  src="'.$testdoc.'#view=fitH" width="'.$obj_width.'" height="'.$obj_height.'"></iframe>';
echo '</td>';
echo '<td>&nbsp;</td>';
echo '<tr>';
?>
<td>

<!--This is where you setup the DIV. Notice the ID - this is the name of the DIV that is referenced by the Javascript below-->
        <div id="AlterEgosPlayer" align="left">Powered By AlterEgos.com</div>  <!--Replace this DIV ID with your own DIV ID if required-->
<!--End of DIV definition-->

<!--Please note the DIV must be before the Javascript -->
        <script type="text/javascript">
                        var so = new SWFObject("AlterEgos.com.swf", "main", "<?php echo $av_height ?>", "<?php echo $av_width ?>", "8", "#000000");
                        so.addParam("allowFullScreen", "true");
                        so.addVariable("MediaLink", "<?php echo $flv_name ?>");
                        so.addVariable("image", "test_avatar1.jpg");
                        so.addVariable("playOnStart", "true");
                        so.addParam("wmode", "transparent");
                        so.addVariable("startVolume", "50");
                        so.addVariable("loopMedia", "false");
                        so.write("AlterEgosPlayer");
                </script>
</td>

<?
echo '</tr>';
echo '<tr><td align=center><input type="button" class="gray" onClick="window.close()" value="Close Window"></td></tr>';


echo '<tr><td><input '.$firstdisabled.' type=Submit name=FIRSTONE value="First Slide">&nbsp;&nbsp;';
echo '<input '.$prevdisabled.' type=Submit name=PREVONE value="Previous Slide">&nbsp;&nbsp;';
echo '<input '.$nextdisabled.' type=Submit name=NEXTONE value="Next Slide">&nbsp;&nbsp;';
echo '<input '.$lastdisabled.' type=Submit name=LASTONE value="Last Slide">';
echo '<td><b>Slide '.$testnum.' of '.$maxnum.'</b>&nbsp;&nbsp;<input type=submit name=GOTOSLIDE value="Goto Slide #" ><input type=text name=GOTOSLIDENUM size=3 maxlength=2>';
echo "<input type=hidden name=testnum value='".$testnum."'></td></tr>";
echo "<input type=hidden name=mid value='".$mid."'></td></tr>";

?>
  </form>
</blockquote>
<?
/* include ("inc/footer_inc.php"); */
?>
</table>
</body>
</html>
