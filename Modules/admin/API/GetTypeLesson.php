<?php
//API: получение типа занятий

require_once $_SERVER['DOCUMENT_ROOT'].'/cfg/core.php';

$query = "Select TL_id As ID, TL_Name As Name from typelesson";

try
{
    $db = db_connect();
    $stmp = $db->query($query);

    $ListTypeLesson = $stmp->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($ListTypeLesson);

}catch (PDOException $exception)
{
    echo 'Error to db!';
}