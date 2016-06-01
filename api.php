<?php
 
// get the HTTP method, path and body of the request
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
$input = json_decode(file_get_contents('php://input'),true);
 
// connect to the mysql database
// $link = mysqli_connect('localhost', 'user', 'pass', 'dbname');
// mysqli_set_charset($link,'utf8');
 $connection = pg_connect("host=localhost dbname=safehaven user=postgres") or die ("Unable to connect!");

 
// retrieve the table and key from the path
$table = str_replace('/[^a-z0-9_]+/i','',array_shift($request));
$key = array_shift($request)+0;
 
// escape the columns and values from the input object
$columns = str_replace('/[^a-z0-9_]+/i','',array_keys($input));
$values = array_map(function ($value) use ($connection) {
  if ($value===null) return null;
//  return mysqli_real_escape_string($connection,(string)$value);
  return pg_escape_string($connection,(string)$value);
},array_values($input));
 
// build the SET part of the SQL command
$set = '';
for ($i=0;$i<count($columns);$i++) {
  $set.=($i>0?',':'').'`'.$columns[$i].'`=';
  $set.=($values[$i]===null?'NULL':'"'.$values[$i].'"');
}
 
// create SQL based on HTTP method
switch ($method) {
  case 'GET':
    $sql = "select * from `$table`".($key?" WHERE id=$key":''); 
  break;
  case 'PUT':
    $sql = "update `$table` set $set where id=$key"; 
  break;
  case 'POST':
    $sql = "insert into `$table` set $set"; 
  break;
  case 'DELETE':
    $sql = "delete `$table` where id=$key"; 
  break;
}
 
// excecute SQL statement
$result = pg_query($connection,$sql);
 
// die if SQL statement failed
if (!$result) {
  http_response_code(404);
//  die(mysqli_error());
  die(pg_result_error($result));
}
 
// print results, insert id or affected row count
if ($method == 'GET') {
  if (!$key) echo '[';
  for ($i=0;$i<mysqli_num_rows($result);$i++) {
    echo ($i>0?',':'').json_encode(mysqli_fetch_object($result));
  }
  if (!$key) echo ']';
} elseif ($method == 'POST') {
  echo mysqli_insert_id($connection);
} else {
  echo mysqli_affected_rows($connection);
}
 
// close mysql connection
mysqli_close($connection);
