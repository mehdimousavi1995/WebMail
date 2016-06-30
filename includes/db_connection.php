<?php
$db_host = "localhost";
$db_user = "mehdi";
$db_pass = "password";
$db_name = "web_mail";
$connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if(mysqli_connect_errno())
	die("Database conncetion failed:").
	mysqli_connect_error().
	"(".mysqli_connect_errno().")";
