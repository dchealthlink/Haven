<?php

for ($i=0;$i<25;$i++) {

$newpw = "AE" .substr(base64_encode(md5(rand())), 0, 6)

echo "pw is ".$newpw."<br>";
}
?>
