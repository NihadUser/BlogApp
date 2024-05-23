<?php
session_start();
date_default_timezone_set("Asia/Baku");
#database php
include "database.php";
#helper
include "helper.php";
#header part
include "header.php";
#navbar part
include "nav.php";
$db = sqlConnection();
?>