<?php
session_start();
include("inc/dbconnect.php");

session_destroy();
header("Location: index.php");
?>
