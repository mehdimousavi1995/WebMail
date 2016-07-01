<?php
include('../Includes/db_connection.php');
include('../Includes/functions.php');
session_start();
$first_name = '';
$last_name = '';
$email = '';
$password = '';
$image_link = '';
$last_time = '1374';
$background_link = '';

if (isset($_SESSION['captcha']['code']))
    if (strtolower($_SESSION['captcha']['code']) != strtolower($_POST['captcha'])) {
        echo 'security code is incorrect...!<br> ';
        echo '<a href="../HTMLs/LoginRegister.html">LoginRegister</a>';
        return;
    }

if (isset($_POST['Register']) && isset($_POST['firstname']) &&
    isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['pass'])
) {
    $first_name = $_POST['firstname'];
    $last_name = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['pass'];

    $query_select = Select_query_users($email);
    $result = perform_query($connection, $query_select);

    $em = mysqli_fetch_assoc($result);

    if ($result && isset($em['Email'])) {
        echo 'Email is already exist ';
        echo '<a href="../HTMLs/LoginRegister.html">LoginRegister</a>';
    } else {
        $DateTime = date("h:i Y-m-d");
        $image_link = upload_image($email);
        $query_insert = Insert_query_users($first_name, $last_name, $email, $password, $image_link, $background_link, $DateTime);
        $result = perform_query($connection, $query_insert);
        set_session_login($first_name, $last_name, $email);
        header("LOCATION: ../HTMLs/inbox.html");
    }
}
if (isset($_POST['Login'])) {
    unset_cookie_remember_me();
    $email = $_POST['email'];
    $password = $_POST['pass'];
    $query_select = Select_query_users($email);
    $result = perform_query($connection, $query_select);
    $em = mysqli_fetch_assoc($result);
    if ($result && isset($em)) {
        if ($em['Email'] == $email && $em['Password'] == $password) {
            set_session_login($first_name, $last_name, $email);
            if (isset($_POST['rememberMe']) && $_POST['rememberMe'] == 'on') {
                $expiration = time() + (60 * 60 * 24 * 7 * 4); // 60*60*24*7*4 second == 1 month
                set_cookie_remember_me($expiration, $first_name, $last_name, $email);
            }
            $DateTime = date("h:i Y-m-d");
            header("LOCATION: ../HTMLs/inbox.html");
            $query_update = Update_query_users($DateTime, $email);
            $result_update = perform_query($connection, $query_update);
        } else if ($em['Email'] != $email || $em['Password'] != $password) {
            echo 'user name or password is incorect... ';
            echo '<a href="../HTMLs/LoginRegister.html">LoginRegister</a>';
        }
    } else {
        echo 'you don\'t have any account yet... please go to LoginRegister and create new account ... <br>';
        echo '<a href="../HTMLs/LoginRegister.html">LoginRegister</a>';
    }
}
include('../Includes/db_connection_close.php');

