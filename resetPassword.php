<?php

//API: сборос пароля

if(!isset($_POST['Email']))
    exit();

require_once ('cfg/core.php');

$Email = $_POST['Email'];

try {
    $query = 'Select User_id As ID, User_login As Login from users where User_email = :Email';

    $db = db_connect();
    if($db==null)
        exit( '<p class="text-danger">Ошибка в БД!</p>');

    $stmp = $db->prepare($query);
    $stmp->execute(array('Email'=>$Email));

    $UserData = $stmp->fetch();

    if(!$UserData)
        echo '<div class="alert alert-danger">Не удалось найти пользователя с таким адресом электронной почты!</div>';
    else
    {

        $id = $UserData['ID'];
        $login = $UserData['Login'];

        $code = rand(PHP_INT_MIN, PHP_INT_MAX);

        $hash = md5($code + $id);

        $query = 'insert into accauntactivation(AA_UserID, AA_ActivationCodeHash) VALUE(:id, :hash)';

        $db = db_connect();
        if($db == null)
            return false;

        $stmp = $db->prepare($query);

        if($stmp->execute(Array('id'=>$id,'hash'=>$hash))) {
            $EmailMessageText = '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

<div class="container p-4 bg-dark">

<h3 class="text-white">Сброс пароля от аккаунта</h3>
<p class="text-white">Добрый день! Было получен запрос на восстановление пароля. 
Используйте ссылку ниже для сбороса пароля.</p>
<p class="text-white">Вашь логин отсанется преждним: ' . $login . '</p>
<p class="text-white">Ссылка для сброса пароля: </p>
<a class="btn btn-info" href="http://jagu/activation.php?hash=' . $hash . '">Сброс пароля</a>
</div>';

           if( mail($Email, 'Сброс пароля', $EmailMessageText))
           {
               echo '<div class="alert alert-success">На указанный вами Email было отправлено письмо с сылкой для сбороса пароля.</div>';
           }
        }

    }


}catch (PDOException $exception)
{
    if($exception->getCode() == 23000)
        echo '<div class="alert alert-danger">На указанный Email уже было отправлено письмо!</div>';
    else
        echo '<div>Неопределенная ошибка! Повторите операцию позже.</div>';
}
