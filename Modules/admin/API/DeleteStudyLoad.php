<?php
//API: удаление учебной нагрузки

require_once $_SERVER['DOCUMENT_ROOT'].'/cfg/core.php';

if(isAuthUser() == 'student')
    exit("<p class='alert alert-danger'>Откзано в доступе!</p>");

if(empty($_POST) || !isset($_POST['isUpdateStudyLoad']) || $_POST['isUpdateStudyLoad'] == 'NO')
    exit("<p class='alert alert-danger'>Не могу обработать пустой запрос!</p>");

$id = $_POST['isUpdateStudyLoad'];

$DeleteQuery = "Delete from jagu.studyload where SL_Id = :id";

try{
    $db = db_connect();

    $stmp = $db->prepare($DeleteQuery);

    $DeleteResult = $stmp->execute(['id'=>$id]);

    if($DeleteResult)
        exit("<p class='alert alert-success'>Запись удалена.</p>");
    else
        exit("<p class='alert alert-warning'>Не удалось удалить запись. Вероятнее всего, она уже была удалена. Обновите страницу или попробуйте позже.</p>");

}
catch (PDOException $exception)
{
    exit("<p class='alert alert-danger'>Exception: ".$exception->getMessage()."</p>");
}