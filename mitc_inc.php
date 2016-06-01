<?php
session_start();
if (!$datastring) {
	$datastring = $_POST['datastring'];
}
echo $datastring."<br><br>";
/*
echo "mitc location 54.197.9.45:3000/";
$ch = curl_init('http://54.197.9.45:3000/');
*/
// echo "mitc location 54.236.67.240:3000/";
$ch = curl_init('http://54.236.67.240:3000/');
/*
echo "mitc location 96.127.110.203:3000/";
$ch = curl_init('http://96.127.110.203:3000/');
*/
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $datastring);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Accept: application/json',
    'Content-Length: ' . strlen($datastring))
);

$result = curl_exec($ch);

if ($_SESSION['userid'] == '00001') {
 echo $result;
}

?>
