<?php

//************* *********************************************CRUD OPERATION FOR USERS***************************************************
function Insert_query_users($first_name, $last_name, $email, $password, $image_link, $background_link, $DateTime)
{
    $query_insert = "INSERT INTO users";
    $query_insert .= "(";
    $query_insert .= "FirstName,LastName,Email,Password,Image_Link,background_Link,Last_time_loged_in,last_time_refreshed";
    $query_insert .= ") VALUES (";
    $query_insert .= "'{$first_name}','{$last_name}','{$email}','{$password}','{$image_link}','{$background_link}','{$DateTime}','{$DateTime}'";
    $query_insert .= ")";

    return $query_insert;
}

function Update_query_users($DateTime, $email)
{
    $query_update = "UPDATE users SET ";
    $query_update .= "Last_time_loged_in = '{$DateTime}', ";
    $query_update .= "last_time_refreshed = '{$DateTime}' ";
    $query_update .= "WHERE email = '{$email}' ";
    return $query_update;
}

function Delete_query_users()
{
}

function Select_query_users($email)
{
    $query_select = "SELECT * FROM users ";
    $query_select .= "WHERE Email = '{$email}'";
    return $query_select;
}

//******************************************************************** END ********************************************************************

//**********************************************************CRUD OPERATION FOR EMAIL *******************************************************************************
function Insert_query_email($from, $to, $subject, $spam, $attachment, $text, $isReaded, $date)
{
    $query_insert = "INSERT INTO email ";
    $query_insert .= "(";
    $query_insert .= "sender,receiver,subject,spam,attachment,content,isReaded,sending_time";
    $query_insert .= ") VALUES (";
    $query_insert .= "'{$from}','{$to}','{$subject}','{$spam}','{$attachment}','{$text}','{$isReaded}','{$date}'";
    $query_insert .= ")";

    return $query_insert;
}

function Delete_query_email()
{
}

function Update_query_email()
{
}

function Select_query_email($email, $senderOrReceiver)
{
    $query_select = "SELECT * FROM Email ";
    $query_select .= "WHERE $senderOrReceiver = '{$email}'";
    return $query_select;
}

//*********************************************************************** END *************************************************************


function upload_image($email)
{
    $target_dir = "uploads/";
    $image_link = $target_dir . $email . '_' . basename($_FILES["image"]["name"]);

    $target_file = $image_link;
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
//            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
//            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        }
    }
    return $image_link;

}

function perform_query($connection, $query)
{
    return mysqli_query($connection, $query);
}

function set_session_login($first_name, $last_name, $email)
{
    $_SESSION['login'] = 'true';
    $_SESSION['full_name'] = $first_name . ' ' . $last_name;
    $_SESSION['id'] = $email;
}

function set_cookie_remember_me($expiration, $first_name, $last_name, $email)
{
    setcookie('login', 'true', $expiration);
    setcookie('full_name', $first_name . ' ' . $last_name, $expiration);
    setcookie('id', $email, $expiration);//in db, this field is unique
}

function unset_cookie_remember_me()
{
    $past_time = time() - 9999;

    setcookie('login', null, $past_time);
    setcookie('full_name', null, $past_time);
    setcookie('id', null, $past_time);
}

function xml_builder_mails_profile($result, $email, $nom)
{
    $numberOfMail = (int)$nom;
    $xml_output = '<mails>';
    while (($row = mysqli_fetch_assoc($result)) && ($numberOfMail)) {
        $xml_output .= '<mail>';
        $xml_output .= '<from>' . $row['sender'] . '</from>';
        $xml_output .= '<to>' . $email . '</to>';
        $xml_output .= '<date>' . $row['sending_time'] . '</date>';
        $xml_output .= '<text>' . htmlspecialchars($row['content']) . '</text>';
        $xml_output .= '<attachments>' . '<attach>' . $row['attachment'] . '</attach>' . '</attachments></mail>';
        $numberOfMail--;
    }
    $xml_output .= '</mails>';
    return $xml_output;
}

function xml_builder_mails_send($result, $email, $nom)
{
    $numberOfMail = (int)$nom;
    $xml_output = '<mails>';
    while (($row = mysqli_fetch_assoc($result)) && ($numberOfMail)) {
        $xml_output .= '<mail>';
        $xml_output .= '<from>' . $row['receiver'] . '</from>';
        $xml_output .= '<to>' . $email . '</to>';
        $xml_output .= '<date>' . $row['sending_time'] . '</date>';
        $xml_output .= '<text>' . htmlspecialchars($row['content']) . '</text>';
        $xml_output .= '<attachments>' . '<attach>' . $row['attachment'] . '</attach>' . '</attachments></mail>';
        $numberOfMail--;
    }
    $xml_output .= '</mails>';
    return $xml_output;
}


function xml_builder_data($connection, $email)
{
    $query_select = Select_query_users($email);

    $result = perform_query($connection, $query_select);
    $row = mysqli_fetch_assoc($result);
    $xml_output = '<data>';
    $xml_output .= '<img>' . $row['Image_Link'] . '</img>';
    $xml_output .= '<first>' . $row['FirstName'] . '</first>';
    $xml_output .= '<last>' . $row['LastName'] . '</last>';
    $xml_output .= '<username>' . $row['Email'] . '</username>';
    $xml_output .= '<contacts>';

    $query_select = "SELECT user_contact FROM myContact JOIN users ";
    $query_select .= "WHERE _user='{$email}' and Email='{$email}'";

    $result1 = mysqli_query($connection, $query_select);

    while ($row = mysqli_fetch_assoc($result1)) {

        $user_contact = $row['user_contact'];
        $query_select = Select_query_users($user_contact);
        $res = perform_query($connection, $query_select);

        while ($r = mysqli_fetch_assoc($res)) {
            $xml_output .= '<contact><img>' . $r['Image_Link'] . '</img>';
            $xml_output .= '<first>' . $r['FirstName'] . '</first>';
            $xml_output .= '<last>' . $r['LastName'] . '</last>';
            $xml_output .= '<username>' . $r['Email'] . '</username></contact>';
        }
    }
    $xml_output .= '</contacts></data>';
    return $xml_output;
}

function xml_builder_users($result)
{
    $xml_output = '<users>';
    while ($row = mysqli_fetch_assoc($result)) {
        $xml_output .= '<user>';
        $xml_output .= '<img>' . $row['Image_Link'] . '</img>';
        $xml_output .= '<first>' . $row['FirstName'] . '</first>';
        $xml_output .= '<last>' . $row['LastName'] . '</last>';
        $xml_output .= '<username>' . $row['Email'] . '</username></user>';
    }
    $xml_output .= '</users>';
    return $xml_output;

}