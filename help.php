<?php
session_start();
include ("inc/dbconnect.php");
$show_menu = "OFF";
include("inc/index_header_inc.php");

$help_page = "ph_".(basename($current_screen));

if (file_exists($help_page)) {
        include($help_page);
} else {



?>
<HTML>
<tr><td>
   <h1>Not Currently Available - please contact the <?php echo $city_desc ?> at support(at)<?php echo $app_locality ?>.org</h1>
<!-- </table> -->
<?
}

include "inc/footer_inc.php";
$show_menu = "ON";
?>
</body>
</HTML>
