<?php

ob_start();
   
   phpinfo();
   $php_info .= ob_get_contents();
       
ob_end_clean();

$php_info    = str_replace(" width=\"600\"", " width=\"786\"", $php_info);
$php_info    = str_replace("</body></html>", "", $php_info);

$php_info    = str_replace(";", "; ", $php_info);
$php_info    = str_replace(",", ", ", $php_info);

$offset          = strpos($php_info, "<table");

print substr($php_info, $offset);

?> 
