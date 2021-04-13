<?php
//API: исключение студента из аодгруппы

$ListStudent = $_POST['ListStudent'];
$SubGroupsID = $_POST['SubGroupsID'];
$CountRemoveStudents = count($ListStudent);

require_once $_SERVER['DOCUMENT_ROOT'].'/cfg/core.php';

if(!isset($_POST['ListStudent']) Or !isset($_POST['SubGroupsID']))
    exit("<p class='alert alert-danger'>Пустой запрос недопустим!</p>");

try {
   $db = db_connect();

   $query = 'Delete from studentlistinsubgroups where SLS_Student_id = :SPID And SLS_SubGroups_id = :SGID';

   $stmp = $db->prepare($query);

   foreach ($ListStudent As $value)
       $stmp->execute([
          'SPID'=>$value,
          'SGID'=>$SubGroupsID
       ]);

   exit("<p class='alert alert-success'>Операция выполнена!</p>");

}
catch (PDOException $exception)
{
    exit("<p>Ошибка обработки запроса.<br>Код ошибки: ".$exception->getCode()."</p>");
}