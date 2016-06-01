<?php

//  echo "<tr><td colspan=6><B>Additional Information:</B></td></tr>";
 echo "<tr><td colspan=6>&nbsp;</td></tr>";


echo "<br><br>".$datastring."<br><br>";

$ch = curl_init('http://54.211.186.73/determinations/eval');
// $ch = curl_init('http://54.204.159.27/determinations/eval');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
// curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $datastring);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Accept: application/json',
    'Content-Length: ' . strlen($datastring))
);

$result = curl_exec($ch);


echo "<br><br> Result ===>  ".$result."<br><br>";

$deresult = json_decode($result,true) ;

foreach($deresult as $prop => $value) {
        if ( is_array($value)) {
                echo "<br><br> Level0: ".$prop." ==> ";
                foreach($value as $prop1 => $value1) {
                        if ( is_array($value1)) {
                        echo "<br><br>Level1:".$prop1." ==> ";
                                foreach($value1 as $prop2 => $value2) {
                                        if (is_array($value2) ) {
                                        echo "<br><br>Level2: ".$prop2." ==> ";
                                                foreach($value2 as $prop3 => $value3) {
                                                        if (is_array($value3) ) {
                                                        echo "<br><br>Level3: ".$prop3." ==>";
								$fldarray = 'applId, personId,'.$prop2.',';
								$dataarray = "'".$applid."','".$personID."','".$prop3."',";
//								$dataarray = "'".$_POST['applId']."','".$personID."','".$prop3."',";
                                                                foreach($value3 as $prop4 => $value4) {
									$fldarray.= str_replace(" ","",$prop4).',' ;
									$dataarray.= "'".(str_replace("'","",$value4))."',";
                                                                        echo '<br>'.$prop4.' : '.$value4;
                                                                }
								if (stristr($fldarray,'Determinations')) {
									$exsql = 'INSERT into application_determination ('.substr($fldarray,0,-1).') VALUES ('.substr($dataarray,0,-1).')';
									$exresult = execSql($db, $exsql, $debug) ;
//									echo '<br>'.$exsql.'<br>';
								}
								
                                                        } else {
								$prop2x = $prop2;
                                                                echo '<br>Level3a: '.$prop3.' : '.$value3;
                                                		$l3asql = "INSERT INTO application_result values ( '".$applid."','".$personID."','".$prop2."', '".(str_replace("'","",$prop3))."' , '".(str_replace("'","",$value3))."')";
						$exresult = execSql($db, $l3asql, $debug) ;
                                                        }
                                                }
                                        } else {
                                                echo '<br>Level2a: '.$prop2.' : '.$value2;
                                                $l2asql = "INSERT INTO application_result values ( '".$applid."','".$personID."','".$prop2x."', '".$prop2."' , '".(str_replace("'","",$value2))."')";
						$exresult = execSql($db, $l2asql, $debug) ;
						if ($prop2 == 'Person ID') {
							$personID = $value2 ;
						}
                                        }
                                }
                        } else {
                                echo '<br>Level1a: '.$prop1.' : '.$value1;
                        }
                }
        } else {
                echo '<br/>Level0a: '. $prop .' : '. $value;
        }
}

?>




    <tr><td align=center colspan=2><b>---------------</a></b></td><td align=left colspan=2>------------------------------</td></tr>


    <tr>
    <td colspan=2><input class="gray" type="Submit" name="formreturn" value="return"></td></tr>
</table>
    </p>
  </form>
</blockquote>
<?

include "inc/footer_inc.php";
?>
</body>
</HTML>
