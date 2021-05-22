<?php
/*
 * Copyright (c) 2021. Kulikov K. P. [kostj1998.10.13@yandex.ru]
 */

//API: запись информации о посещаемости

$RESPONSE_AJAX['success'] = false;
if (empty($_POST))
    exit(json_encode($RESPONSE_AJAX));

require_once $_SERVER['DOCUMENT_ROOT'] . '/cfg/core.php';


try {

    $db = db_connect();
    $stmp = null;
    $StudentsList = array();
    ////Если не выбрана подгруппа
    ///

    if ($_POST['LessonID']) {
        $queryStudentList = "SELECT s.SP_id AS ID, 
       CONCAT(SP_Surname, ' ', SP_Name, ' ', SP_MiddleName) AS FIO,
       AL_NumberHours AS Hours,
       AL_LessonGrande AS Grade,
       AL_Coments AS Comments

FROM attendancelesson
JOIN studentprofile s ON attendancelesson.AL_Student_id = s.SP_id
WHERE AL_LessonInfo_id = :LessonID
ORDER BY FIO";

        $stmp = $db->prepare($queryStudentList);

        $stmp->execute(['LessonID' => $_POST['LessonID']]);
    } elseif ($_POST['Subgroups'] == 0) {
        $queryStudentList = "SELECT SP_id AS ID, CONCAT(SP_Surname, ' ', SP_Name, ' ', SP_MiddleName) AS FIO
FROM studentprofile WHERE SP_AcademGroup_id = :AGCode ORDER BY FIO";

        $stmp = $db->prepare($queryStudentList);
        $stmp->execute(['AGCode' => $_POST['AGCode']]);

    } else {
        $queryStudentList = "SELECT SP_id AS ID, CONCAT(SP_Surname, ' ', SP_Name, ' ', SP_MiddleName) AS FIO
FROM studentlistinsubgroups JOIN studentprofile s ON s.SP_id = studentlistinsubgroups.SLS_Student_id
WHERE SLS_SubGroups_id = :Subgroups ORDER BY FIO";

        $stmp = $db->prepare($queryStudentList);
        $stmp->execute(['Subgroups' => $_POST['Subgroups']]);


    }

    $StudentsList = $stmp->fetchAll(PDO::FETCH_ASSOC);


    if (!$StudentsList)
        exit(json_encode($RESPONSE_AJAX));


    $json = array();

    if (!isset($_POST['LessonID']) || $_POST['LessonID'] == null) {
        foreach ($StudentsList as $item) {
            $json[] = array(
                0 => $item['ID'],
                1 => $item['FIO'],
                2 => 0,
                3 => 0,
                4 => ""
            );
        }
    } else {
        foreach ($StudentsList as $item) {
            $json[] = array(
                0 => $item['ID'],
                1 => $item['FIO'],
                2 => ($item['Hours'] == null ? 0 : $item['Hours']),
                3 => ($item['Grade'] == null ? 0 : $item['Grade']),
                4 => ($item['Comments'] == null ? "" : $item['Comments'])
            );
        }
    }

    $RESPONSE_AJAX['data'] = $json;
    $RESPONSE_AJAX['success'] = true;

    echo(json_encode($RESPONSE_AJAX));


} catch (PDOException $exception) {
    $RESPONSE_AJAX['ErrorInfo'] = $exception->getMessage();
    exit(json_encode($RESPONSE_AJAX));
}
