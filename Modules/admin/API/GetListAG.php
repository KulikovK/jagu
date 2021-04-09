<?php
// API: получение писка академ групп

$query = "Select AG_Code As AGCode from academicgroups";

require_once($_SERVER['DOCUMENT_ROOT'].'/cfg/core.php');

try {
    $db = db_connect();
    if($db==null)
        exit("Нет соединения с базой!");

    $stmp = $db->query($query);

    $ListAG = $stmp->fetchAll();

    echo json_encode($ListAG);

}catch (PDOException $exception){
    exit($exception);
}