<?php
/*
 * Copyright (c) 2021. Kulikov K. P. [kostj1998.10.13@yandex.ru]
 */

//API: Create lesson


if (empty($_POST))
    exit("Empty post!");

require_once $_SERVER["DOCUMENT_ROOT"] . '/cfg/core.php';

$LessonData = array(); //Массив параметов для создания занятия
parse_str($_POST['Lesson'], $LessonData);

//Преобразуем дату в формат SQL
$LessonData['CL_Date'] = date("Y-m-d", strtotime($LessonData['CL_Date']));

//Подучаем данные о посещаемости
$StudentListID = $_POST['StudentsID'];
$StudentAttendanceHours = $_POST['StudentAttendance'];
$StudentGrande = $_POST['StudentGrade'];
$StudentComments = $_POST['StudentComments'];

$CountStudents = count($StudentListID);


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


$QueryUpdateLesson = "UPDATE jagu.lessoninfo 
SET 
    LI_date = :CL_Date, 
    LI_LessonTopic = :CL_Topic, 
    LI_LessonNumber_id = :CL_LessonNumber,
    StudyLoad_id = :CL_StudyLoadID
    WHERE LI_id = :LessonID";


try {
    $db = db_connect();
    $stmp = $db->prepare($QueryStudyLoadID);

    $Result = $stmp->execute(
        [
            'CL_AGCode' => $LessonData['CL_AGCode'],
            'CL_TeacherID' => $LessonData['CL_TeacherID'],
            'CL_DisciplineID' => $LessonData['CL_DisciplineID'],
            'CL_TypeLesson' => $LessonData['CL_TypeLesson']
        ]);

    $Result = $stmp->fetch();

    if ($Result)
        $ID = $Result['ID'];
    else
        exit(json_encode(false));

    //Если не определен LessonID - создаем Lesson
    if (!isset($_POST['LessonID']) || empty($_POST['LessonID']) || $_POST['LessonID'] == null) {
        $stmp = $db->prepare($QueryInsertLesson);

        $Result = $stmp->execute([
            'CL_Date' => $LessonData['CL_Date'],
            'CL_Topic' => $LessonData['CL_Topic'],
            'CL_LessonNumber' => $LessonData['CL_LessonNumber'],
            'CL_StudyLoadID' => $ID,
        ]);
    }//Иначе - обновляем
    else {
        $stmp = $db->prepare($QueryUpdateLesson);

        $Result = $stmp->execute([
            'CL_Date' => $LessonData['CL_Date'],
            'CL_Topic' => $LessonData['CL_Topic'],
            'CL_LessonNumber' => $LessonData['CL_LessonNumber'],
            'CL_StudyLoadID' => $ID,
            'LessonID' => $_POST['LessonID'],
        ]);
    }


    if (!isset($_POST['LessonID']) || empty($_POST['LessonID']) || $_POST['LessonID'] == null) {
        //Если занятие создано, заполняем посещаемость
        if ($Result) {
            $LessonID = $db->lastInsertId(); // Получаем ID созданного занятия

            //Формируем тело запроса для заполнения посещаемости
            $QueryInsertAttendance = "INSERT INTO
    attendancelesson(AL_LessonInfo_id, AL_Student_id, AL_NumberHours, AL_LessonGrande, AL_Coments) 
VALUE (:LessonID, :StudentID, :NumberHours, :Grande, :Comments)";

            $stmp = $db->prepare($QueryInsertAttendance);

            for ($i = 0; $i < $CountStudents; $i++) {
                $Result = $stmp->execute([
                    'LessonID' => $LessonID,
                    'StudentID' => $StudentListID[$i],
                    'NumberHours' => $StudentAttendanceHours[$i],
                    'Grande' => $StudentGrande[$i],
                    'Comments' => $StudentComments[$i]
                ]);

                if (!$Result)
                    exit(json_encode(false));
            }

            exit(json_encode(true));


        } else exit(json_encode(false));
    } else {
        if ($Result) {
            $QueryUpdateAttendance = "UPDATE jagu.attendancelesson
SET 
    AL_NumberHours = :NumberHours,
    AL_LessonGrande = :Grande,
    AL_Coments = :Comments
    WHERE AL_LessonInfo_id = :LessonID AND AL_Student_id = :StudentID";

            $stmp = $db->prepare($QueryUpdateAttendance);

            for ($i = 0; $i < $CountStudents; $i++) {
                $Result = $stmp->execute([
                    'LessonID' => $_POST['LessonID'],
                    'StudentID' => $StudentListID[$i],
                    'NumberHours' => $StudentAttendanceHours[$i],
                    'Grande' => $StudentGrande[$i],
                    'Comments' => $StudentComments[$i]
                ]);

                if (!$Result)
                    exit(json_encode(false));
            }

            exit(json_encode(true));
        } else {
            exit(json_encode(false));
        }

    }

} catch (PDOException $exception) {
    exit(json_encode(false));
}