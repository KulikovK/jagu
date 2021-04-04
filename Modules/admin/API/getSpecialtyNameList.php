<?php
//API: получение списка специальнстей по факультетам

if(!isset($_GET['id']))
    exit();

require_once $_SERVER['DOCUMENT_ROOT'].'/cfg/core.php';

$query = "Select SL_id As ID, CONCAT(SL_Name , ' / ', s.SProf_name) as Name  from specialtylist 
join specialtyprofile  s on specialtylist.SL_Profile_id = s.SProf_id
where SL_Faculty_id = :id";

try{
    $db = db_connect();
    if($db==null)
        exit();

    $stmp = $db->prepare($query);
    $stmp ->execute(array('id'=>$_GET['id']));

    $SpecialtyList = $stmp->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($SpecialtyList);

}catch (PDOException $exception)
{
    exit();
}