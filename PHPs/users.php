<?php
session_start();
header('Content-type: text/xml');
include('../Includes/db_connection.php');
include('../Includes/functions.php');

$email='';
if (isset($_COOKIE['id'])) {
    $email = $_COOKIE['id'];
} else if (isset($_SESSION['id'])) {
    $email = $_SESSION['id'];
}



$query_select = "SELECT * FROM users  ";
$result = mysqli_query($connection, $query_select);
$xml_output = xml_builder_users($result,$email);

include('../Includes/db_connection_close.php');
echo "<?xml version='1.0' encoding='UTF-8'?>";
echo $xml_output;

