<?php
// Сохранение информации о преподавателе после редактирования
require_once($_SERVER['DOCUMENT_ROOT'].'/cfg/core.php');
if(isAuthUser() != 'admin')
{
    echo 'Неавторизованный пользователь!';
    exit();
}

if(empty($_POST))
{
    exit('<div class="alert alert-danger">Пустой запрос не принимается!</div>');
}

$ArrayData = Array();
$ArrayData = $_POST;

foreach ($ArrayData as $key => $value)
{
    if ($value==='')
        $ArrayData[$key]=null;
}

try {


    $db = db_connect();
    if ($db == null) {
        exit('<p class="alert alert-danger">Ошибка соединения с базой данных!</p>');
    }

    $queryUpdateFromTeacher = "Update teacherprofile
join users u on teacherprofile.TP_UserID = u.User_id
set  TP_Surname = :Surname,
    TP_Name = :Name,
    TP_MiddleName = :MiddleName,
    TP_BrieflyName = :BrieflyName,
    TP_Gender = :Gender,
    TP_DataOfBirth = :DOB,
    TP_Degree = :AcademicDegree,
    TP_AcademicTitle = :AcademicTitle,
    TP_Department = :Departaments,
    u.User_email = :Email,
    u.User_login = :Login
where TP_UserID = :ID
";

    $stmp = $db->prepare($queryUpdateFromTeacher);

    $UpdateStat = $stmp->execute($ArrayData);

    if ($UpdateStat)
        echo '<div class="alert alert-success">Информация успешно обновлена!</div>';
    else
        echo('<div class="alert alert-danger">Не удалось обновить информацию. Повторите операцию позже. <br>
Если ошибка возникает вновь, то обратитесь к администратору!</div>');
}
catch (PDOException $exception)
{
    echo('<div class="alert alert-danger">При обвновлении информации возникла ошибка: '.$exception->getMessage().'</div>');

}

