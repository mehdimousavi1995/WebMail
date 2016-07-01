<?php
session_start();
$_SESSION = array();
include("../Captcha/CaptchaBuilder.php");
$_SESSION['captcha'] = simple_php_captcha();

echo '<img src="' . $_SESSION['captcha']['image_src'] . '" style="width : 110px;height:32px;" ">';




