<?php
/*
 * Copyright (c) 2021. Kulikov K. P. [kostj1998.10.13@yandex.ru]
 * Project: JAGU
 * Module:
 * Submodule:
 * Description:
 * Version:
 */

/*
 * Copyright (c) 2021. Kulikov K. P. [kostj1998.10.13@yandex.ru]
 * Project: JAGU
 * Module: Administrator
 * Submodule: Academic Groups Control
 * Description: Получение списка форм контроля
 * Version: 21.04.18.1748
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/cfg/core.php';

$Query = "Select FOC_Abbreviation As ID, FOC_Name AS Name from formofcontrol";

try{
    $db = db_connect();

    $stmp = $db->query($Query);

    $Result = $stmp->fetchAll(PDO::FETCH_ASSOC);

    exit(json_encode($Result));
}
catch (PDOException $exception)
{
    exit($exception->errorInfo);
}


