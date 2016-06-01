<?php
session_start();
include("inc/dbconnect.php");

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
$ch = curl_init('http://localhost/web_serv_menu_obj.php');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $datastring);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Accept: application/json',
    'Content-Length: ' . strlen($datastring))
);
$result = curl_exec($ch);

 echo $result."<br>";


echo "<table border=0 cellpadding=0 cellspacing=0 >";
echo "<tr align=center valign=middle bgcolor=\"#FFFFFF\">";
echo "<td height=25 width=5 align=left>&nbsp;</td>";
// echo $result."<br>";
$dstring = json_decode($result,$true);
foreach($dstring as $prop => $value) {

        if ( is_array($value)) {
		// echo $prop."<br>";
		for ($j = 0; $j < sizeof($value); $j++) {
//                foreach(array_shift($value) as $prop1 => $value1) {
                foreach($value[$j] as $prop1 => $value1) {
                        if ( is_array($value1)) {
				// echo "p1: ".$prop1."<br>";
                        	for ($i = 0 ;$i< sizeof($value1);$i++) {
// echo ("<td height=25 width=80 align=left>");
// echo ("<div id=nav>");
                                	foreach($value1[$i] as $prop2 => $value2) {
		                        	switch ($prop2) {
                		                	case 'name':
                                		        	$m_row = $m_row + 1;
		                      		        break;
                		                	case 'value':
                                		        	$m_display = $value2;
								$matrix[$prop1][$m_row][0] = $value2;
		                      		        break;
        		                        	case 'action':
                		                        	$l_reference = $value2;
								$matrix[$prop1][$m_row][1] = $value2;
                        		        	break;
                                			case 'sort order':
	                                		break;

        	                		}	
                                        	if (is_array($value2) ) {
                                           	} else {
                                           	}
                                        }
// echo ("<a href=".$l_reference.">".$m_display."</a>");
// echo ("</div></td>");

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



//                 		echo '<br>Level1a: '.$prop1.' : '.$value1."<br>";
                         }
               }
               }
            } else {
                 // echo '<br> not an array?<br>';
//                 echo '<br>Level0a: '.$prop0.' : '.$value0;
         }

}

for ($k = 1; $k <= (count($matrix['menu'])); $k++) {

echo ("<td height=25 width=80 align=left>");
echo ("<div id=nav>");
        echo ("<a href=".$matrix['menu'][$k][1].">".$matrix['menu'][$k][0]."</a>");
echo ("</div></td>");
}

echo ("<td height=25 width=72 align=LEFT>");
// echo ("<div id=".$i_div.">");
echo ("<div id=nav>");
echo ("<a href=# onclick=javascript:window.open('help1.php?current_screen=".$PHP_SELF."','helpWindow','toolbar=0,location=0,left=0,top=0,resizable=1,scrollbars=yes,size=yes,width=320,height=360')>Help</a>");


echo ("</tr></table>");

// print_r($matrix);
echo "<br>";
// print_r($ematrix);


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
   <h1>Form on the fly:</h1>

   <form name="mainform" method="post" action="call_ws_resp_obj.php">

	<table border=0 cellspacing=0 cellpadding=2 bordercolor=#eeeeee width=700> 

<!--        <tr><td>Check Json:</td><td colspan=5><TEXTAREA name="datastring" rows="15" cols="110"></textarea>
	</td></tr> -->

<?

echo "<tr><td>&nbsp;</td><td colspan=5>&nbsp;</td></tr>";
for ($k = 1; $k <= (count($ematrix['element'])); $k++) {
echo "<tr><td>";
echo "<td>".$ematrix['element'][$k][0]."</td>";
echo '<td colspan=5><input type="'.$ematrix['element'][$k][1].'" name="'.$ematrix['element'][$k][0].'" placeholder="'.$ematrix['element'][$k][4].'"> </td>';
echo "</tr>" ;
}




echo "<tr><td colspan=6>&nbsp;</td></tr>";

echo "<br><br>";

?>



    <tr>
    <td colspan=2><input class="gray" type="Submit" name="submit" value="Submit"></td></tr>
    </table>
    </p>
    </form>
</blockquote>
<?

include "inc/footer_inc.php";
?>
</body>
</HTML>
