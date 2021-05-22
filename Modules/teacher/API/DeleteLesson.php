<?php
/*
 * Copyright (c) 2021. Kulikov K. P. [kostj1998.10.13@yandex.ru]
 */

//API: удаление информации о занятии

if (empty($_POST))
    exit(json_encode(false));

require_once $_SERVER['DOCUMENT_ROOT'] . '/cfg/core.php';

$QueryDeleteLesson = "DELETE FROM lessoninfo WHERE LI_id = :LessonID";

try {
    $db = db_connect();
    $stmp = $db->prepare($QueryDeleteLesson);

    $Result = $stmp->execute(['LessonID' => $_POST['LessonID']]);

    if ($Result)
        exit(json_encode(true));
    else exit(json_encode(false));

} catch (PDOException $exception) {
    exit(json_encode(false));
}

