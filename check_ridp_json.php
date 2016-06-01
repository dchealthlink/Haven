<?php
session_start();
include("inc/qdbconnect.php");
$m_row = 1;
$e_row = 0;

$show_menu="ON";

//  include("inc/j_header_inc.php"); 

?>
<HTML>
<head>

<?
        include ("inc/include_style.php");
?>

</head>
<?

$datastring = '{ "eid" : "'.$_GET['eid'].'" } ';
$datastring = 'eid='.$_GET['eid'];
if ($_GET['eid']){
	$datastring = 'eid='.$_GET['eid'];
}
if ($_POST['eid']){
	$datastring = 'eid='.$_POST['eid'];

	foreach($_POST as $prop => $value) {
        	if ($prop != 'eid') {
	        $datastring.= '&'.$prop.'='.$value;
        	$post0[$prop] = $value;
	        }
	}
}

// $ch = curl_init('http://10.29.75.20/dummy/web_serv_ridp_obj.php');
$url = 'http://localhost/web_serv_ridp_obj.php';
// $url = 'https://www.dcmic.org/web_serv_ridp_obj.php';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POST, count($datastring));
curl_setopt($ch, CURLOPT_POSTFIELDS, $datastring);
// curl_setopt($ch, CURLOPT_POSTFIELDS, $datastring);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//    'Content-Type: application/json',
//    'Accept: application/json',
//    'Content-Length: ' . strlen($datastring))
//);
$result = curl_exec($ch);


echo "<table border=0 cellpadding=0 cellspacing=0 >";
echo "<tr align=center valign=middle bgcolor=\"#FFFFFF\">";
echo "<td height=25 width=5 align=left>&nbsp;</td>";
//$newresult = file_get_contents($result);
$dstring = json_decode($result,true);

