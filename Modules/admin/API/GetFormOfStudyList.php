<?php
//API: получение списка форм обучения
require_once($_SERVER['DOCUMENT_ROOT'].'/cfg/core.php');

$query = "Select FOS_id As ID, FOS_Name AS Name from formatofstudy";

try {
    $db = db_connect();
    if($db==null)
        exit();

    $stmp = $db->query($query);

    $ListFormOfStudy = $stmp->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($ListFormOfStudy);

}
catch (PDOException $exception)
{
    exit();
}