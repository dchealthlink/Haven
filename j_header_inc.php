<head>
<?
/*
	if (!session_id()) {
		header("location: index.php?msg=timeout");
	}
*/
	include ("include_style.php");
?>
</head>
<body> 
<?
if ($_SESSION['show_menu'] !="OFF") {
// start
/*
$datastring = '{"element": [ {
  "use":"input",
  "type": "menu",
  "name": "menuname",
  "label": "Label Name",
  "item": [   ';

$menusql = "SELECT menu_name, menu_value, menu_sort_order, menu_action FROM derived_menu WHERE menuid = 1 order by menu_sort_order ";
$menuresult = execSql($db, $menusql, $debug) ;

$rownum = 0;
while ($row = pg_fetch_array($menuresult,$rownum)) {
	list($mname, $mvalue, $msort, $maction) = pg_fetch_row($menuresult,$rownum) ;
	$datastring.= ' {"name":"'.$mname.'",';
	$datastring.= ' "value":"'.$mvalue.'",';
	$datastring.= ' "sort order":"'.$msort.'",';
	$datastring.= ' "action":"'.$maction.'"  },';
	$rownum = $rownum + 1;
}
*/
// end
/*



    "name":"option #1",
    "value":"option #1",
    "sort order":1,
    "action":"launch1.php"
    },
{
    "name":"option #2",
    "value":"option #2",
    "sort order":2,
    "action":"launch2.php"
    },
{
    "name":"option #3",
    "value":"option #3",
    "sort order":3,
    "action":"launch3.php"
    }
*/
// start
/*
$datastring = substr($datastring,0,-1) ;
$datastring.= '
]
}
]
}
';
*/
// end

/*
$menu_sql="SELECT * from header_menu where menu_user_type= '".$_SESSION['usertype']."'  order by sort_order";
$result = execSql($db, $menu_sql, $debug);
$numrows = pg_num_rows($result);
$rownum=0;
*/

if ($numrows >= 0) {


$ch = curl_init('http://10.29.75.20/dummy/web_serv_menu_obj.php');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $datastring);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Accept: application/json',
    'Content-Length: ' . strlen($datastring))
);
$result = curl_exec($ch);

// echo $result."<br>";


echo "<table border=0 cellpadding=0 cellspacing=0 >";
echo "<tr align=center valign=middle bgcolor=\"#FFFFFF\">";
echo "<td height=25 width=5 align=left>&nbsp;</td>";

$dstring = json_decode($result,$true);
// echo $dstring."<br>";
//  print_r($dstring);
foreach($dstring as $prop => $value) {
//	echo "<br>prop is ".$prop."    value is ".$value."<br>";
        if ( is_array($value)) {
//	echo "<br> is array .... <br>";
// print_r($value);
//        if ( $value instanceof StdClass) {
 //               echo "<br><br> Level0: ".$prop." ==> <br>";
                foreach(array_shift($value) as $prop1 => $value1) {
//		echo "prop1: ".$prop1."  value:= ".$value1."  <br>";
                        if ( is_array($value1)) {
 //                       echo "<br><br>Level1:".$prop1." ==> ";
//					echo "<br>value1 is ".$value1."<br>";
//  print_r($value1);
// echo "<br> size of array is ".(sizeof($value1))."<br>";
			for ($i = 0 ;$i< sizeof($value1);$i++) {
echo ("<td height=25 width=80 align=left>");
echo ("<div id=nav>");
                                foreach($value1[$i] as $prop2 => $value2) {
// echo ("<td height=".$i_height." width=".$i_width." align=".$i_align.">");
		//			echo "<br>value2 is ".$value2."<br>";
			switch ($prop2) {
				case 'value':
					$m_display = $value2;
				break;
				case 'action':
					$l_reference = $value2;
				break;
				case 'sort order':
				break;

			}

// if ($i_variable == 'Y') {
//	$dummy = $$l_reference;
//	echo ("<a href=".$dummy." accesskey=".$a_key.">".$m_display."</a>");
//} else {
//}

                                        if (is_array($value2) ) {
 //                                       echo "<br><br>Level2: ".$prop2." ==> ";
                                           } else {
   //                                             echo '<br>Level2a: '.$prop2.' : '.$value2;
				           }
					}
	echo ("<a href=".$l_reference.">".$m_display."</a>");
echo ("</div></td>");

			}
                         } else {
//                             echo '<br>Level1a: '.$prop1.' : '.$value1.'<br>';
		         }
               }  
            } else {
                 echo '<br> not an array?<br>';
                 echo '<br>Level0a: '.$prop0.' : '.$value0;
         }
}  




