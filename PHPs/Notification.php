<?php
header('Content-type: text/xml');
session_start();
include('../Includes/db_connection.php');
include('../Includes/functions.php');

$email = '';
$xml_output = '';

if (isset($_COOKIE['id'])) {
    $email = $_COOKIE['id'];
} else if (isset($_SESSION['id'])) {
    $email = $_SESSION['id'];
}
//SHOW NOTIFICATIONS
if (isset($_GET['Notification'])) {
    $query_select = "SELECT * FROM myContact WHERE _user='{$email}' and is_accepted=0 ";
    $result = mysqli_query($connection, $query_select);
    $xml_output = xml_builder_Notification($result, $connection);
}

//CONFIRM THE REQUEST
if (isset($_GET['add'])) {
    $username = $_GET['add'];
    $query_update = Update_query_myContact($username , $email);
    $result = mysqli_query($connection, $query_update);
    if ($result)
        return;

}

//REJECT THE REQUEST
if (isset($_GET['reject'])) {
    $username = $_GET['reject'];
    $query_delete = Delete_query_myContact($username , $email);
    $result = mysqli_query($connection, $query_delete);
    if ($result)
        return;
}

//BLOCK USER
if (isset($_GET['block'])) {
    $query_select = "SELECT * FROM myContact WHERE _user='{$email}' and is_accepted=0 ";
    $result = mysqli_query($connection, $query_select);
    $xml_output = xml_builder_Notification($result, $connection);
}

include('../Includes/db_connection_close.php');
echo "<?xml version='1.0' encoding='UTF-8'?>";
echo $xml_output;