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

if (isset($_GET['unblock'])) {
    $username = $_GET['unblock'];
    //first delete user from block_list table
    $query_delete = Delete_query_blockList($username, $email);
    $result_del = mysqli_query($connection, $query_delete);
    //then add him to myContact table
    $query_insert_myContact = Insert_query_myContact($email, $username);
    $result_ins = mysqli_query($connection, $query_insert_myContact);
    if ($result_del && $result_ins)
        return;
}

if (isset($_GET['block'])) {
    $query_select = Select_query_blockList($email);
    $result = mysqli_query($connection, $query_select);
    $xml_output = xml_builder_Block($result, $connection);
}
include('../Includes/db_connection_close.php');

echo "<?xml version='1.0' encoding='UTF-8'?>";
echo $xml_output;