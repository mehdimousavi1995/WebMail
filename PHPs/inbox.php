<?php
header('Content-type: text/xml');
include('../Includes/db_connection.php');
include('../Includes/functions.php');
session_start();

$isLogin = '';
$email = '';


if (isset($_GET['compose']) && $_GET['compose'] == 'true')
    header("LOCATION: ../HTMLs/ComposeEmail.html");
if ((!isset($_COOKIE['login'])) && (!isset($_SESSION['login'])))
    header("LOCATION: ../HTMLs/LoginRegister.html");

if (isset($_COOKIE['id'])) {
    $email = $_COOKIE['id'];
} else if (isset($_SESSION['id'])) {
    $email = $_SESSION['id'];
}

if (isset($_GET['nom'])&&isset($_GET['inbox']))
{
    $xml_output='';
    $nom = $_GET['nom'];
    $query_select = Select_query_email($email,'receiver');
    $result = perform_query($connection, $query_select);
    $xml_output = xml_builder_mails_profile($result, $email,$nom);
}

//if (isset($_GET['nom']))
//    $nom = $_GET['nom'];

if (isset($_GET['nom'])&&isset($_GET['send']))
{
    $xml_output='';
    $nom = $_GET['nom'];
    $query_select = Select_query_email($email,'sender');
    $result = perform_query($connection, $query_select);
    $xml_output = xml_builder_mails_send($result, $email,$nom);
}





echo "<?xml version='1.0' encoding='UTF-8'?>";
echo $xml_output;
include('../Includes/db_connection_close.php');
