<?php
//API: получение подробной информации о студенте для академ. группы

require_once($_SERVER['DOCUMENT_ROOT'].'/cfg/core.php');

if(!isset($_POST['id']) || isAuthUser() != 'admin')
    exit('Ошибка доступа или параметров!'.$_POST['id']);

$id = $_POST['id'];

$query = "Select SP_Surname As Surname,
       SP_Name As Name,
       SP_MiddleName As MiddleName,
       SP_BrieflyName As BrieflyName,
       SP_Gender As Gender,
       SP_DataOfBirth As DateOfBirth,
       SP_TypeOfStudy As TypeOfStudy,
       SP_NumberOfBook As NumberBook,
       SP_AcademGroup_id As AGCode,
       u.User_email As Email,
       u.User_login As Login
       from studentprofile
join users u on studentprofile.SP_id = u.User_id
where SP_id = :id";

try {
    $db = db_connect();
    if($db===null)
        exit('Нет соединения с базой!');

    $stmp = $db->prepare($query);
    $stmp->execute(Array('id'=>$id));

    $InfoOfStudent = $stmp->fetch();

    if($InfoOfStudent)
        echo json_encode($InfoOfStudent);

}
catch (PDOException $exception)
{
    exit($exception);
}