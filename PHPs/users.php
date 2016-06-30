<?php
header('Content-type: text/xml');
include('../includes/db_connection.php');
include('../includes/functions.php');

//if(isset($_GET['users'])&&$_GET['users']=='true')

$query_select = "SELECT * FROM users  ";
$result = mysqli_query($connection, $query_select);
$xml_output = '<users>';
while ($row = mysqli_fetch_assoc($result)) {
    $xml_output .= '<user>';
    $xml_output .= '<img>' . $row['Image_Link'] . '</img>';
    $xml_output .= '<first>' . $row['FirstName'] . '</first>';
    $xml_output .= '<last>' . $row['LastName'] . '</last>';
    $xml_output .= '<username>' . $row['Email'] . '</username></user>';
}
$xml_output .= '</users>';
include('../includes/db_connection_close.php');
echo "<?xml version='1.0' encoding='UTF-8'?>";
echo $xml_output;

