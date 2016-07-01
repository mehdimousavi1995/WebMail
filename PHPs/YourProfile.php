<?php
header('Content-type: text/xml');
session_start();
include('../Includes/db_connection.php');
include('../Includes/functions.php');

if (isset($_COOKIE['id'])) {
    $email = $_COOKIE['id'];
} else if (isset($_SESSION['id'])) {
    $email = $_SESSION['id'];
}

$query_select = Select_query_users($email);
$result = perform_query($connection, $query_select);
$row = mysqli_fetch_assoc($result);

$xml_output = '<user><image>' .$row['Image_Link']. '</image>';
$xml_output .= '<first>' . $row['FirstName'] . '</first>';
$xml_output .= '<last>' .$row['LastName'] . '</last></user>';

echo "<?xml version='1.0' encoding='UTF-8'?>";

echo  $xml_output;



include('../Includes/db_connection_close.php');