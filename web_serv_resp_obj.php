<?php
include("inc/qdbconnect.php");
include ("inc/gen_functions_inc_test.php");
$outfile = fopen("/tmp/resp_obj_ws_".(date('Y-m-d')).".out","a+");
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


	$form_array["element1"] = '1';
	$element_array["id"] = 'id number';
	$element_array["type"] = 'text';
	$element_array["name"] = 'first name';
	$element_array["caption"] = 'Please enter first name';
	$element_array["mandatory"] = 'T';
	$element_array["size"] = '20';
	$element_array["length"] = '15';
	$form_array["stuff1"] = $element_array;


	$form_array["element2"] = '2';
	$element_array["id"] = 'id number';
	$element_array["type"] = 'text';
	$element_array["name"] = 'last name';
	$element_array["caption"] = 'Please enter last name';
	$element_array["mandatory"] = 'T';
	$element_array["size"] = '20';
	$element_array["length"] = '15';
	$form_array["stuff2"] = $element_array;

        $posts["response id"] = $applId ;
        $posts["response type"] = 'form';
        $posts["version"] = '1.0' ;
        $posts["action"] = 'this is the action';
        $posts["method"] = 'get/post';
	$posts["element"] = $form_array ;

$outArray = json_encode($posts, true);
fputs($outfile,date('Y-m-d h:i:s')." 3. -- ".$japArray."\n\n");
echo $outArray ;

?>

