<?php
require_once("global.php");
global $RESPONSE_AJAX;
session_start();

// Поготовка заголовка страницы
function GetPageTitle($ptText='')
{
    if($ptText == '')
        return SITE_NAME;
    else
        return SITE_NAME.' - '.$ptText;
}

// Соединение с БД
function db_connect()
{
    try
        {
            $dns = sprintf("mysql:host=%s; dbname=%s; charset=utf8", DB_HOST, DB_NAME);
            $opt = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            return new PDO($dns, DB_USERNAME, DB_PASSWORD, $opt);
        }
    catch (PDOException $PDOException)
    {
      // print $PDOException->getMessage();
    }
    return NULL;
}

// Авторизация пользователя
function AuthorizationUser($login, $password)
{
    $db = db_connect();
    if($db==NULL) return NULL;

    $query = "Select User_id as ID, User_Passwd As Pswd, u.UR_modul As Modules, ActivStatus As ActivStat from users join usersrole u on u.UR_id = users.User_Role
where User_login = :login";

    $stmp = $db->prepare($query);
    $stmp->execute(array('login'=>$login));
    
    $result_query = $stmp->fetch();

    if(!$result_query)
        return false;

    $UserID = $result_query['ID'];
    $UserModules = $result_query['Modules'];
    $PasswordHash = $result_query['Pswd'];
    $ActiveStatus = $result_query['ActivStat'];

    if(!password_verify($password, $PasswordHash ) || !$ActiveStatus)
        return false;

    $User_key = uniqid();


    if(isset($_COOKIE['jagu_user_key'])) {
        unset($_COOKIE['jagu_user_key']);
    }
    setcookie('jagu_user_key', $User_key);
    $_SESSION[$User_key] = Array("UserID"=>$UserID, 'UserModules'=>$UserModules);
    Header("Location: /Modules/".$UserModules);

    return TRUE;
}

// Проверка: авторизован-ли пользователь, если да, то вернуть его роль
function isAuthUser()
{
    if($_SESSION[$_COOKIE['jagu_user_key']])
        return $_SESSION[$_COOKIE['jagu_user_key']]['UserModules'];
    else
        return NULL;
}

// Отмена авторизации пользователя
function logout()
{
   if($_SESSION[$_COOKIE['jagu_user_key']]){
       unset($_SESSION[$_COOKIE['jagu_user_key']]);
       session_destroy();
       unset($_COOKIE['jagu_user_key']);
   }

}

// Перенаплавление пользователя на модуль, соответсвующий его роли
function RedirectUser()
{
    if(isAuthUser() != null)
    header('Location: /Modules/'.isAuthUser());
}

function GenerationActivationCode($UserID, $UserEmail)
{
    $code = uniqid();

    $hash = md5($code + $UserID);

    $query = 'insert into accauntactivation(AA_UserID, AA_ActivationCodeHash) VALUE(:id, :hash)';

    $db = db_connect();
    if($db == null)
        return false;

    $stmp = $db->prepare($query);
    if($stmp->execute(Array('id'=>$UserID,'hash'=>$hash)))
    {
         $htmlText = '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

<div class="container p-4 bg-dark">

<h3 class="text-white">Дабро пожаловать в информацинную систему JAGU!</h3>
<p class="text-white">Вы были зарегестрированы в информационной системе JAGU. Для активации аккаунта перейдите по ссылке ниже.</p>
<p class="text-white">Ссылка для активации: </p>
<a class="btn btn-info" href="http://jagu/activation.php?hash='.$hash.'">Активация аккаунта</a>
</div>';
        return  mail($UserEmail, 'Jagu Account', $htmlText);
    }
    return false;

}