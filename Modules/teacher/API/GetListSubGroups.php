<?php
/*
 * Copyright (c) 2021. Kulikov K. P. [kostj1998.10.13@yandex.ru]
 */
//API: получение списка подгрупп

if (empty($_POST))
    exit("empty POST");

$ArrayData = array();
$ArrayData = $_POST;

require_once $_SERVER['DOCUMENT_ROOT'] . '/cfg/core.php';

$QuerySelectListSubGroups = "SELECT SG_id AS ID, SG_Numbers AS Number 
FROM subgroups JOIN studyload s ON s.SL_Id = subgroups.SG_StudyLoad_id
WHERE s.SL_AcademGroup_code = :AGCode 
  AND s.SL_DISC_id = :DisciplineID 
  AND SL_Teacher_id = :TeacherID 
  AND SL_TypeLesson_code = :TypeLessonID";

try {
    $db = db_connect();

    $stmp = $db->prepare($QuerySelectListSubGroups);
    $stmp->execute($ArrayData);

    $Result = $stmp->fetchAll(PDO::FETCH_ASSOC);

    exit(json_encode($Result));


} catch (PDOException $exception) {
    exit($exception->getMessage());
}