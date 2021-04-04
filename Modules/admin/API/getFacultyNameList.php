<?php
//API: получение списка факультетов
require_once ($_SERVER['DOCUMENT_ROOT'].'/cfg/core.php');

if(!isset($_POST['id'])) {
    $query = "Select FCT_id as ID, FCT_name As Name from faculties";

    try {
        $db = db_connect();
        if ($db == null)
            exit();

        $stmp = $db->query($query);

        $FacultyList = $stmp->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($FacultyList);

    } catch (PDOException $exception) {
        echo $exception->getMessage();
    }
}



