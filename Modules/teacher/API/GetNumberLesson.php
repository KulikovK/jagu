<?php
/*
 * Copyright (c) 2021. Kulikov K. P. [kostj1998.10.13@yandex.ru]
 */

//API: получение номеров пары

require_once $_SERVER['DOCUMENT_ROOT'] . '/cfg/core.php';

$query = "SELECT LN_Number AS Number, TIME_FORMAT(LN_StartTime, '%H:%i') AS StartTime, TIME_FORMAT(LN_EndTime, '%H:%i') AS EndTime FROM lessonnumber";

try {
    $db = db_connect();

    $Result = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);

    exit(json_encode($Result));


} catch (PDOException $exception) {
    exit($exception->getMessage());
}