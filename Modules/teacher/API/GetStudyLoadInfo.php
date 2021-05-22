<?php
/*
 * Copyright (c) 2021. Kulikov K. P. [kostj1998.10.13@yandex.ru]
 */
//API: получение данных нагрузки

if (empty($_POST))
    exit(json_encode("empty post"));

require_once $_SERVER['DOCUMENT_ROOT'] . '/cfg/core.php';

if ($_POST['TypeLessonID'] == 0)
    $_POST['TypeLessonID'] = null;

$QueryStudyLoadInfo = 'SELECT  
       t.TL_Name AS TypeLesson,
       SL_NumberHours AS NumberHours,
       (SELECT 2*COUNT(*) FROM lessoninfo WHERE lessoninfo.StudyLoad_id = studyload.SL_Id) AS CurrentHours
FROM studyload 
JOIN discipline d ON studyload.SL_DISC_id = d.DISC_id
JOIN typelesson t ON studyload.SL_TypeLesson_code = t.TL_id
WHERE 
      SL_Teacher_id = :TeacherID AND 
      SL_DISC_id = :DisciplineID AND 
      SL_AcademGroup_code = :AGCode
      GROUP BY TypeLesson';

try {
    $db = db_connect();
    $stmp = $db->prepare($QueryStudyLoadInfo);

    $stmp->execute([
        'TeacherID' => $_POST['TeacherID'],
        'DisciplineID' => $_POST['DisciplineID'],
        'AGCode' => $_POST['AGCode'],
    ]);

    $Result = $stmp->fetchAll(PDO::FETCH_ASSOC);

    exit(json_encode($Result));

} catch (PDOException $exception) {
    exit(json_encode($exception->getMessage()));
}