foreach($dstring as $prop => $value) {

        if ( is_array($value)) {
		// echo "is an array of type ==: ".$prop."<br>";
                foreach($value as $prop1 => $value1) {
                        if ( is_array($value1)) {
					if ($prop == 'field') {
							$e_row = $e_row+1;
				 			// echo "p1: ".$prop1." and the row is ".$e_row."<br>";
					}
                                	foreach($value1 as $prop2 => $value2) {
				 		// echo "p2: ".$prop2." value ".$value2."<br>";
						if ($prop == 'field') {
							$ematrix[$prop][$e_row][0] = $prop1;
		                        	switch ($prop2) {
                		                	case 'type':
								$ematrix[$prop][$e_row][1] = $value2;
								if ($value2 == 'select') {
								}
		                      		        break;
                		                	case 'label':
									$ematrix[$prop][$e_row][5] = $value2;
		                      		        break;
        		                        	case 'mandatory':
								if ($inmenu == 0 ) {
								$ematrix[$prop][$e_row][2] = $value2;
								}
                        		        	break;
        		                        	case 'readonly':
								if ($inmenu == 0 ) {
								$ematrix[$prop][$e_row][3] = $value2;
								}
                        		        	break;
        		                        	case 'placeholder':
								if ($inmenu == 0 ) {
								$ematrix[$prop][$e_row][4] = $value2;
								}
                        		        	break;
        		                        	case 'caption':
								if ($inmenu == 0 ) {
								$ematrix[$prop][$e_row][6] = $value2;
								}
                        		        	break;
        		                        	case 'hover':
								if ($inmenu == 0 ) {
								$ematrix[$prop][$e_row][7] = $value2;
								}
                        		        	break;
        		                        	case 'value':
								if ($inmenu == 0 ) {
								$ematrix[$prop][$e_row][8] = $value2;
								}
                        		        	break;
                                			case 'sort order':
	                                		break;

        	                		}	
						}
                                        	if (is_array($value2) ) {
                                			foreach($value2 as $prop3 => $value3) {
				 		//		echo "====> p1: ".$prop1." and  p2: ".$prop2."<br>";
				 		//		echo "p3: ".$prop3."<br>";
								if (is_array($value3)) {
                                					foreach($value3 as $prop4 => $value4) {
									//	echo "prop4 is ".$prop4." and value4 is ".$value4."<br>";
										$stuff[$prop1][$prop4] = $value4;
									}
/*
						echo "<br> ----------- array ------------ <br>";
						echo 'prop1 = '.$prop1.'   prop = '.$prop.'<br>';
						print_r($stuff);
						echo "<br> ----------- array ------------ <br>";
*/

								} else {
									// echo "value3 is ".$value3."<br>";
									if ($prop == 'response') {
				                        			switch ($prop3) {
	        	        		                			case 'type':
                	                			        			$r_row = $r_row + 1;
												$r_matrix[$r_row][0] = $prop2;
												$r_matrix[$r_row][1] = $value3;
			        		              			        break;
	        		        		                		case 'name':
                		                		        			$m_row = $m_row + 1;
				        	              			        break;
	        	        			        	        	case 'value':
                	                				        		$m_display = $value2;
												$matrix[$prop1][$m_row][0] = $value2;
												$r_matrix[$r_row][2] = $value3;
			        		        	      		        break;
        				        		                	case 'action':
                					        	                	$l_reference = $value2;
												$matrix[$prop1][$m_row][1] = $value2;
	                	        			        		break;
	        	                        					case 'sort order':
			                                				break;
	        	        			        	        	case 'format':
												$r_matrix[$r_row][3] = $value3;
			        		              			        break;
        	        			        		        	case 'required':
												$r_matrix[$r_row][4] = $value3;
			        			              		        break;
        	        				        	        	case 'label':
												$r_matrix[$r_row][5] = $value3;
				        		              		        break;
        		        			        	        	case 'caption':
												$r_matrix[$r_row][6] = $value3;
				        		              		        break;
	
        		                					}	
									}
									if ($prop1 == 'buttonmenu') {

										switch ($prop3) {
										case 'type':
										$b_row  = $b_row + 1;
										$matrix['buttonmenu'][$b_row][0] = $prop2;
										$matrix['buttonmenu'][$b_row][1] = $value3;
										break;
										case 'label':
										$matrix['buttonmenu'][$b_row][2] = $value3;
										break;
										case 'action':
										$matrix['buttonmenu'][$b_row][3] = $value3;
										break;
										}

									}
								}
							}
						} else {
							if ($prop1 == 'navmenu') {
//							echo "menu   ".$m_row." == prop2 ".$prop2."   value2 ".$value2."<br>";
							$matrix['menu'][$m_row][1] = $prop2;
							$matrix['menu'][$m_row][0] = $value2;
                                		        		$m_row = $m_row + 1;

							}
							if ($prop1 == 'buttonmenu') {
							echo "button menu   ".$b_row." == prop2 ".$prop2."   value2 ".$value2."<br>";
							$matrix['buttonmenu'][$b_row][1] = $prop2;
							$matrix['buttonmenu'][$b_row][0] = $value2;
                                		        		$b_row = $b_row + 1;

							}
						}
                                        }

                         } else {
		                        	switch ($prop1) {
                		                	case 'type':
								if ($value1 != 'menu') {
									$inmenu = 0;
								$ematrix[$prop][$e_row][1] = $value1;
								} else {
									$inmenu = 1;
								}
		                      		        break;
                		                	case 'name':
								if ($inmenu == 0 ) {
                                		        		$e_row = $e_row + 1;
									$ematrix[$prop][$e_row][0] = $value1;
								}
		                      		        break;
        		                        	case 'mandatory':
								if ($inmenu == 0 ) {
								$ematrix[$prop][$e_row][2] = $value1;
								}
                        		        	break;
        		                        	case 'readonly':
								if ($inmenu == 0 ) {
								$ematrix[$prop][$e_row][3] = $value1;
								}
                        		        	break;
        		                        	case 'placeholder':
								if ($inmenu == 0 ) {
								$ematrix[$prop][$e_row][4] = $value1;
								}
                        		        	break;
                                			case 'sort order':
	                                		break;

        	                		}	



                         }
               }
            } else {
		$$prop = $value;
         }

}

for ($k = 1; $k <= (count($matrix['menu'])); $k++) {

echo ("<td height=25 width=".(strlen($matrix['menu'][$k][0]) + 150)." align=left>");
// echo ("<td height=25 width=200 align=left>");
echo ("<div id=nav>");
        echo ("<a href=".$matrix['menu'][$k][1].">".$matrix['menu'][$k][0]."</a>");
//         echo ("<a href=".$matrix['menu'][$k][1].">".(strlen($matrix['menu'][$k][0]))."</a>");
echo ("</div></td>");
}

