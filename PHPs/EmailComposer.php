<?php
include('../Includes/db_connection.php');
include('../Includes/functions.php');
session_start();

$email = '';
if ((!isset($_COOKIE['login'])) && (!isset($_SESSION['login'])))
    header("LOCATION: ../HTMLs/LoginRegister.html");

if (isset($_COOKIE['id'])) {
    $email = $_COOKIE['id'];
} else if (isset($_SESSION['id'])) {
    $email = $_SESSION['id'];
}


if (isset($_POST['submit'])) {
    $receiver = $_POST['to'];
    $query_select = "SELECT * FROM myContact WHERE _user='{$email}' and user_contact = '{$receiver}' ";
    $result = mysqli_query($connection, $query_select);
    $exist = mysqli_fetch_assoc($result);
    if (!isset($exist['_user'])) {
        echo 'this email do not exist in your contacts ... <br><a href="../HTMLs/ComposeEmail.html">Inbox</a>';
        return;
    }

    $subject = $_POST['subject'];
    $to = $_POST['to'];
    $text = $_POST['text'];
    $attachment = 'mehdi';
    $date = date("Y-m-d h:i");

    if (isset($_COOKIE['id']))
        $from = $_COOKIE['id'];
    else if (isset($_SESSION['id']))
        $from = $_SESSION['id'];

    $query_insert = Insert_query_email($from, $to, $subject, 0, $attachment, $text, 0, $date);
    $result = perform_query($connection, $query_insert);
    if ($result)
        header("LOCATION: ../HTMLs/inbox.html");

}
include('../Includes/db_connection_close.php');
