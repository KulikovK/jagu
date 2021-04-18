<?php
/*
 * Copyright (c) 2021. Kulikov K. P. [kostj1998.10.13@yandex.ru]
 * Project: JAGU
 * Module:
 * Submodule:
 * Description:
 * Version:
 */

//API: получение информации об учебной нагрузке

// для группы

require_once $_SERVER['DOCUMENT_ROOT'].'/cfg/core.php';

if (isAuthUser() == 'student')
    exit();


// По коду группы
if(isset($_POST['AGCode']))
{
    $AGCode = $_POST['AGCode'];

    $qwery = "Select SL_Id As ID,
       d.DISC_name As DisciplineName, 
       t.TL_Name As TypeLessonName, 
       SL_NumberHours As NumberHours, 
       concat(t2.TP_Surname, ' ', t2.TP_Name, ' ', t2.TP_MiddleName) As TeacherName,
       SL_AdditionalLoad as AL,
       SL_SemesrNumber As Semester,
       f.FOC_Name As FormControl
from studyload
join discipline d on studyload.SL_DISC_id = d.DISC_id
join typelesson t on studyload.SL_TypeLesson_code = t.TL_id
left join formofcontrol f ON studyload.SL_FormControl_id = f.FOC_Abbreviation
join teacherprofile t2 on SL_Teacher_id = t2.TP_UserID where SL_AcademGroup_code =:AGCode";

    try {
        $db = db_connect();

        $stmp = $db->prepare($qwery);

        $stmp->execute(['AGCode'=>$AGCode]);

        $StudyLoad= $stmp->fetchAll(PDO::FETCH_ASSOC);


        if ($_POST['type']=='list') {
            echo json_encode($StudyLoad);
            exit();
        }


        $json = Array();

        foreach($StudyLoad as $row)
        {
            $json[] = array(
                $row['DisciplineName'],
                $row['TeacherName'],
                $row['TypeLessonName'],
                $row['Semester'],
                $row['NumberHours'],
                $row['FormControl'],
                $row['AL'] == 1 ? 'Да' : 'Нет',
                $row['ID']
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

//по ИД нагрузки
if(isset($_POST['SLID']))
{
    $id = $_POST['SLID'];

    $query = "Select SL_DISC_id As DisciplineID, SL_TypeLesson_code As TypeLesson,
       SL_NumberHours As NumberHours,
       SL_Teacher_id As TeacherID,
       SL_AdditionalLoad As AdditionalLoad,
       SL_SemesrNumber As Semester,       
       SL_FormControl_id As FormControl
       from studyload 

where SL_Id = :id";

    try{
        $db = db_connect();

        $stmp=$db->prepare($query);
        $stmp->execute(['id'=>$id]);

        $Result = $stmp->fetchAll();

        echo json_encode($Result);

    }catch (PDOException $exception)
    {
        echo json_encode($exception->getMessage());
    }

}