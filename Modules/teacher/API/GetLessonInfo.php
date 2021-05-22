<?php
/*
 * Copyright (c) 2021. Kulikov K. P. [kostj1998.10.13@yandex.ru]
 */

//API: получение информации о занятии

if (empty($_POST))
    exit(json_encode("Post empty"));

require_once $_SERVER["DOCUMENT_ROOT"] . '/cfg/core.php';

$ArrayData = array();
$ArrayData = $_POST;

$QueryLessonInfo = "SELECT 
       LI_id AS ID,
       DATE_FORMAT(LI_date, '%d.%m.%Y') AS Date,
       d.DISC_name AS Discipline,
       LI_LessonTopic AS Topic,
       s.SL_TypeLesson_code AS TypeLesson,
       LI_LessonNumber_id AS LessonNumber,
       s.SL_Teacher_id AS TeacherID
       FROM lessoninfo 
JOIN studyload s ON s.SL_Id = lessoninfo.StudyLoad_id
JOIN discipline d ON s.SL_DISC_id = d.DISC_id

WHERE LI_id = :ID";

try {
    $db = db_connect();
    $stmp = $db->prepare($QueryLessonInfo);
    $stmp->execute($ArrayData);

    $Result = $stmp->fetch(PDO::FETCH_ASSOC);

    if (!$Result)
        exit(json_encode(false));

    exit(json_encode($Result));


} catch (PDOException $exception) {
    exit(json_encode($exception->getMessage()));
}