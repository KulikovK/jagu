<?php

//API обновление информации об академической группе

if (empty($_POST))
    exit();

require_once($_SERVER['DOCUMENT_ROOT'].'/cfg/core.php');

$ArrayData = array();
$ArrayData = $_POST;

foreach ($ArrayData as $key => $value)
{
    if ($value==='')
        $ArrayData[$key]=null;
}

$query = "Update jagu.academicgroups set AG_Code = :AGCode,
                               AG_specialty = :Specialty,
                               AG_YearOfStart = :YearStart,
                               AG_YearOfEnd = :YearEnd,
                               AG_NumCuorse = :NumberCourse,
                               AG_Curator = :Curator,
                               AG_Headman = :Headman,
                               AG_FormOfStudy = :FormOfStudy
                               WHERE AG_Code = :AGCodeOld";

try {
    $db = db_connect();
    if($db==null)
    {
        exit(json_encode('Ошибка соединения с БД!'));
    }

    $stmp = $db->prepare($query);
    $result = $stmp->execute($ArrayData);

    if($result)
        exit(json_encode('Иформация обновлена'));
    else
        exit(json_encode('Не удалось обновить информацию!'));


}
catch (PDOException $exception)
{
exit(json_encode('Ошибка обработки запроса. Проверьте правильность заполнения всех полей!'));
}
