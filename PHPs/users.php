<?php
header('Content-type: text/xml');
include('../Includes/db_connection.php');
include('../Includes/functions.php');

//if(isset($_GET['users'])&&$_GET['users']=='true')


$query_select = "SELECT * FROM users  ";
$result = mysqli_query($connection, $query_select);
$xml_output = xml_builder_users($result);

include('../Includes/db_connection_close.php');
echo "<?xml version='1.0' encoding='UTF-8'?>";
echo $xml_output;

