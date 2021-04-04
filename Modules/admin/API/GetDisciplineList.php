<?php
//API: получение списка дисциплин

require_once $_SERVER['DOCUMENT_ROOT'].'/cfg/core.php';

if (isAuthUser() != 'admin')
    exit(json_encode('Auth Error'));

if(!isset($_POST['tID']))
{
    $query = 'Select DISC_id As ID, DISC_name As Name from discipline;';

    try {
        $db = db_connect();

        $stmp = $db->query($query);

        $ListDiscipline = $stmp->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($ListDiscipline);

    }
    catch (PDOException $exception)
    {
        exit(json_encode($exception->errorInfo));
    }
}