/*
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
*/
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
<!-- <form name="form1" method="post" action="return.php"> -->
  <table class="main" width="100%" height="90%" border="0" cellpadding="0" cellspacing="0" bordercolor="#666666">
<!--
    <tr>
    <td align="left" valign="top">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
-->
          <tr>
            <td width="9%" align="left" valign="top" border="0">

<!-- <img src="images/logo-2x.png" width="215" height="57" border="0" vspace="2" hspace="2" alt="Click to Login"> -->

<a href="logout.php"><img src="<?php echo $logo ?>" width="<?php echo $logo_width ?>" height="<?php echo $logo_height ?>" border="0" vspace="2" hspace="2" alt="Click to Login"></a> 

<br><br>
<?
	if ($userverbose != 'y') {
/*	if ($mid AND $mid != 'splash') { */
	if ($mid ) {

		$modsql = "SELECT count(*) FROM module_slide WHERE module_id = '".$mid."'";
		$modresult = execSql($db,$modsql,$debug);
		list($numSlides) = pg_fetch_row($modresult,0);
		if ($numSlides > 0) {


		echo "<a href=# onclick=javascript:window.open('slide_read.php?mid=".$mid."','rdrWindow','toolbar=0,location=0,left=0,top=0,resizable=1,scrollbars=yes,size=yes,width=1150,height=500')><img src='images/legacy_fisma_mp_p1f.jpg' width='180' height='186' border='0' vspace='2' hspace='2' alt='Click to Launch Reader'></a> ";
		echo "<br>";
		echo "<a href=# onclick=javascript:window.open('slide_read.php?mid=".$mid."','rdrWindow','toolbar=0,location=0,left=0,top=0,resizable=1,scrollbars=yes,size=yes,width=1150,height=500')>Click to Launch Slide Reader</a> ";
		}
	}
	}
if ($userverbose == 'y') {

	if ($mid ) {
		$avsql="SELECT module_avatar FROM module WHERE module_id = '".$mid."'";
		$avresult = execSql($db, $avsql, $debug);
		list ($mod_avatar) = pg_fetch_row($avresult,0) ;
	} else {
		$avsql="SELECT help_file  FROM screen_help WHERE screen_name = 'ALL' OR screen_name = '".ereg_replace("/","",$PHP_SELF)."' ORDER BY sort_order limit 1";
		$avresult = execSql($db, $avsql, $debug);
		list ($mod_avatar) = pg_fetch_row($avresult,0) ;
	}
	if ($mod_avatar) {
	/* if ($mod_avatar OR !$mid) { */

?>
<!--This is where you setup the DIV. Notice the ID - this is the name of the DIV that is referenced by the Javascript below-->
        <div id="AlterEgosPlayer" align="right"></div>  <!--Replace this DIV ID with your own DIV ID if required-->
<!--End of DIV definition-->

<!--Please note the DIV must be before the Javascript -->
        <script type="text/javascript">
                        var so = new SWFObject("AlterEgos.com.swf", "main", "180", "200", "8", "#000000");
                        so.addParam("allowFullScreen", "true");
                        so.addVariable("MediaLink", "<?php echo $mod_avatar ?>");
                        so.addVariable("image", "images/legacy_fisma_mp_p1f.jpg");
                        so.addVariable("playOnStart", "false");
                        so.addParam("wmode", "transparent");
                        so.addVariable("startVolume", "50");
                        so.addVariable("loopMedia", "false");
                        so.write("AlterEgosPlayer");
                </script>


<?
	} else {
		if ($mid) {
		echo "<a href=# onclick=javascript:window.open('slide_read.php?mid=".$mid."','rdrWindow','toolbar=0,location=0,left=0,top=0,resizable=1,scrollbars=yes,size=yes,width=1150,height=500')><img src='images/legacy_fisma_mp_p1f.jpg' width='180' height='186' border='0' vspace='2' hspace='2' alt='Click to Launch Reader1'></a> ";
		}
	}

		if ($mid) {
			echo "<br>";
			echo "<a href=# onclick=javascript:window.open('slide_read.php?mid=".$mid."','rdrWindow','toolbar=0,location=0,left=0,top=0,resizable=1,scrollbars=yes,size=yes,width=1150,height=500')>Click to Launch Slide Reader</a> ";

		}


}


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

