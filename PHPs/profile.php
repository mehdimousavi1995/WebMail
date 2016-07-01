<?php
session_start();
header('Content-type: text/xml');
include('../Includes/functions.php');
include('../Includes/db_connection.php');

$email = '';
$xml_output = '';
if ((!isset($_COOKIE['login'])) && (!isset($_SESSION['login'])))
    header("LOCATION: ../HTMLs/LoginRegister.html");
if (isset($_COOKIE['login']))
    $email = $_COOKIE['id'];
else if (isset($_SESSION['id']))
    $email = $_SESSION['id'];
$xml_output = xml_builder_data($connection, $email);
echo "<?xml version='1.0' encoding='UTF-8'?>";
echo $xml_output;
include('../Includes/db_connection_close.php');
