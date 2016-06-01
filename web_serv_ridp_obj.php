<?php
include("inc/qdbconnect.php");

include ("inc/gen_functions_inc_test.php");
$outfile = fopen("/tmp/ridp_obj_ws_".(date('Y-m-d')).".out","a+");
if (!$_POST['transid']) {
$transid = gen_trans_id($db, $debug);
} else {
	$transid = $_POST['transid'] ;
}
/* require the user as the parameter */

        $posts = array();

        $postdata = file_get_contents("php://input");
        fputs($outfile,date('Y-m-d h:i:s')." 1. -- trans id is ".$transid."\n");
        fputs($outfile,date('Y-m-d h:i:s')." 2. -- ".$postdata."\n\n");

        $deresult = json_decode($postdata,true) ;

//        $presql = "SELECT max(applId) + 1 from application WHERE postDate = now()::date ";
if (!$_POST['applicant_id']) {
        $presql = "SELECT max(applicant_id::integer) + 1 from applicant_demo WHERE applicant_date = now()::date ";
        $preresult = execSql($db, $presql, $debug) ;
        list($applId) = pg_fetch_row($preresult, 0);
        if (!$applId) {
                $applId = (date("y") * 10000000) + ((date("z") + 1) * 10000) + 1 ;
        }
} else {
	$applId = $_POST['applicant_id'] ;
}
        fputs($outfile,date('Y-m-d h:i:s')." 2a. -- ".$applId."\n");


$post1["apikey"] = "abc123";
$post1["event"] = "form";
$post1["event_name"] = "RIDP_Validation";
$post1["version"] = "1.0";
$post1["title"] = "Citizen Confirmation Screen";



// print_r($_POST);
// echo "<br><br>";
if (!$_POST['eid'] and !$_GET['eid']) {
	$eventid = 'pre_citizen';
} else {
	if ($_GET['eid']) {
		$eventid = $_GET['eid'];
	}
	if ($_POST['eid']) {
		$eventid = $_POST['eid'];
	}
}


