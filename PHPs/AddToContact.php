<?php
include('../Includes/db_connection.php');
if(isset($_GET['add']))
{
    $username = $_GET['add'];

    if(isset($_COOKIE['id']))
    {
        
         

        $query_insert = "INSERT INTO myContact";
        $query_insert .= "(";
        $query_insert .= "_user,user_contact,is_accepted";
        $query_insert .= ") VALUES (";
        $query_insert .= "'{$me}','{$username}',0 ";
        $query_insert .= ")";

        $result = mysqli_query($connection, $query_insert);
    }

}

include('../Includes/db_connection_close.php');