<?php
/*
 * Copyright (c) 2021. Kulikov K. P. [kostj1998.10.13@yandex.ru]
 */

//API: Create lesson

if (empty($_POST))
    exit("Empty post!");

require_once $_SERVER["DOCUMENT_ROOT"] . '/cfg/core.php';

$ArrayParams = array();
$ArrayParams = $_POST;

$ArrayParams['CL_Date'] = date("Y-m-d", strtotime($_POST['CL_Date']));

$QueryStudyLoadID = "SELECT SL_Id AS ID FROM studyload
      WHERE SL_AcademGroup_code = :CL_AGCode  AND SL_Teacher_id = :CL_TeacherID 
        AND SL_DISC_id = :CL_DisciplineID  AND SL_TypeLesson_code = :CL_TypeLesson";

//Запрос на вставку информации о занятии
$QueryInsertLesson = "INSERT INTO lessoninfo(LI_date, LI_LessonTopic, LI_LessonNumber_id, StudyLoad_id) 
VALUE(:CL_Date, 
      :CL_Topic, 
      :CL_LessonNumber, 
      :CL_StudyLoadID
     ); ";

try {
    $db = db_connect();
    $stmp = $db->prepare($QueryStudyLoadID);

    $Result = $stmp->execute(
        [
            'CL_AGCode' => $ArrayParams['CL_AGCode'],
            'CL_TeacherID' => $ArrayParams['CL_TeacherID'],
            'CL_DisciplineID' => $ArrayParams['CL_DisciplineID'],
            'CL_TypeLesson' => $ArrayParams['CL_TypeLesson']
        ]);

    $Result = $stmp->fetch();

    if ($Result)
        $ID = $Result['ID'];
    else
        exit(json_encode(false));

    $stmp = $db->prepare($QueryInsertLesson);

    $Result = $stmp->execute([
        'CL_Date' => $ArrayParams['CL_Date'],
        'CL_Topic' => $ArrayParams['CL_Topic'],
        'CL_LessonNumber' => $ArrayParams['CL_LessonNumber'],
        'CL_StudyLoadID' => $ID,
    ]);

    if ($Result)
        exit(json_encode(true));
    else exit(json_encode(false));

} catch (PDOException $exception) {
    exit(json_encode(false));
}