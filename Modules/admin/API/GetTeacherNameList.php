<?php
//API получаем спико преподавателей
require_once ($_SERVER['DOCUMENT_ROOT'].'/cfg/core.php');
$query = "Select TP_UserID As ID, concat(TP_Surname, ' ', TP_Name, ' ', TP_MiddleName) As FIO from teacherprofile";

try {
 $db = db_connect();

 if($db==null)
     exit("Error DB!");

 $stmp = $db->query($query);

 $TeacherList = $stmp->fetchAll(PDO::FETCH_ASSOC);

 echo json_encode($TeacherList);

}
catch (PDOException $exception)
{
    exit($exception->getMessage());
}

