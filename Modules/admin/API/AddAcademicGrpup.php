<?php
// API: добавление академической группы
require_once($_SERVER['DOCUMENT_ROOT'].'/cfg/core.php');
if (empty($_POST) || isAuthUser() != 'admin')
    exit('<p class="alert alert-danger">Ошибка обработки данных!</p>');

$ArrayData = array();
$ArrayData = $_POST;
$ArrayData['Headman']=null;


foreach ($ArrayData as $key => $value)
{
    if ($value==='')
        $ArrayData[$key]=null;
}

try {
    $db = db_connect();
    if($db==null)
    {
        echo '<p class="alert alert-danger">Ошибка соединения с базой данных</p>';
        exit();
    }

    $InsertQueryAG = "insert into academicgroups(AG_Code, AG_specialty, AG_YearOfStart, AG_YearOfEnd, AG_Curator, AG_NumCuorse, AG_Headman, AG_FormOfStudy) 
VALUE(:AGCode, :Specialty, :DateStart, :DateEnd, :Curator, :NumberCourse, :Headman, :FormOfStudy)";

    $stmp = $db->prepare($InsertQueryAG);

   $Result = $stmp->execute($ArrayData);

    if($Result)
    {
       echo '<p class="alert alert-success">Академическая группа '.$ArrayData['AGCode'].' успешно создана!</p>';
       exit();
    }else{
        echo '<p class="alert alert-danger">Ошибка: не удалось создать новую группу!</p>';
        exit();
    }

}catch (PDOException $exception)
{
    echo '<p class="alert alert-danger">Ошибка: '.$exception->getMessage().'<br>'.$exception->getLine().'</p>';
    exit();
}


