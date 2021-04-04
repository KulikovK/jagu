<?php
//API: удаление академической группы по ID


//FIXME: неавторизованные пользователи
// могут выполнять ajax запрос на удаление,
// если они не обновили страницу после деавторизации

if (!isset($_POST['AGCode']))
    exit();

$AGCode = $_POST['AGCode'];
$query = "Delete from academicgroups where AG_Code = :AGCode";

require_once($_SERVER['DOCUMENT_ROOT'].'/cfg/core.php');

try{
    $db = db_connect();
    if($db==null)
        exit(json_encode('Ошибка подключения к базе данных!'));

    $stmp = $db->prepare($query);

    $result = $stmp->execute(['AGCode'=>$AGCode]);

    if($result)
        echo json_encode('Группа удалена!');
    else
        echo json_encode('Ошибка удаления!');

}catch (PDOException $exception)
{
    exit(json_encode('Ошибка удаления! Брошено исключение: ' . $exception->getMessage()));
}
