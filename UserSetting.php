<?php
require_once ("cfg/core.php");
$Page_Title = 'Настройки профеля';
if(isAuthUser() == NULL)
    RedirectUser();
?>

<html lang="ru">
<head>
    <? require_once("template/head.php"); ?>

</head>

<body class="">
<? require_once("template/top.php"); ?>

<div class="container p-4">

<div class="card">
    <div class="card-header">
        <p class="h5 text-center">Настройки профиля</p>

    </div>

    <div class="card-body">
        <form name="UserSetting" id="UserSetting" method="post">

        </form>
    </div>

    <div class="card-footer">
        <button form="UserSetting"  class="btn btn-outline-success">Сохранить</button>
        <a href="/" class="btn btn-outline-secondary">Отмена</a>
    </div>
</div>

</div>
<? require_once("template/footer.php");?>
</body>
</html>