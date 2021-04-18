<?php
//API: удаление подгрупп

require_once $_SERVER['DOCUMENT_ROOT'].'/cfg/core.php';

if(isAuthUser() != 'admin')
    exit("<p class='alert alert-danger'>Отказано в доступе!</p>");

if(!isset($_POST['SGID']) || empty($_POST['SGID']))
exit("<p class='alert alert-danger'>Ошибка входных данных.</p>");

$SGID = $_POST['SGID'];

$DeleteSubGroups = 'Delete from subgroups where SG_id = :SGID';

try{
    $db = db_connect();

    $stmp = $db->prepare($DeleteSubGroups);

    $stmp->execute(['SGID'=>$SGID]);

    exit("<p class='alert alert-success'>Подгруппа успешно удалена.</p>");

}
catch (PDOException $exception)
{
    exit("<p class='alert alert-danger'>Ошибка выполения запроса!<br>Код ошибки: ".$exception->getCode()."</p>");
}