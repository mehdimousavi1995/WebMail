<?php
header('Content-type: text/xml');
session_start();
include('../Includes/db_connection.php');
include('../Includes/functions.php');

$xml_output = '<mails>';

if (isset($_GET['from'])) {
    $from = $_GET['from'];
    $date = $_GET['date'];


    $query_select = "SELECT * FROM email ";
    $query_select .= "WHERE sender = '{$from}' and sending_time = '{$date}' ";

    $result = mysqli_query($connection, $query_select);

    while ($row = mysqli_fetch_assoc($result)) {
        $xml_output .= '<mail>';
        $xml_output .= '<from>' . $row['sender'] . '</from>';
        $xml_output .= '<subject>' . $row['subject'] . '</subject>';
        $xml_output .= '<date>' . $row['sending_time'] . '</date>';
        $xml_output .= '<text>' . htmlspecialchars($row['content']) . '</text>';
    }


}
$xml_output .= '</mails>';

echo "<?xml version='1.0' encoding='UTF-8'?>";
echo $xml_output;
header("LOCATION: ../HTMLs/ReadEmail.html");
include('../Includes/db_connection_close.php');
