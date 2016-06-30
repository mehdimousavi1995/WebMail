<?php
header('Content-type: text/xml');
include('../includes/db_connection.php');
include('../includes/functions.php');

if (isset($_GET['compose'])) {
    $compose = $_GET['compose'];
    if ($compose == 'true')
        header("LOCATION: ../HTMLs/ComposeEmail.html");
}


if (isset($_COOKIE['login']) && $_COOKIE['login'] == 'true') {
    $isLogin = $_COOKIE['login'];
    $id = $_COOKIE['id'];
    $query_select = "SELECT * FROM Email JOIN users ";
    $query_select .= "WHERE receiver='{$id}' and Email='{$id}'";
    $result = mysqli_query($connection, $query_select);

    $xml_output = '<mails>';
    while ($row = mysqli_fetch_assoc($result)) {
        $xml_output .= '<mail>';
        $xml_output .= '<from>' . $row['sender'] . '</from>';
        $xml_output .= '<to>' . $row['FirstName'] . '</to>';
        $xml_output .= '<date>' . $row['sending_time'] . '</date>';
        $xml_output .= '<text>' . $row['content'] . '</text>';
        $xml_output .= '<attachments>' . '<attach>' . $row['attachment'] . '</attach>' . '</attachments></mail>';
    }
    $xml_output .= '</mails>';
    echo "<?xml version='1.0' encoding='UTF-8'?>";
    echo $xml_output;
} else
    header("LOCATION: ../HTMLs/LoginRegister.html");


include('../includes/db_connection_close.php');
