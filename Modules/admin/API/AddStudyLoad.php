<?php
//API: добавление учебной нагрузки

require_once $_SERVER['DOCUMENT_ROOT'].'/cfg/core.php';

if(isAuthUser() == 'student')
    exit('Auth error');

if(empty($_POST))
    exit('Empty array!');

$Discipline =     $_POST['Discipline_id'];
$TypeLesson =     $_POST['TypeLesson_id'];
$Teacher =        $_POST['EditAG-Discipline_ThisTeacher_id'];
$AGCode =         $_POST['AGCode'];
$NumberHours =    $_POST['NumberHours'];
$AdditionalLoad = $_POST['AdditionalLoad'];

$AddQuery = 'Insert into studyload(SL_DISC_id, SL_TypeLesson_code, SL_NumberHours, SL_Teacher_id, SL_AcademGroup_code, SL_AdditionalLoad) 
value(:Discipline, :TypeLesson, :NumberHours, :Teacher, :AGCode, :AdditionalLoad)';

try {
    $db = db_connect();

    $stmp = $db->prepare($AddQuery);

    $AddResult = $stmp->execute([
        'Discipline' => $Discipline,
        'TypeLesson' => $TypeLesson,
        'Teacher' => $Teacher,
        'AGCode' => $AGCode,
        'NumberHours' => $NumberHours,
        'AdditionalLoad'=>$AdditionalLoad
    ]);

    if($AddResult){
        echo '<p class="alert alert-success">Нагрузка успешно добавлена.</p>';
        exit();
    }else{
        echo '<p class="alert alert-danger">Ошибка: не могу создать нагрузку. Попробуйте повторить операцию или обратитесь к администратору.</p>';
        exit();
    }

}
catch (PDOException $exception)
{
    exit("<p class='alert alert-danger'>Exception: ".$exception->getCode().". В процессе добавление записи возникла критическая ошибка. Вероятнее всего такая запись уже есть в базе. Если это не так и ошибка повторяется - обратитесь к администратору.</p>");
}