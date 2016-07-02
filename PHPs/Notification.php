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
    $query_select = "SELECT * FROM myContact WHERE user_contact='{$email}' and is_accepted=0 ";
    $result = mysqli_query($connection, $query_select);
    $xml_output = xml_builder_Notification($result, $connection);
}

//CONFIRM THE REQUEST
if (isset($_GET['add'])) {
    $username = $_GET['add'];
    $query_update = Update_query_myContact($username, $email);
    $result = mysqli_query($connection, $query_update);
    if ($result)
        return;

}

//REJECT THE REQUEST
if (isset($_GET['reject'])) {
    $username = $_GET['reject'];
    $query_delete = Delete_query_myContact($username, $email);
    $result = mysqli_query($connection, $query_delete);
    if ($result)
        return;
}

//BLOCK USER
if (isset($_GET['block'])) {
    $username = $_GET['block'];

    //first delete the user from myContact table
    $query_delete = Delete_query_myContact($username, $email);
    $result_del = mysqli_query($connection, $query_delete);

    //then add him to block_list table
    $query_insert = Insert_query_blockList($email, $username);
    $result_in = mysqli_query($connection, $query_insert);
    if ($result_in && $result_del)
        return;

}

include('../Includes/db_connection_close.php');
echo "<?xml version='1.0' encoding='UTF-8'?>";
echo $xml_output;