switch ($eventid) {
	case 'pre_citizen':
        fputs($outfile,date('Y-m-d h:i:s')." 2b. -- ".$applId."\n");
		$sql = 'INSERT INTO event_log ( trans_id, applicant_id, status, user_id, event_timestamp) VALUES (';
		$sql.= "'".$transid."',";
		$sql.= "'".$applId."',";
		$sql.= "'A',";
		$sql.= "'".$_SESSION['userid']."',";
		$sql.= "now()";
		$sql.= ")";
		$sql = str_replace("''","null",$sql);
		$result = execSql($db, $sql, $debug);
		fputs($outfile,date('Y-m-d h:i:s')." 3. -- ".$sql."\n\n");

		$sql = 'INSERT INTO event_detail_log (trans_id, event_id, status, applicant_id, user_id, event_timestamp ) values (';
		$sql.= "'".$transid."',";
		$sql.= "'".$eventid."',";
		$sql.= "'A',";
		$sql.= "'".$applId."',";
		$sql.= "'".$_SESSION['userid']."',";
		$sql.= "now()";
		$sql.= ")";
		$sql = str_replace("''","null",$sql);
		$result = execSql($db, $sql, $debug);

		$eventid = 'get_citizen';
	break;
	case 'get_citizen':

		$sql = 'INSERT INTO event_detail_log (trans_id, event_id, status, applicant_id, user_id, event_timestamp ) values (';
		$sql.= "'".$transid."',";
		$sql.= "'".$eventid."',";
		$sql.= "'A',";
		$sql.= "'".$applId."',";
		$sql.= "'".$_SESSION['userid']."',";
		$sql.= "now()";
		$sql.= ")";
		$sql = str_replace("''","null",$sql);
		$result = execSql($db, $sql, $debug);


		$sql = 'INSERT INTO applicant_demo ( applicant_id, first_name, last_name, address1, address2, city, state, zip_code, dob, ssn, status, applicant_date) VALUES (';
		$sql.= "'".$applId."',";
		$sql.= "'".$_POST['first_name']."',";
		$sql.= "'".$_POST['last_name']."',";
		$sql.= "'".$_POST['address1']."',";
		$sql.= "'".$_POST['address2']."',";
		$sql.= "'".$_POST['city']."',";
		$sql.= "'".$_POST['state']."',";
		$sql.= "'".$_POST['zip_code']."',";
		$sql.= "'".$_POST['dob']."',";
		$sql.= "'".$_POST['ssn']."',";
		$sql.= "'A',";
		$sql.= "now()::date";
		$sql.= ")";
		$sql = str_replace("''","null",$sql);
		$result = execSql($db, $sql, $debug);

		fputs($outfile,date('Y-m-d h:i:s')." 3. -- ".$sql."\n\n");
		$eventid = 'event1';
	break;
	case 'RIDP_Validation':
	case 'event1':

		$sql = 'INSERT INTO event_detail_log (trans_id, event_id, status, applicant_id, user_id, event_timestamp ) values (';
		$sql.= "'".$transid."',";
		$sql.= "'".$eventid."',";
		$sql.= "'A',";
		$sql.= "'".$applId."',";
		$sql.= "'".$_SESSION['userid']."',";
		$sql.= "now()";
		$sql.= ")";
		$sql = str_replace("''","null",$sql);
		$result = execSql($db, $sql, $debug);

		if ($_POST['previous_residence']) {
		$sql = 'INSERT INTO applicant_ridp ( applicant_id, trans_id, question_no, question_value, answer, correct_flag ) VALUES (';
		$sql.= "'".$applId."','".$transid."',";
		$sql.= "'1','previous_residence',";
		$sql.= "'".$_POST['previous_residence']."',";
		$sql.= "1";
		$sql.= ")";
		$sql = str_replace("''","null",$sql);
		$result = execSql($db, $sql, $debug);
		fputs($outfile,date('Y-m-d h:i:s')." 3a. -- ".$sql."\n\n");
		} else {
			$error_flag = $error_flag + 1;
		}
		if ($_POST['home_built_range']) {
		$sql = 'INSERT INTO applicant_ridp ( applicant_id, trans_id, question_no, question_value, answer, correct_flag ) VALUES (';
		$sql.= "'".$applId."','".$transid."',";
		$sql.= "'2','home_built_range',";
		$sql.= "'".$_POST['home_built_range']."',";
		$sql.= "1";
		$sql.= ")";
		$sql = str_replace("''","null",$sql);
		$result = execSql($db, $sql, $debug);
		fputs($outfile,date('Y-m-d h:i:s')." 3b. -- ".$sql."\n\n");
		} else {
			$error_flag = $error_flag + 1;
		}
		if ($_POST['num_bedrooms']) {
		$sql = 'INSERT INTO applicant_ridp ( applicant_id, trans_id, question_no, question_value, answer, correct_flag ) VALUES (';
		$sql.= "'".$applId."','".$transid."',";
		$sql.= "'3','num_bedrooms',";
		$sql.= "'".$_POST['num_bedrooms']."',";
		$sql.= "1";
		$sql.= ")";
		$sql = str_replace("''","null",$sql);
		$result = execSql($db, $sql, $debug);
		fputs($outfile,date('Y-m-d h:i:s')." 3c. -- ".$sql."\n\n");
		} else {
			$error_flag = $error_flag + 1;
		}
		if ($_POST['education_level']) {
		$sql = 'INSERT INTO applicant_ridp ( applicant_id, trans_id, question_no, question_value, answer, correct_flag ) VALUES (';
		$sql.= "'".$applId."','".$transid."',";
		$sql.= "'4','education_level',";
		$sql.= "'".$_POST['education_level']."',";
		$sql.= "1";
		$sql.= ")";
		$sql = str_replace("''","null",$sql);
		$result = execSql($db, $sql, $debug);
		} else {
			$error_flag = $error_flag + 1;
		}
		fputs($outfile,date('Y-m-d h:i:s')." 3d. -- ".$sql."\n\n");
		if ($error_flag > 0) {
			$eventid = 'event1';
		} else {
			$eventid = 'get_citizen_financial';
		}
	break;

	break;
	case 'get_household':

		$sql = 'INSERT INTO event_detail_log (trans_id, event_id, status, applicant_id, user_id, event_timestamp ) values (';
		$sql.= "'".$transid."',";
		$sql.= "'".$eventid."',";
		$sql.= "'A',";
		$sql.= "'".$applId."',";
		$sql.= "'".$_SESSION['userid']."',";
		$sql.= "now()";
		$sql.= ")";
		$sql = str_replace("''","null",$sql);
		$result = execSql($db, $sql, $debug);

		if ($_POST['first_name']) {
		$sql = 'INSERT INTO applicant_household ( applicant_id, trans_id, first_name, last_name, relationship ) VALUES (';
		$sql.= "'".$applId."','".$transid."',";
		$sql.= "'".$_POST['first_name']."',";
		$sql.= "'".$_POST['last_name']."',";
		$sql.= "'".$_POST['relationship']."'";
		$sql.= ")";
		$sql = str_replace("''","null",$sql);
		$result = execSql($db, $sql, $debug);
		fputs($outfile,date('Y-m-d h:i:s')." 3a. -- ".$sql."\n\n");
		} else {
			$error_flag = $error_flag + 1;
		}


	break;
	case 'get_citizen_financial':

		$sql = 'INSERT INTO event_detail_log (trans_id, event_id, status, applicant_id, user_id, event_timestamp ) values (';
		$sql.= "'".$transid."',";
		$sql.= "'".$eventid."',";
		$sql.= "'A',";
		$sql.= "'".$applId."',";
		$sql.= "'".$_SESSION['userid']."',";
		$sql.= "now()";
		$sql.= ")";
		$sql = str_replace("''","null",$sql);
		$result = execSql($db, $sql, $debug);

		if ($_POST['annual_wages']) {
		$sql = 'INSERT INTO applicant_financial ( applicant_id, trans_id, annual_wages, annual_alimony ) VALUES (';
		$sql.= "'".$applId."','".$transid."',";
		$sql.= "'".$_POST['annual_wages']."',";
		$sql.= "'".$_POST['annual_alimony']."'";
		$sql.= ")";
		$sql = str_replace("''","null",$sql);
		$result = execSql($db, $sql, $debug);
		fputs($outfile,date('Y-m-d h:i:s')." 3a. -- ".$sql."\n\n");
		} else {
			$error_flag = $error_flag + 1;
		}
		if ($error_flag > 0) {
			$eventid = 'get_citizen_financial';
		} else {
			$eventid = 'get_household';
		}

	break;
}

