<?php
include("inc/qdbconnect.php");
include ("inc/gen_functions_inc_test.php");
$outfile = fopen("/tmp/appl_ws_".(date('Y-m-d')).".out","a+");
/* require the user as the parameter */

        $posts = array();

	$postdata = file_get_contents("php://input");
	fputs($outfile,date('Y-m-d h:i:s')." 2. -- ".$postdata."\n\n");

	$deresult = json_decode($postdata,true) ;



	$presql = "SELECT max(applId) + 1 from application WHERE postDate = now()::date ";
	$preresult = execSql($db, $presql, $debug) ;
	list($applId) = pg_fetch_row($preresult, 0);
        if (!$applId) {
                $applId = (date("y") * 10000000) + ((date("z") + 1) * 10000) + 1 ;
        }
	$posts["application id"] = $applId ;

	$fldarray = "INSERT INTO application (applid ,";
	$dataarray = ") VALUES ( '".$applId."' ,";

	$arr_a_sql = "select field_name, magi_label from table_label_xref where table_name = 'application_person' ";
	$arr_a_result = execSql($db, $arr_a_sql, $debug) ;
	$data = array();
	while ($row = pg_fetch_row($arr_a_result)) {
        	$data[$row[0]] = $row[1] ;
	}
	$arr_b_sql = "select field_name, magi_label from table_label_xref where table_name = 'application' ";
	$arr_b_result = execSql($db, $arr_b_sql, $debug) ;
	$datab = array();
	while ($row = pg_fetch_row($arr_b_result)) {
        	$datab[$row[0]] = $row[1] ;
	}


// json object here

	$secondone = json_decode($postdata, true) ;
//print print_r($secondone);
//print echo "<br><br>";
foreach($secondone as $prop => $value) {
        if ( is_array($value)) {
//print                echo "<br><br> Level0: ".$prop." ==> ";
			$level0val = $prop;
                foreach($value as $prop1 => $value1) {
                        if ( is_array($value1)) {
//print                        echo "<br><br>Level1:".$prop1." ==> ";
				$level1val = $prop1 ;
				switch ($level0val) {
					case 'People':
					$apArray[$level1val]['applid'] = $applId ;
					break;
					case 'Physical Households':
					break;
					case 'Tax Returns':
					break;
				}
                                foreach($value1 as $prop2 => $value2) {
                                        if (is_array($value2) ) {
//print                                        echo "<br><br>Level2: ".$prop2." ==> ";
					$level2val = $prop2 ;
                                                foreach($value2 as $prop3 => $value3) {
                                                        if (is_array($value3) ) {
//print                                                        echo "<br><br>Level3: ".$prop3." ==>";
								$level3val = $prop3 ;
								if ($level2val == 'Relationships') {
								$relArray[$level1val][$level3val]['applId'] = $applId;
								$relArray[$level1val][$level3val]['personId'] = $personID;
								}
                                                                foreach($value3 as $prop4 => $value4) {
//print                                                                        echo '<br>'.$prop4.' : '.$value4;
									if ($level2val == 'Relationships') {
										$relArray[$level1val][$level3val][$prop4] = $value4 ;
									}
									if ($level0val == 'Physical Households') {
										$phArray[$applId][$level2valp][$level3val][$prop4] = $value4 ;
									}
									if ($level0val == 'Tax Returns') {
//										$txArray[$applId][$level1val][$level2val][$prop4] = $value4 ;
										$txArray[$applId][$level1val][$level2val][$level3val] = $value4 ;
									}
                                                                }

                                                        } else {
                                                                $prop2x = $prop2;
//print                                                                echo '<br>Level3a: '.$prop3.' : '.$value3;
								$foundval = array_search($prop3,$data)  ;
								if ($foundval) {
									$apArray[$level1val][$foundval] = $value3 ;
								}
                                                        }
                                                }
                                        } else {
//print                                                echo '<br>Level2a: '.$prop2.' : '.$value2;
						$foundval = array_search($prop2,$data)  ;
						if ($foundval) {
							$apArray[$level1val][$foundval] = $value2;
						}
						if ($level0val == 'Physical Households') {
							$level2valp = $value2;
						}
                                                if ($prop2 == 'Person ID') {
                                                        $personID = $value2 ;
							$posts["Person ID_".$value2] = $value2;
                                                }
                                        }
                                }
                        } else {
//print                                echo '<br>Level1a: '.$prop1.' : '.$value1;
                        }
                }
        } else {
//print                echo '<br/>Level0a: '. $prop .' : '. $value;
		$foundvalb = array_search($prop,$datab)  ;
		if ($foundvalb) {
			$fldarray.= $foundvalb." ,";
			$dataarray.= "'".$value."' ,";
		}
        }
}

//print echo "<br><br>";
//print echo $fldarray."postdate, status, statustimestamp ".$dataarray."now()::date, 'P', now() )" ;
$sql = $fldarray."postdate, status, statustimestamp ".$dataarray."now()::date, 'P', now() )" ;
$result = execSql($db, $sql, $debug) ;
//print echo "<br><br>";
//print print_r($apArray) ;
//print echo "<br><br>";

