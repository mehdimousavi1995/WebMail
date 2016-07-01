<?php
session_start();
$email = '';
include('../Includes/db_connection.php');
include('../Includes/functions.php');

if (isset($_COOKIE['id']))
    $email = $_COOKIE['id'];
else if (isset($_SESSION['id']))
    $email = $_SESSION['id'];


if (isset($_POST['submit'])) {
    $image_link = upload_image($email, "background/");
    $query_update = Update_query_users_back_link($image_link, $email);
    $result = perform_query($connection, $query_update);
    header("LOCATION: ../HTMLs/Inbox.html");
}

if (isset($_GET['back'])) {
    $query_select = Select_query_users($email);
    $result = perform_query($connection, $query_select);
    $em = mysqli_fetch_assoc($result);
    if (isset($em['background_Link']))
        echo $em['background_Link'];

}


include('../Includes/db_connection_close.php');




