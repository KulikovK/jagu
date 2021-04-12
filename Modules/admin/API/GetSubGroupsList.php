<?php
//API: получение списка подгрупп для академической группы

require_once $_SERVER['DOCUMENT_ROOT'].'/cfg/core.php';

if(!isset($_POST['AGCode']))
    exit();

$AGCode = $_POST['AGCode'];

$query = "Select SG_id As ID, d.DISC_name As DisciplineName, 
       concat(t.TP_Surname, ' ', t.TP_Name, ' ', t.TP_MiddleName) As FIOTeacher, 
       t2.TL_Name As TypeLesson, 
       SG_Numbers As NumberSubGroups,
       (select count(*) from studentlistinsubgroups where SLS_SubGroups_id = subgroups.SG_id) As CountStudents

from subgroups
join studyload s on s.SL_Id = subgroups.SG_StudyLoad_id
join discipline d on s.SL_DISC_id = d.DISC_id
join teacherprofile t on s.SL_Teacher_id = t.TP_UserID    
join typelesson t2 on s.SL_TypeLesson_code = t2.TL_id where s.SL_AcademGroup_code = :AGCode
";

try{
    $db = db_connect();

    $stmp = $db->prepare($query);
    $stmp->execute(['AGCode'=>$AGCode]);

    $Result = $stmp->fetchAll(PDO::FETCH_ASSOC);

    $json = array();

    foreach ($Result As $row)
    {
        $json[] = array(
              $row['DisciplineName'],
            $row['FIOTeacher'],
            $row['TypeLesson'],
            $row['NumberSubGroups'],
            $row['CountStudents'],
            $row['ID']

        );
    }

    $RESPONSE_AJAX['data']=$json;
    $RESPONSE_AJAX['success']=true;
    echo json_encode($RESPONSE_AJAX);

}
catch (PDOException $exception)
{
$RESPONSE_AJAX['success']=false;
$RESPONSE_AJAX['ErrorInfo'] = $exception->getMessage();
    echo json_encode($RESPONSE_AJAX);
}