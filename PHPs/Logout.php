<?php
include('../Includes/functions.php');
session_start();//unset all global session
session_destroy();//unset session
unset_cookie_remember_me();
header("LOCATION: ../HTMLs/LoginRegister.html");
