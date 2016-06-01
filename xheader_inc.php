<?php
?>
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 6.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<style type="text/css">
<!--
a:link {
	color: #897A59;
	text-decoration: none;
}

a:visited {
	color: #897A59;
	text-decoration: none;
}

a:hover, a:active {
	color: #FFCC99;
	text-decoration: none;

-->
</style>

<title>City of Laurel, Maryland Website
</title>
<link rel="stylesheet" href="inc/style.css" type="text/css">

</head>

<body topmargin=0 bottommargin=0 marginheight=0 marginwidth=0 leftmargin=0 rightmargin=0 bgcolor=#FFFFFF>

<table border="0" width="100%" height="95%" cellpadding=5 cellspacing=0>
  <tr>
    <td colspan="8" width="100%" valign="middle" align="center" style="border-bottom: 1 solid #897A59" bgcolor="#800000" height="16">
      &nbsp;
    </td>
        </tr>
  <tr>
    <!-- INSERT PAGE HEADER -->
    <td colspan="8" width="100%" height="86" valign="middle" align="center" style="border-left: 1 solid #800000; border-right: 1 solid #800000; border-bottom: 1 solid #897A59" bgcolor="#FFFFFF">
      <p align="center"><font face="verdana" size=2 color=" #612a2a"><a href="logout.php"><img border="0" src="<?php echo $logo ?>" width="<?php echo $logo_width ?>" height="<?php echo $logo_height ?>" align="left"></a></font><b><span style="font-variant: small-caps"><font size="2">
      <font face="Verdana" color="#612a2a">&nbsp;</font>
      </font><font face="Verdana" size="2" color="#897A59"><strong><br>
      Welcome
      to the</strong></font></span><font size="2"><br>
      </font><strong><span style="font-variant: small-caps"><font face="Verdana" size="4" color="#897A59"><?php echo $city_desc ?><br>
      </font>
      </span></strong><font face="Verdana" size="2" color="#897A59"><strong><span style="font-variant: small-caps">The
      Honorable <?php echo $mayor ?>, Mayor</span></strong></font></b>
    </td>
        </tr>
        <!-- END PAGE HEADER -->
  <tr>
    <td colspan="8" width="100%" height="16" valign="middle" align="center" style="border-left: 1 solid #800000; border-right: 1 solid #800000; border-bottom: 1 solid #897A59" bgcolor="#800000">
      <b><span style="font-variant: small-caps"><font face="Verdana" size="2" color="#FFCC99">&quot;<?php echo $tag_line ?>&quot;</font></span></b>
    </td>
        </tr>

<?
/* -- </table> */
if ($show_menu == "ON") {
 
?>

<tr><td colspan="8" width="100%" valign="top" align="left" width="90%">
 <table border="0" cellpadding="0" cellspacing="0"> 
 <tr align="left" valign="top" bgcolor="#FFFFFF">
 <td height="25" width="5" align="left">&nbsp;</td>
 <td height="25" width="85" align="left"><div id="nav"><a href="logout.php">Logout</a></div></td>
 <td height="25" width="85" align="left"><div id="nav"><a href="<?php echo $start_proc ?>"><?php echo ucfirst($user_type) ?> Home</a></div></td>
<?
if ($user_type == 'respondent') {
?>
 <td height="25" width="85" align="left"><div id="nav"><a href="select_queue.php">View Queue</a></div></td>
<?
}
?>
 <td height="25" width="85" align="left"><div id="nav"><a href="display_issue_public.php">Public Issues</a></div></td>
<?
if ($user_type == 'citizen') {

	$create_form = 'submit_issue.php';

} else {
	$create_form = 'submit_anonymous.php';
}

?>

<!-- <td height="25" width="85" align="left"><div id="nav"><a href="submit_issue.php">Create New</a></div></td> -->
 <td height="25" width="85" align="left"><div id="nav"><a href="<?php echo $create_form ?>">Create New</a></div></td>
 <td height="25" width="125" align="left"><div id="nav"><a href="change_password.php">Change Password</a></div></td>
<?
if ($user_type == 'citizen') {
?>
 <td height="25" width="85" align="left"><div id="nav"><a href="edit_citizen_notify.php">Auto-Notify</a></div></td>
 <td height="25" width="85" align="left"><div id="nav"><a href="search_issue.php">Search</a></div></td>
<?
}
?>
<?
if ($user_type != 'citizen') {
?>
 <td height="25" width="85" align="left"><div id="nav"><a href="gen_report.php">Reports</a></div></td>
<?
if ($user_type == 'admin') {
?>
 <td height="25" width="85" align="left"><div id="nav"><a href="view_admin.php">Admin</a></div></td>
<?
}
?>
<!-- <td height="25" width="85" align="left"><div id="nav"><a href="view_load_menu.php">Import</a></div></td> -->
 <td height="25" width="85" align="left"><div id="nav"><a href="load_wizard_export.php">Export</a></div></td>
<!-- <td height="25" width="85" align="left"><div id="nav"><a href="index.php">Search</a></div></td> -->
<?
}
?>
 <td height="25" width="85" align="left"><div id="nav"><a href="help.php">Help</a></div></td>        </tr>
</table> 
</td></tr>

<?

}
?>
<tr><td colspan="8" width="100%" valign="top">
