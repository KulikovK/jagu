<?php
//API: создание подгруппы

require_once $_SERVER['DOCUMENT_ROOT'].'/cfg/core.php';

if(isAuthUser() != 'admin')
    exit();

if(empty($_POST))
    exit();

$ArryData = array();
$ArryData = $_POST;

$insertSubGroups = "insert into subgroups(SG_StudyLoad_id, SG_Numbers) VALUE(:StudyLoad_id, :NumberSubGoups)";

try{
    $db=db_connect();

    $stmp = $db->prepare($insertSubGroups);
     $Result = $stmp->execute($ArryData);

     if($Result)
         echo '<p class="alert alert-success">Подгруппа успешно создана!</p>';
     else
         echo '<p class="alert alert-danger">Ошибка создания подгруппы!</p>';

}catch (PDOException $exception)
{
    echo "<p class='alert alert-danger'>Exception: ".$exception->getCode().'<br>'.$exception->getMessage().'</p>';
}