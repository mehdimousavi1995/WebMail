<?php
include('../Includes/db_connection.php');
include('../Includes/functions.php');
session_start();

if ((!isset($_COOKIE['login'])) && (!isset($_SESSION['login'])))
    header("LOCATION: ../HTMLs/LoginRegister.html");

if (isset($_POST['submit'])) {
    $subject = $_POST['subject'];
    $to = $_POST['to'];
    $text = $_POST['text'];
    $attachment = 'mehdi';
    $date = date("Y-m-d h:i");
    
    if (isset($_COOKIE['id']))
        $from = $_COOKIE['id'];
    else if (isset($_SESSION['id']))
        $from = $_SESSION['id'];
    
    $query_insert = Insert_query_email($from,$to,$subject,0,$attachment,$text,0,$date);
    $result = perform_query($connection, $query_insert);
    if ($result)
        header("LOCATION: ../HTMLs/inbox.html");
}
include('../Includes/db_connection_close.php');
