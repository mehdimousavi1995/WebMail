<?php
session_start();
include('../Includes/db_connection.php');
include('../Includes/functions.php');


if ((!isset($_COOKIE['login'])) && (!isset($_SESSION['login'])))
    header("LOCATION: ../HTMLs/LoginRegister.html");
if (isset($_COOKIE['id'])) {
    $email = $_COOKIE['id'];
} else if (isset($_SESSION['id'])) {
    $email = $_SESSION['id'];
}


if (isset($_GET['add'])) {
    $has_contact = false;
    $username = $_GET['add'];

    $query_select = Select_query_myContact($email);
    $result_select = perform_query($connection, $query_select);

    while ($row = mysqli_fetch_assoc($result_select))
        if ($row['user_contact']==$username)
            $has_contact = true;


    //if he was not in my contact
    if(!$has_contact)
    {
        $query_insert = Insert_query_myContact($email, $username);
        $result = perform_query($connection, $query_insert);
    }


}

include('../Includes/db_connection_close.php');