echo ("<td height=25 width=72 align=LEFT>");
// echo ("<div id=".$i_div.">");
echo ("<div id=nav>");
echo ("<a href=# onclick=javascript:window.open('help1.php?current_screen=".$PHP_SELF."','helpWindow','toolbar=0,location=0,left=0,top=0,resizable=1,scrollbars=yes,size=yes,width=320,height=360')>Help</a>");


echo ("</tr></table>");

// print_r($matrix);
// echo "<br>";

?>

<!--  <link rel="stylesheet" href="inc/style.css" type="text/css"> -->


<body bgcolor=#FFFFFF>
  <table class="main" width="100%" height="90%" border="0" cellpadding="0" cellspacing="0" bordercolor="#666666">
          <tr>
            <td width="9%" align="left" valign="top" border="0">

</td>
            <td width="88%" align="left" valign="top">
              <table width="95%" border="0" align="left" cellpadding="4" cellspacing="0">
                <tr><td valign=top>

<tr><td>
  <blockquote>
   <h1>Form on the fly:   <?php echo $header ?></h1>

 <!--  <form name="mainform" method="post" action="call_ws_resp_obj.php"> -->
   <form name="mainform" method="post" action="check_ridp_json.php">

	<table border=0 cellspacing=0 cellpadding=2 bordercolor=#eeeeee width=700> 

<!--        <tr><td>Check Json:</td><td colspan=5><TEXTAREA name="datastring" rows="15" cols="110"></textarea>
	</td></tr> -->

<?
for ($k = 1; $k <= (count($r_matrix)); $k++) {
echo "<tr><td>";
echo "<td>".$r_matrix[$k][6]."</td><td>".$r_matrix[$k][5]."</td>";
echo '<td colspan=5>';
echo $r_matrix[$k][2];
if ($r_matrix[$k][4] == 'true') {
//	echo '<input type="hidden" name="'.$r_matrix[$k][0].'" value="'.$r_matrix[$k][2].'">';
}
echo '</td>';



}

echo "<tr><td>&nbsp;</td><td colspan=5>&nbsp;</td></tr>";
for ($k = 1; $k <= (count($ematrix['field'])); $k++) {
echo "<tr><td>";
echo "<td>".$ematrix['field'][$k][6]."</td><td>".$ematrix['field'][$k][5]."</td>";
echo '<td colspan=5>';
if ($ematrix['field'][$k][1] == 'select') {
echo '<select name="'.$ematrix['field'][$k][0].'">';
echo '<option selected value=>';
foreach($stuff as $key => $value) {
	if ($key == $ematrix['field'][$k][0]) {
		foreach($value as $key1 => $value1) {
			echo "<option value='".$key1."'>".$value1;
		}
	}

}
echo '</select>';
echo ' </td>';

} else {
echo '<input type="'.$ematrix['field'][$k][1].'" name="'.$ematrix['field'][$k][0].'" placeholder="'.$ematrix['field'][$k][4].'" title="'.$ematrix['field'][$k][7].'" value="'.$ematrix['field'][$k][8].'"> </td>';
}
echo "</tr>" ;
}




echo "<tr><td colspan=6>&nbsp;</td></tr>";

echo "<br><br>";

echo "<tr><td colspan=6>";
for ($k = 1; $k <= (count($matrix['buttonmenu'])); $k++) {
	echo ("<input type=".$matrix['buttonmenu'][$k][1]." name='".$matrix['buttonmenu'][$k][0]."' value='".$matrix['buttonmenu'][$k][2]."'>&nbsp;&nbsp;");
}
echo "</td></tr>";
echo "<tr><td colspan=6>&nbsp;</td></tr>";
?>



    <tr>
<!--    <td colspan=2><input class="gray" type="Submit" name="submit" value="Submit"></td></tr> -->
<input type=hidden name=eid  value='<?php echo $event_name ?>'>
<input type=hidden name=genapikey value='<?php echo $genapikey ?>'>
<input type=hidden name=transid value='<?php echo $apikey ?>'>
<input type=hidden name=applicant_id value='<?php echo $applicant_id ?>'>

    </table>
    </p>
    </form>
</blockquote>
<?

include "inc/footer_inc.php";
?>
</body>
</HTML>
