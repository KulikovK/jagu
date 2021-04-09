<?php
//API: получение списка студентов академ. группы

if(!isset($_POST['AGCode']))
    exit(json_encode('Пустой запрос!'));

require_once($_SERVER['DOCUMENT_ROOT'].'/cfg/core.php');

$AGCode = $_POST['AGCode'];

$query = "Select SP_id as ID,
       CONCAT(SP_Surname, ' ', SP_Name, ' ', SP_MiddleName) As StudentFIO,
       SP_NumberOfBook As NumberBook,
       SP_TypeOfStudy As TypeOfStudy 
from studentprofile where SP_AcademGroup_id = :AGCode";

try{
    $db = db_connect();
    if($db == null)
        exit(json_encode('Error db!'));

    $stmp = $db->prepare($query);
    $stmp->execute(Array('AGCode'=>$AGCode));

    $Rsult = $stmp->fetchAll(PDO::FETCH_ASSOC);

//    $json = array();
//
//    foreach ($Rsult As $row)
//    {
//        $json[] = array(
//            $row['StudentFIO'],
//            $row['NumberBook'],
//            $row['TypeOfStudy']
//        );
//    }
//
//    $RESPONSE_AJAX['data']=$json;
//    $RESPONSE_AJAX['success']=true;



    echo json_encode($Rsult);



}catch (PDOException $exception)
{
    $RESPONSE_AJAX['ErrorInfo'] = $exception->getMessage();
    exit(json_encode($RESPONSE_AJAX));
}
