<?php
header('Content-type: text/xml');

include('../includes/db_connection.php');
include('../includes/functions.php');




if (isset($_COOKIE['login'])) {
    $id = $_COOKIE['id'];
    $query_select = "SELECT * FROM users ";
    $query_select .= "WHERE Email='{$id}'";
    $result = mysqli_query($connection, $query_select);
    $row = mysqli_fetch_assoc($result);


    $xml_output = '<data>';
    $xml_output .= '<img>' . $row['Image_Link'] . '</img>';
    $xml_output .= '<first>' . $row['FirstName'] . '</first>';
    $xml_output .= '<last>' . $row['LastName'] . '</last>';
    $xml_output .= '<username>' . $row['Email'] . '</username>';
    $xml_output .= '<contacts>';


    $query_select = "SELECT user_contact FROM myContact JOIN users ";
    $query_select .= "WHERE _user='{$id}' and Email='{$id}'";
    $result = mysqli_query($connection, $query_select);


    while ($row = mysqli_fetch_assoc($result)) {
        $user_contact = $row['user_contact'];
        $query_select = "SELECT * FROM users ";
        $query_select .= "WHERE Email='{$user_contact}'";

        $res = mysqli_query($connection, $query_select);

        while ($r = mysqli_fetch_assoc($res)) {
            $xml_output .= '<contact><img>' . $r['Image_Link'] . '</img>';
            $xml_output .= '<first>' . $r['FirstName'] . '</first>';
            $xml_output .= '<last>' . $r['LastName'] . '</last>';
            $xml_output .= '<username>' . $r['Email'] . '</username></contact>';
        }
    }
    $xml_output .= '</contacts></data>';
    echo "<?xml version='1.0' encoding='UTF-8'?>";
    echo $xml_output;

} else
    header("LOCATION: ../HTMLs/LoginRegister.php");

include('../includes/db_connection_close.php');