$post0 = " { ";
$eventsql = "SELECT * from event WHERE eventid = '".$eventid."'";
$eventresult = execSql($db, $eventsql, $debug) ;
list ($whatever, $event_role, $event, $event_name, $version, $event_title, $event_header) = pg_fetch_row($eventresult, 0);

$post1["apikey"] = $transid;
$post1["event"] = $event;
$post1["event_name"] = $event_name;
$post1["version"] = $version;
$post1["title"] = $event_title;
$post1["header"] = $event_header;
$post0.= ' "apikey" : "'.$transid.'", ';
$post0.=' "event" : "'.$event.'", ';
$post0.=' "event_name" : "'.$event_name.'", ';
$post0.=' "version" : "'.$version.'", ';
$post0.=' "title" : "'.$event_title.'", ';
$post0.=' "header" : "'.$event_header.'", ';
$post0.=' "username" : "jsmith1234", ';
$post0.=' "useremail" : "jsmith@gmail.com", ';
$post0.=' "response_cd" : "0", ';
$post0.=' "xa_id" : "'.$transid.'", ';
$post0.=' "applicant_id" : "'.$applId.'", ';

/* -- event element -- */
$event_elementsql = "SELECT element, element_value from event_element WHERE eventid = '".$eventid."' ORDER BY sort_order";
$event_elementresult = execSql($db, $event_elementsql, $debug) ;

   $row1 = 0;
   $array1 = '';
   while ($row = pg_fetch_array($event_elementresult,$row1)) {
   list ($element, $element_value) = pg_fetch_row($event_elementresult, $row1);
      if ($element_value == 'array') {
			$array1.= '"'.$element.'" : { ';
         $event_element_typesql = "SELECT element_type, element_type_value from event_element_type WHERE eventid = '".$eventid."' and element = '".$element."' and coalesce(status,'A') = 'A' ORDER BY sort_order";
         $event_element_typeresult = execSql($db, $event_element_typesql, $debug) ;
         $row2 = 0;
   $array2 = '';
         while ($row = pg_fetch_array($event_element_typeresult,$row2)) {
         list ($element_type, $element_type_value) = pg_fetch_row($event_element_typeresult, $row2);
            if ($element_type_value == 'array') {
			$array2.= '"'.$element_type.'" : { ';
               $event_element_type_itemsql = "SELECT element_type_item, element_type_item_value from event_element_type_item WHERE eventid = '".$eventid."' and element = '".$element."' and element_type = '".$element_type."' ORDER BY sort_order";
               $event_element_type_itemresult = execSql($db, $event_element_type_itemsql, $debug) ;
               $row3 = 0;
   $array3 = '';
               while ($row = pg_fetch_array($event_element_type_itemresult,$row3)) {
               list ($element_type_item, $element_type_item_value) = pg_fetch_row($event_element_type_itemresult, $row3);
                  if ($element_type_item_value == 'array') {
			$array3.= '"'.$element_type_item.'" : { ';



                     $event_element_type_item_datasql = "SELECT element_type_item_data, element_type_item_data_value from event_element_type_item_data WHERE eventid = '".$eventid."' and element = '".$element."' and element_type = '".$element_type."' and element_type_item = '".$element_type_item."' ORDER BY sort_order";
			if ($element == 'response') {

//				echo "===========>    ".$event_element_type_item_datasql."<br><br>";
			}
                     $event_element_type_item_dataresult = execSql($db, $event_element_type_item_datasql, $debug) ;
                     $row4 = 0;
   $array4 = '';
                     while ($row = pg_fetch_array($event_element_type_item_dataresult,$row4)) {
                     list ($element_type_item_data, $element_type_item_data_value) = pg_fetch_row($event_element_type_item_dataresult, $row4);
                        if ($element_type_item_data_value == 'array') {
			$array4.= '"'.$element_type_item_data.'" : { ';




                           $event_element_type_item_data_conssql = "SELECT element_type_item_data_cons, element_type_item_data_cons_value from event_element_type_item_data_cons WHERE eventid = '".$eventid."' and element = '".$element."' and element_type = '".$element_type."' and element_type_item = '".$element_type_item."' and element_type_item_data ='".$element_type_item_data."' ORDER BY sort_order";
                     $event_element_type_item_data_consresult = execSql($db, $event_element_type_item_data_conssql, $debug) ;
                     $row5 = 0;
			$array5 = '';
                     while ($row = pg_fetch_array($event_element_type_item_data_consresult,$row5)) {
                     list ($element_type_item_data_cons, $element_type_item_data_cons_value) = pg_fetch_row($event_element_type_item_data_consresult, $row5);
                        if ($element_type_item_data_cons_value == 'array') {
                        } else {
			$array5.= '"'.$element_type_item_data_cons.'" : "'.$element_type_item_data_cons_value.'" ,';
                        }
				$row5 = $row5 + 1;
                      }
			$array5 = substr($array5,0,-1).' } ,';
			$array4.= $array5 ;

                        } else {
// value would be here xxx  
			if ($element == 'response' and $element_type_item_data == 'value') {
//			echo 'ELEMENT '.$element.'     "'.$element_type_item_data.'" : "'.$element_type_item_data_value.'" ,<br>';
				switch ($element_type_item) {
					case 'userid':
					$array4.= '"'.$element_type_item_data.'" : "'.$applId.'" ,';
					break;
					case 'user_role':
					$array4.= '"'.$element_type_item_data.'" : "citizen" ,';
					break;
					case 'user_firstname':
					$lookupsql = "SELECT first_name FROM applicant_demo where applicant_id = '".$applId."'";
					$result = execSql($db, $lookupsql , $debug);
					list ($lookup_value) = pg_fetch_row($result,0);
					$array4.= '"'.$element_type_item_data.'" : "'.$lookup_value.'" ,';
					break;
					case 'user_lastname':
					$lookupsql = "SELECT last_name FROM applicant_demo where applicant_id = '".$applId."'";
					$result = execSql($db, $lookupsql , $debug);
					list ($lookup_value) = pg_fetch_row($result,0);
					$array4.= '"'.$element_type_item_data.'" : "'.$lookup_value.'" ,';
					break;
					default:
					$array4.= '"'.$element_type_item_data.'" : "'.$element_type_item_data_value.'" ,';
				}
			} else {
			$array4.= '"'.$element_type_item_data.'" : "'.$element_type_item_data_value.'" ,';
			} 
                        }
				$row4 = $row4 + 1;
                     }
			$array4 = substr($array4,0,-1).' } ,';

			$array3.= $array4 ;
                  } else {
			$array3.= '"'.$element_type_item.'" : "'.$element_type_item_value.'" ,'; 
                  }
			$row3 = $row3 + 1;
               }
			$array3 = substr($array3,0,-1).' } ,';
			$array2.= $array3 ;
            } else {
            }
		$row2 = $row2 + 1;
         }
			$array2 = substr($array2,0,-1).' } ,';
			$array1.= $array2 ;
      } else {
      }
	$row1 = $row1 + 1;
   }

			$array1 = substr($array1,0,-1).' } ';
			$post0.= $array1;

$post1["navigation"] = $nav_array;
$post1["message"] = $msg_array;
$post1["field"] = $fld_array;

$outArray = json_encode($post1, true);
fputs($outfile,date('Y-m-d h:i:s')." 4. -- ".$japArray."\n\n");
/*
*/
// echo $outArray ;
echo $post0 ;

?>

