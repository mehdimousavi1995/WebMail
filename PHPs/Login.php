<?php
include('../includes/db_connection.php');
include('../includes/functions.php');
$first_name = '';
$last_name = '';
$email = '';
$password = '';
$image_link = '';
$last_time = '1374';
$background_link = '';


if (isset($_POST['Register']) && isset($_POST['firstname']) &&
    isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['pass'])) {
    $first_name = $_POST['firstname'];
    $last_name = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['pass'];


    $query_select = "SELECT * FROM users ";
    $query_select .= "WHERE Email = '{$email}'";

    $result = mysqli_query($connection, $query_select);
    $em = mysqli_fetch_assoc($result);
    
    if ($result && isset($em['Email'])) {
        echo 'Email is already exist ';
        echo '<a href="../HTMLs/LoginRegister.php">LoginRegister</a>';
    } else {
        $DateTime =  date("Y-m-d h:i:s");


        $target_dir = "uploads/";
        $image_link = $target_dir . $email . '_' . basename($_FILES["image"]["name"]);

        $target_file = $image_link;
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            }
        }

        $query_insert = "INSERT INTO users";
        $query_insert .= "(";
        $query_insert .= "FirstName,LastName,Email,Password,Image_Link,background_Link,Last_time_loged_in,last_time_refreshed";
        $query_insert .= ") VALUES (";
        $query_insert .= "'{$first_name}','{$last_name}','{$email}','{$password}','{$image_link}','{$background_link}','{$DateTime}','{$DateTime}'";
        $query_insert .= ")";
        $result = mysqli_query($connection, $query_insert);

        $expiration = time() + (60 * 60 * 24 * 7 * 4); // 60*60*24*7*4 second == 1 month
        setcookie('login', 'true', $expiration);
        setcookie('full_name', $first_name, $expiration);
        setcookie('id', htmlspecialchars($email), $expiration);//in db, this field is unique
        header("LOCATION: ../HTMLs/inbox.html");
    }
}
if (isset($_POST['Login'])) {
    $email = $_POST['email'];
    $password = $_POST['pass'];
    $query_select = "SELECT * FROM users  ";
    $query_select .= "WHERE Email = '{$email}'";

    $result = mysqli_query($connection, $query_select);
    $em = mysqli_fetch_assoc($result);

    if ($result && isset($em)) {
        if ($em['Email'] == $email && $em['Password'] == $password) {
            $expiration = time() + (60 * 60 * 24 * 7 * 4); // 60*60*24*7*4 second == 1 month
            setcookie('login', 'true', $expiration);
            setcookie('full_name', 'khanamoo', $expiration);
            setcookie('id', $email, $expiration);//in db, this field is unique
            $DateTime =  date("Y-m-d h:i:s");

            $query_update = "UPDATE users SET ";
            $query_update .= "Last_time_loged_in = '{$DateTime}', ";
            $query_update .= "last_time_refreshed = '{$DateTime}' ";
            $query_update .= "WHERE email = '{$email}' ";
            $result_update = mysqli_query($connection, $query_update);

            header("LOCATION: ../HTMLs/inbox.html");
        } else if ($em['Email'] != $email || $em['Password'] != $password) {
            echo 'user name or password is wrong... ';
            echo '<a href="../HTMLs/LoginRegister.php">LoginRegister</a>';
        }
    }
}
include('../includes/db_connection_close.php');







//mysqli_real_escape_string($connection, menu_name)--- just for string
// for integer value just put int before
//$sia=(int) 6
//prepared statement in mysql using ??? mark to make query faster
//$safe_subject_id---> is good name for scaping variable


//$query_insert = "INSERT INTO users";
//$query_insert .= "(";
//$query_insert .= "first_name,last_name,username,password,email,image_link";
//$query_insert .= ") VALUES (";
//$query_insert .= "'{$first_name}','{$last_name}','{$email}','{$password}','{$email}','{$image_link}'";
//$query_insert .= ")";

//$query_update = "UPDATE users SET ";
//$query_update .= "(";
//$query_update .= "first_name = '{$first_name}', ";
//$query_update .= "last_name = '{$last_name}', ";
//$query_update .= "username = '{$user_name}', ";
//$query_update .= "password = '{$password}, ";
//$query_update .= "email = '{$email}', ";
//$query_update .= "image_link = '{$image_link}'";
//$query_update .= "WHERE id = {$id}";
//$query_update .= ")";

//$query_delete = "DELETE FROM users ";
//$query_delete .= "WHERE id = {$id} ";
//$query_delete .= "LIMIT 1";

