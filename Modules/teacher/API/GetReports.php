<?php
/*
 * Copyright (c) 2021. Kulikov K. P. [kostj1998.10.13@yandex.ru]
 */

if (empty($_POST))
    exit('empty post');

$ArrayData = array();
$ArrayData = $_POST;
$RESPONSE_AJAX['success'] = false;
require_once $_SERVER['DOCUMENT_ROOT'] . '/cfg/core.php';

$QueryReports = "SELECT 
       LI_date AS date,
      CONCAT(DATE_FORMAT(l.LN_StartTime, '%H:%i'), '-', DATE_FORMAT(l.LN_EndTime, '%H:%i')) AS HoursLesson,
       f.FCT_Abbreviation AS Faculty,
       a.AG_NumCuorse AS Course, 
       a.AG_Code AS AGCode,
       LI_LessonTopic AS Topic,
       SL_TypeLesson_code AS TypeLesson,
       LI_CountHours AS CountHours
     
       
       FROM lessoninfo
JOIN studyload s ON s.SL_Id = lessoninfo.StudyLoad_id
JOIN lessonnumber l ON lessoninfo.LI_LessonNumber_id = l.LN_Number
JOIN academicgroups a ON s.SL_AcademGroup_code = a.AG_Code
JOIN specialtylist s2 ON a.AG_specialty = s2.SL_id
JOIN faculties f ON s2.SL_Faculty_id = f.FCT_id
WHERE s.SL_Teacher_id = :TeacherID AND EXTRACT(MONTH FROM LI_date) = :Month
ORDER BY date, LI_LessonNumber_id";

try {
    $db = db_connect();
    $stmp = $db->prepare($QueryReports);

    $stmp->execute([
        'TeacherID' => $_POST['TeacherID'],
        'Month' => $_POST['Month']
    ]);

    $Result = $stmp->fetchAll(PDO::FETCH_ASSOC);

    if (!$Result)
        exit(json_encode($RESPONSE_AJAX));

    $RESPONSE_AJAX['data'] = $Result;
    $RESPONSE_AJAX['success'] = true;

    exit(json_encode($RESPONSE_AJAX));

} catch (PDOException $exception) {
    $RESPONSE_AJAX['info'] = $exception->getMessage();
    exit(json_encode($RESPONSE_AJAX));
}