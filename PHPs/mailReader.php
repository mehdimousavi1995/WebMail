<?php

include('../Includes/db_connection.php');

if (isset($_GET['from']) && isset($_GET['email']) && $_GET['email'] == 'true' && isset($_GET['date']))
{
    $from = $_GET['from'];
    $date = $_GET['date'];

    $query_select = "SELECT * FROM email ";
    $query_select .= "WHERE sender = '{$from}' and sending_time={$date}";

    $result = mysqli_query($connection, $query_select);
    $row = mysqli_fetch_assoc($result);

    $xml_output .= '<mail>';
    $xml_output .= '<from>' . $row['sender'] . '</from>';
    $xml_output .= '<to>' . $id . '</to>';
    $xml_output .= '<date>' . $row['sending_time'] . '</date>';
    $xml_output .= '<text>' . htmlspecialchars($row['content']) . '</text>';
    $xml_output .= '<attachments>' . '<attach>' . $row['attachment'] . '</attach>' . '</attachments></mail>';

}



include('../Includes/db_connection_close.php');
