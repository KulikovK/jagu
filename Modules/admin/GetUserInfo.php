<?php
//Получение информации о пользователях.
require_once($_SERVER['DOCUMENT_ROOT'].'/cfg/core.php');
if (isAuthUser() !== 'admin') {
    exit();
}

if(!isset($_POST['type']) || !isset($_POST['id']))
    exit();





$typeUser =$_POST['type'];
$idUser = $_POST['id'];

switch ($typeUser)
{
    case 'teacher':
    {
        $db = db_connect();
        $query="Select 
       concat(TP_Surname, ' ', TP_Name, ' ', TP_MiddleName) As Преподаватель,
       a.AT_name As Должность,
       a2.AD_name As 'Учение звание',
       f.FCT_name As Факультект,
       d.DEP_Name As Кафедра

from teacherprofile
left join academictitle a on teacherprofile.TP_AcademicTitle = a.AT_id
left join academicdegree a2 on a2.AD_id = teacherprofile.TP_Degree
left join departments d on teacherprofile.TP_Department = d.DEP_id 
    left join faculties f on d.DEP_Faculty_id = f.FCT_id

where TP_UserID = :id";

        $stmp = $db->prepare($query);
        $stmp->execute(array('id'=>$idUser));

        $OutData = $stmp->fetch();
    }
}

echo json_encode($OutData);
