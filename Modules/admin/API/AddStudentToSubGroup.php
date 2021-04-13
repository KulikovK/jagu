<?php
//API: добавление студента(студентов) в подгруппу


$StudentList = $_POST['StudentsList'];
$SGID = $_POST['SGID'];
$CountStudentList = count($StudentList);// получаем количество студентов, которых нужно добавить

require_once $_SERVER["DOCUMENT_ROOT"]."/cfg/core.php";

if(!isset($_POST['StudentsList']) || !isset($_POST['SGID']) || $CountStudentList === 0)
    exit("<p class='alert alert-danger'>Ошибка: не найден код подгруппы или список студентов!</p>");


try {
    $QueryAddStudents = "insert into studentlistinsubgroups(SLS_SubGroups_id, SLS_Student_id) VALUE (:SGID, :SPID)";

    $db = db_connect();

    $stmp = $db->prepare($QueryAddStudents);

    foreach ($StudentList As $value)
        $stmp->execute([
            'SGID'=>$SGID,
            'SPID'=>$value
        ]);


    exit("<p class='alert alert-success'>Операция выполнена!</p>");

}catch (PDOException $exception){
    exit("<p class='alert alert-danger'>Ошибка выполнения запроса!<br>Код ошибки: ".$exception->getCode()."</p>");
}