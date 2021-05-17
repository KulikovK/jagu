<?php
/*
 * Copyright (c) 2021. Kulikov K. P. [kostj1998.10.13@yandex.ru]
 */

//API: получение типа занятий по дицспилине для преподавателя

if (empty($_POST))
    exit('Empty post');

require_once $_SERVER['DOCUMENT_ROOT'] . '/cfg/core.php';

$ArrayData = array();
$ArrayData = $_POST;

$Query = "SELECT TL_id AS ID, TL_Name AS Name FROM typelesson
JOIN studyload s ON typelesson.TL_id = s.SL_TypeLesson_code
WHERE s.SL_AcademGroup_code = :AGCode AND s.SL_DISC_id = :DisciplineID AND s.SL_Teacher_id = :TeacherID";

try {
    $db = db_connect();

    $stmp = $db->prepare($Query);
    $stmp->execute($ArrayData);

    $ListTypeLesson = $stmp->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($ListTypeLesson);

} catch (PDOException $exception) {
    exit($exception->getMessage());
}

