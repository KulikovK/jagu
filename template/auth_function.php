<?php
$AuthTxtWarning = "";


if (isset($_POST['Login']) And isset($_POST['Password'])) {
    /*Проверка капчи*/
    if (isset($_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response']) {
        $secret = '6LcBPfwZAAAAAHkoaDqGVrqX6O1ghUHKSAWt-id1';
        $ip = $_SERVER['REMOTE_ADDR'];
        $response = $_POST['g-recaptcha-response'];
        $rsp = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$ip");
        $arr = json_decode($rsp, TRUE);
        if ($arr['success']) {
// Проверяем: ввел-ли пользователь пароль
            if ($_POST['Login'] and $_POST['Password']) {
                $login = $_POST['Login'];
                $password = $_POST['Password'];
                if(!AuthorizationUser($login, $password))
                    $AuthTxtWarning= 'Неправильный логин или пароль!';


            } else {
                $AuthTxtWarning .= 'Вы не указали логин или пароль!';
            }

        } else {
            $AuthTxtWarning = "Не коорекная капча!";
        }
    } else {
        $AuthTxtWarning = 'Вы забыли ввести капчу!';
    }
}


