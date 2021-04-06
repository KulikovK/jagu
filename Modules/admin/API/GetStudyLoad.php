<?php
//API: получение информации об учебной нагрузке

// для группы

require_once $_SERVER['DOCUMENT_ROOT'].'/cfg/core.php';

if (isAuthUser() == 'student' || !isset($_POST['AGCode']))
    exit();

if(isset($_POST['AGCode']))
{
    $AGCode = $_POST['AGCode'];

    $qwery = "Select d.DISC_name As DisciplineName, t.TL_Name As TypeLessonName, SL_NumberHours As NumberHours, concat(t2.TP_Surname, ' ', t2.TP_Name, ' ', t2.TP_MiddleName) As TeacherName, SL_AdditionalLoad as AL from studyload
join discipline d on studyload.SL_DISC_id = d.DISC_id
join typelesson t on studyload.SL_TypeLesson_code = t.TL_id
join teacherprofile t2 on d.DISC_LeadTeacher_id = t2.TP_UserID where SL_AcademGroup_code =:AGCode";

    try {
        $db = db_connect();

        $stmp = $db->prepare($qwery);

        $stmp->execute(['AGCode'=>$AGCode]);

        $StudyLoad= $stmp->fetchAll(PDO::FETCH_ASSOC);

        $json = Array();

        foreach($StudyLoad as $row)
        {
            $json[] = array(
                $row['DisciplineName'],
                $row['TeacherName'],
                $row['TypeLessonName'],
                $row['NumberHours'],
                $row['AL']== 1 ? 'Да' : 'Нет'
            );
        }

        $RESPONSE_AJAX['data']=$json;
        $RESPONSE_AJAX['success']=true;
        echo json_encode($RESPONSE_AJAX);


    }catch (PDOException $exception)
    {
        exit( json_encode($exception->getMessage()));
    }

}