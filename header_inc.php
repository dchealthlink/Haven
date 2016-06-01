<head>
<script language="JavaScript1.2" src="validation.js"></script>
<script language="JavaScript1.2" src="NumberFormat153.js"></script>
<script language="JavaScript1.2" src="DropCalendar.js"></script>
<link href="style.css" rel="stylesheet" type="text/css">
<title>POC (<?php echo $city_desc ?>) System - log in</title>
<style>
<!--
#nav a {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
        font-style: normal;
        line-height: normal;
        font-weight: bolder;
        font-variant: normal;
        text-transform: none;
        color: #FFFFFF;
        color: #003399;
        text-decoration: none;
        background-image: none;
        background-color: #003399;
        background-color: #FFFFFF;
}
#nav link {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
        font-style: normal;
        line-height: normal;
        font-weight: normal;
        font-variant: normal;
        text-transform: none;
        color: #FFFFFF;
        color: #284C86;
        text-decoration: none;
        background-color: #284C86;
        background-color: #FFFFFF;
}
#nav a:hover {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
        font-style: normal;
        line-height: normal;
        font-weight: bolder;
        font-variant: normal;
        text-transform: none;
        color: #003399;
        color: #FFFFFF;
        text-decoration: none;
        background-color: #FFFFFF;
        background-color: #003399;
}
#nav {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
        font-style: normal;
        line-height: normal;
        font-weight: 900;
        font-variant: normal;
        text-transform: none;
        color: #FFFFFF;
        color: #003399;
        text-decoration: none;
}
#gnav a {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
        font-style: normal;
        line-height: normal;
        font-weight: bolder;
        font-variant: normal;
        text-transform: none;
        color: #666666;
        color: #FFFFFF;
        text-decoration: none;
        background-image: none;
        background-color: #FFFFFF;
        background-color: #666666;
}
#gnav link {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
        font-style: normal;
        line-height: normal;
        font-weight: normal;
        font-variant: normal;
        text-transform: none;
        color: #FFFFFF;
        text-decoration: none;
        background-color: #666666;
}
#gnav a:hover {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
        font-style: normal;
        line-height: normal;
        font-weight: bolder;
        font-variant: normal;
        text-transform: none;
        color: #FFFFFF;
        color: #666666;
        text-decoration: none;
        background-color: #666666;
        background-color: #FFFFFF;
}
#gnav {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
        font-style: normal;
        line-height: normal;
        font-weight: 900;
        font-variant: normal;
        text-transform: none;
        color: #FFFFFF;
        text-decoration: none;
}

-->
</style>
</head>
<body> 
<?
if ($show_menu!="OFF") { 

$menu_sql="SELECT * from header_menu where menu_user_type= '".$usertype."'  order by sort_order";

$result = execSql($db, $menu_sql, $debug);

$numrows = pg_num_rows($result);
if ($numrows > 0) {
$rownum=0;

echo "<table border=0 cellpadding=0 cellspacing=0 >";
/* echo "<table border=0 cellpadding=0 cellspacing=0 width=725>"; */
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
echo ("<a href=# onclick=javascript:window.open('help.php?current_screen=".$PHP_SELF."','helpWindow','toolbar=yes,scrollbars=yes,width=800,height=550')>Help</a>");
echo ("</div></td>");


echo ("</tr></table>");

}
} 
if (!$logo) {
	$logo = "images/safe_haven.jpg";
	$logo_width=173;
	$logo_height=109;
}
?>
<link rel="stylesheet" href="inc/style.css" type="text/css">


<body bgcolor=#FFFFFF> 
<!-- <form name="form1" method="post" action="return.php"> -->
  <table class="main" width="100%" height="90%" border="0" cellpadding="0" cellspacing="0" bordercolor="#666666">
<!--
    <tr>
    <td align="left" valign="top">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
-->
          <tr>
            <td width="9%" align="left" valign="top" border="0">


<a href="logout.php"><img src="<?php echo $logo ?>" width="<?php echo $logo_width ?>" height="<?php echo $logo_height ?>" border="0" alt="Click to Login"></a>


<br><br>
<?
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
if ($message_data) {
echo $message_data;
}
?>

</td>
            <td width="88%" align="left" valign="top">
              <table width="95%" border="0" align="left" cellpadding="4" cellspacing="0">
		<tr><td colspan=0 valign=top>
<?

