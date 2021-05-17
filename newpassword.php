<?php
/*
 * Copyright (c) 2021. Kulikov K. P. [kostj1998.10.13@yandex.ru]
 */
require_once("cfg/core.php");

if(!isset($_POST['password']) || !isset($_POST['id']))
    exit('<p class="alert alert-danger">Некорректные данные!</p>');

$id = $_POST['id'];
$Pswd = $_POST['password'];

$password = password_hash($_POST['password'], PASSWORD_DEFAULT);



try {
    $db = db_connect();
    if($db==null)
        exit('<p class="alert alert-danger">Ошибка БД!</p>');

    $query = 'Update users set User_Passwd = :password, ActivStatus = :ActivStat where User_id = :id';

    $stmp = $db->prepare($query);

    $Result = $stmp->execute(Array(':password'=>$password, ':ActivStat'=>1, 'id'=>$id));

    if($Result) {
        $query = 'Delete from accauntactivation where AA_UserID = :id';
        $stmp = $db->prepare($query);

        $Result = $stmp->execute(array('id' => $id));



        $query = 'Select User_login As Login from users where User_id = :id';
        $stmp = $db->prepare($query);
        $stmp->execute(Array('id'=>$id));
        $User = $stmp->fetch();

        //AuthorizationUser($User['Login'], $Pswd); //Авторизуем пользователя.

        if ($Result)
            echo '<div class="alert alert-success">
<p>Пароль успено обновлен!</p>
<a href="/" class="btn btn-light">Продолжить</a>
</div>';
    }
    else
        echo '<div class="alert alert-danger" >
<p>При обновлении пароля возникла ошибка!</p>
</div>';



}
catch (PDOException $exception)
{
    echo '<div class="alert alert-danger">
<p class="h4">Ошибка</p>
<p>На строне сервера возникла техническая ошибка!</p>
</div>';
   // print_r($exception->getLine());
}