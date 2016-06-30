<?php
include('../includes/db_connection.php');

//get email coming from user
//check if email already exist in contacts then client can send email
//if email already not exist back to composeEmail.html page and show the proper massage


if (isset($_POST['submit'])) {
    

    $from = $_COOKIE['id'];
    $subject = $_POST['subject'];
    $to = $_POST['to'];
    $date = $_POST['attachment'];
    $text = $_POST['text'];
    if (isset($_COOKIE['id']))
    {


        $from = $_COOKIE['id'];
        $subject = $_POST['subject'];
        $to = $_POST['to'];
//        $date = $_POST['attachment'];
        $text = $_POST['text'];

        $query_insert = "INSERT INTO email ";
        $query_insert .= "(";
        $query_insert .= "sender,receiver,subject,spam,attachment,content,isReaded,sending_time";
        $query_insert .= ") VALUES (";
        $query_insert .= "'{$from}','{$to}','{$subject}',0,'mehdi.jpg','{$text}',0,'1394-11-04 22:11:23'";
        $query_insert .= ")";
        $result = mysqli_query($connection, $query_insert);
        if($result)
            header("LOCATION: ../HTMLs/inbox.html");
    }


}
include('../includes/db_connection_close.php');
