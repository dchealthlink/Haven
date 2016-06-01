<head>
<?
	if (!session_id()) {
		header("location: index.php?msg=timeout");
	}
	include ("include_style.php");
?>
<script language="JavaScript1.2" src="validation.js"></script>
</head>
<body> 
<?
if ($_SESSION['show_menu'] !="OFF") {

$menu_sql="SELECT * from header_menu where menu_user_type= '".$_SESSION['usertype']."'  order by sort_order";

$result = execSql($db, $menu_sql, $debug);

$numrows = pg_num_rows($result);
if ($numrows > 0) {
$rownum=0;
include "cb_header.htm";

echo "<table border=0 cellpadding=0 cellspacing=0 >";
echo "<tr align=center valign=middle bgcolor=\"#FFFFFF\">";
echo "<td height=25 width=5 align=left>&nbsp;</td>";

while ($row = pg_fetch_array($result,$rownum))
{

list($m_user_type, $temp_sort_order, $m_display, $l_reference, $i_height, $i_width, $i_align, $i_div, $i_variable, $a_key) = pg_fetch_row($result, $rownum);
echo ("<td height=".$i_height." width=".$i_width." align=".$i_align.">");
echo ("<div id=".$i_div.">");
if ($i_variable == 'Y') {
	$dummy = $$l_reference;
	echo ("<a href=".$dummy." accesskey=".$a_key.">".$m_display."</a>");
} else {
	echo ("<a href=".$l_reference." accesskey=".$a_key.">".$m_display."</a>");
}
echo ("</div></td>");
$rownum = $rownum + 1;
}

echo ("<td height=25 width=72 align=LEFT>");
echo ("<div id=".$i_div.">");
echo ("<a href=# onclick=javascript:window.open('help1.php?current_screen=".$PHP_SELF."','helpWindow','toolbar=0,location=0,left=0,top=0,resizable=1,scrollbars=yes,size=yes,width=320,height=360')>Help</a>");
// echo ("</div></td><td>".session_id()."</td>");


echo ("</tr></table>");

}
}
?>
<link rel="stylesheet" href="inc/style.css" type="text/css">


<body bgcolor=#FFFFFF>  
  <table bgcolor="#DCDCDC" class="main" width="100%" height="80%" border="0" cellpadding="0" cellspacing="0"  bordercolor="#F2EFF2">
  <!-- <table bgcolor="#DCDCDC" class="main" width="100%" height="80%" border="0" cellpadding="0" cellspacing="0"  bordercolor="#666666"> -->
          <tr>
            <td width="9%" align="left" valign="top" border="0">


<!-- <a href="logout.php"><img src="<?php echo $logo ?>" width="<?php echo $logo_width ?>" height="<?php echo $logo_height ?>" border="0" vspace="2" hspace="2" alt="Click to Login"></a>  -->

<br><br>
<?


/*
if ($left_menu) {
echo ("<table align=center cellpadding=5 border width=90% height=250>");
echo "<tr><td valign=top>";
echo "<div id=nav>";
	for ($z = 0; $z < count($left_menu); $z++) {

		if ($left_menu[$z][0]) {
			if ($left_menu[$z][2] == 1) {
				echo "<a href=".$left_menu[$z][0].">".$left_menu[$z][1]."</a><br>";
			} else {
				echo "".$left_menu[$z][1]."<br>";
			}

		}
	}
}
if ($include_left) {
include($include_left);
}
*/
/*
if ($message_data) {
echo $message_data;
}
*/
?>

</td>
            <td width="88%" align="left" valign="top">
              <table width="95%" border="0" align="left" cellpadding="4" cellspacing="0">
		<tr><td valign=top>
<?