foreach($apArray as $prop => $value) {
        if ( is_array($value)) {
//print                echo "<br><br> Level0: ".$prop." ==> ";
                foreach($value as $prop1 => $value1) {
			if (is_array($value1)) {
//print                		echo "<br><br> Level0: ".$prop1." ==> ";
                		foreach($value1 as $prop2 => $value2) {
//print                			echo "<br><br> Level2: ".$prop2." ==> ".$value2;
				}
			} else {
				$insfldarray.= $prop1." ,";
				$insdatarray.= "'".$value1."' ,";
			}
		} 
		if ($insfldarray) {
			$sql = 'INSERT INTO application_person ('.(substr($insfldarray,0,-1)).') VALUES ('.(substr($insdatarray,0,-1)).' )';
			$result = execSql($db, $sql, $debug);
			$posts["application person"] = "insert" ;
//print			echo $sql."<br>";
			$insfldarray = '';
			$insdatarray = '';
		}
	} else {
//print                echo "<br><br> Level0: ".$prop." ==> ".$value;
	}
}
//print echo "<br><br>";
// print_r($relArray) ;
foreach($relArray as $prop => $value) {
        if ( is_array($value)) {
//print                echo "<br><br> Level0: ".$prop." ==> ";
                foreach($value as $prop1 => $value1) {
			if (is_array($value1)) {
//print                		echo "<br><br> Level0: ".$prop1." ==> ";
                		foreach($value1 as $prop2 => $value2) {
					$insfldarray.= str_replace(" ","_",$prop2)." ,";
					$insdatarray.= "'".$value2."' ,";
				}
			} else {
				$insfldarray.= str_replace(" ","_".$prop1)." ,";
				$insdatarray.= "'".$value1."' ,";
			}
			if ($insfldarray) {
				$sql = 'INSERT INTO application_relations ('.(substr($insfldarray,0,-1)).') VALUES ('.(substr($insdatarray,0,-1)).' )';
				$result = execSql($db, $sql, $debug);
			        $posts["application relation"] = "insert" ;
//print				echo $sql."<br>";
				$insfldarray = '';
				$insdatarray = '';
			}
		} 
	} else {
//print                echo "<br><br> Level0: ".$prop." ==> ".$value;
	}
}
//print echo "<br><br>";
//print print_r($phArray) ;
foreach($phArray as $prop => $value) {
        if ( is_array($value)) {
//print                echo "<br><br> Level0: ".$prop." ==> ";
                foreach($value as $prop1 => $value1) {
			if (is_array($value1)) {
//print                		echo "<br><br> Level1: ".$prop1." ==> ";
                		foreach($value1 as $prop2 => $value2) {
					if (is_array($value2)) {
                				foreach($value2 as $prop3 => $value3) {
//print                					echo "<br><br> Level2: ".$prop3." ==> ".$value3;
							$sql = "INSERT INTO application_household (applid, personid, householdid) values ('".$prop."','".$value3."','".$prop1."')";
							$result = execSql($db, $sql, $debug);
			        			$posts["application household"] = "insert" ;
//print							echo "<br>".$sql."<br>";
						}
					}
				}
			} else {
//print                		echo "<br><br> Level1: ".$prop1." ==> ".$value1;
			}
		} 
	} else {
//print                echo "<br><br> Level0: ".$prop." ==> ".$value;
	}
}
//print echo "<br><br>";
// print_r($txArray) ;
foreach($txArray as $prop => $value) {
        if ( is_array($value)) {
//print                echo "<br><br> Level0: ".$prop." ==> ";
                foreach($value as $prop1 => $value1) {
			if (is_array($value1)) {
//print                		echo "<br><br> Level1: ".$prop1." ==> ";
                		foreach($value1 as $prop2 => $value2) {
//print                			echo "<br><br> Level2: ".$prop2." ==> ";
					if (is_array($value2)) {
                				foreach($value2 as $prop3 => $value3) {
//print                					echo "<br><br> Level3: ".$prop3." ==> ".$value3;
							$sql = "INSERT INTO application_tax (applid, tax_no, filer_type, personid) values ('".$prop."','".$prop1."','".$prop2."','".$value3."')";
							$result = execSql($db, $sql, $debug);
			        			$posts["application tax"] = "insert" ;
//print							echo "<br>".$sql."<br>";
						}
					} else {
//print                				echo "<br><br> Level2: ".$prop2." ==> ".$value2;
					}
				}
			} else {
//print                		echo "<br><br> Level1: ".$prop1." ==> ".$value1;
			}
		} 
	} else {
//print                echo "<br><br> Level0: ".$prop." ==> ".$value;
	}
}
//print echo "<br><br>";
$japArray = json_encode($apArray, true);
$outArray = json_encode($posts, true);
fputs($outfile,date('Y-m-d h:i:s')." 3. -- ".$japArray."\n\n");
echo $outArray ;

?> 

