<?php
/*
 * Copyright (c) 2021. Kulikov K. P. [kostj1998.10.13@yandex.ru]
 */

//API: получение учебной нагрузки для преподавателя

require_once $_SERVER['DOCUMENT_ROOT'] . '/cfg/core.php';

if (empty($_POST) || empty($_GET))
    exit("Пустой запрос недопустим!");

$TeacherID = $_POST['TeacherID'];
$AGCode = $_POST['AGCode'];
$DisciplineID = $_POST['DisciplineID'];

try {
    $db = db_connect();

    switch ($_GET['get']) {
        case 'AGList':
        {
            $Query = "SELECT SL_AcademGroup_code AS AGCode FROM studyload WHERE SL_Teacher_id = :TID GROUP BY SL_AcademGroup_code";
            $stmp = $db->prepare($Query);

            $stmp->execute(['TID' => $TeacherID]);

            $Result = $stmp->fetchAll(PDO::FETCH_ASSOC);

            exit(json_encode($Result));
        }
        case 'DisciplineList':
        {
            $Query = "SELECT SL_DISC_id AS dID, d.DISC_name AS dName
FROM studyload
JOIN discipline d ON studyload.SL_DISC_id = d.DISC_id WHERE SL_Teacher_id = :TID AND SL_AcademGroup_code = :AGCode
GROUP BY SL_DISC_id";

            $stmp = $db->prepare($Query);
            $stmp->execute([
                'TID' => $TeacherID,
                'AGCode' => $AGCode
            ]);

            $Result = $stmp->fetchAll(PDO::FETCH_ASSOC);
            exit(json_encode($Result));
        }

        case 'StudyLoadInfo':
        {
            $Query = "SELECT 
       t.TL_Name AS TypeLesson, 
       f.FOC_Name AS FormControl, 
       SL_NumberHours AS NumberHours
FROM studyload 
JOIN discipline d ON studyload.SL_DISC_id = d.DISC_id
JOIN typelesson t ON studyload.SL_TypeLesson_code = t.TL_id
LEFT JOIN formofcontrol f ON studyload.SL_FormControl_id = f.FOC_Abbreviation
WHERE SL_AcademGroup_code = :AGCode AND SL_Teacher_id = :TID AND SL_DISC_id = :dID";
        }
    }
} catch (PDOException $exception) {
    exit($exception->errorInfo);
}