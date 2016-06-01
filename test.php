<PRE>
<?php
$socket = fsockopen("127.0.0.1","5038", $errno, $errstr, $timeout);
fputs($socket, "Action: Login\r\n");
fputs($socket, "UserName: t\r\n");
fputs($socket, "Secret: z\r\n\r\n");
# fputs($socket, "\r\n");
# fputs($socket, "\r\n\r\n");
fputs($socket, "Action: ListCommands\r\n\r\n");
fputs($socket, "Action: Logoff\r\n\r\n");
while (!feof($socket)) {
$wrets .= fread($socket, 8192);
}
fclose($socket);
echo <<<ASTERISKMANAGEREND
ASTERISK MANAGER OUTPUT:
$wrets
ASTERISKMANAGEREND;
?>
</pre>

