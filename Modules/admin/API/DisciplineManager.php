<?php


/*
 * Copyright (c) 2021. Kulikov K. P. [kostj1998.10.13@yandex.ru]
 */
//API: управление дицспилинами
// TODO: реализовать обновление информации о дисциплине
if(!isset($_GET['operation']))
    exit("<div class='alert alert-danger'>API Error: variable 'operation' not faut!</div>");

require_once $_SERVER['DOCUMENT_ROOT'].'/cfg/core.php';


try{

    $db = db_connect();

    switch ($_GET['operation']) {
        //Отображение таблицы дисциплин
        case 'show':
        {
            $queryShow = "Select DISC_id As ID,
       DISC_name As Name,
       CONCAT(t.TP_Surname, ' ', t.TP_Name, ' ', t.TP_MiddleName) As TeacherFIO,
       DISC_Description As Description
from discipline
JOIN teacherprofile t ON t.TP_UserID = discipline.DISC_LeadTeacher_id";

            $stmp = $db->query($queryShow);
            $Result = $stmp->fetchAll(PDO::FETCH_ASSOC);

            $json = Array();

            foreach ($Result as $value) {
                $json[] = [
                    $value['ID'],
                    $value['Name'],
                    $value['TeacherFIO'],
                    $value['Description'],
                    sprintf("<button class=\"btn btn-info\" onclick=\"EditDiscipline(%s)\"><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-pencil-square\" viewBox=\"0 0 16 16\">
  <path d=\"M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z\"/>
  <path fill-rule=\"evenodd\" d=\"M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z\"/>
</svg></button><button class=\"btn btn-danger\" onclick=\"DeleteDiscipline(%s)\"><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-trash\" viewBox=\"0 0 16 16\">
  <path d=\"M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z\"/>
  <path fill-rule=\"evenodd\" d=\"M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z\"/>
</svg></button>", $value['ID'], $value['ID'])
                ];
            }

            $RESPONSE_AJAX['data']=$json;
            $RESPONSE_AJAX['success']=true;
            exit (json_encode($RESPONSE_AJAX));


        }

        //Редактирование дисциплины
        case 'add':{
            $DisciplineName = $_POST['DisciplineName'];
            $TeacherID = $_POST['Teacher'];
            $Description = $_POST['DisciplineDescription'];

            if($_POST['DisciplineID'] == '') {
                $Insert = "INSERT into discipline(DISC_name, DISC_LeadTeacher_id, DISC_Description) 
VALUE(:DisciplineName, :Teacher, :DisciplineDescription)";

                $stmp = $db->prepare($Insert);

                $Result = $stmp->execute([
                    'DisciplineName' => $DisciplineName,
                    'Teacher' => $TeacherID,
                    'DisciplineDescription' => $Description
                ]);

                if ($Result)
                    exit("<div class='alert alert-success'>Дисциплина создана!</div>");
                else
                    exit("<div class='alert alert-danger'>Ошибка создания дисциплины</div>");
            }
            else
            {$ID = $_POST['DisciplineID'];

                $UpdateQuery = "Update jagu.discipline Set DISC_name = :Name, DISC_LeadTeacher_id = :Teacher, DISC_Description = :Description WHERE DISC_id = :id";
                $stmp = $db->prepare($UpdateQuery);

                $Result = $stmp->execute([
                    'Name'=>$DisciplineName,
                    'Teacher'=>$TeacherID,
                    'Description'=>$Description,
                    'id'=>$ID,
                ]);

                if ($Result)
                    exit("<div class='alert alert-success'>Информация обновлена</div>");
                else
                    exit("<div class='alert alert-danger'>Ошибка при обновлении информации!</div>");

            }

        }

        //Удаление дисциплины
        case 'delete':
        {
            if(!isset($_POST['DisciplineID']) || empty($_POST['DisciplineID']) || $_POST['DisciplineID'] == '')
                exit("<div class='alert-danger alert'>API Error: ошибка входных параметров!</div>");

            $DisciplineID = $_POST['DisciplineID'];

            $DeleteQuery = "Delete from discipline WHERE DISC_id = :DisciplineID";
            $stmp = $db->prepare($DeleteQuery);

            $Result = $stmp->execute(['DisciplineID'=>$DisciplineID]);

            if($Result)
                exit("<div class='alert alert-success'>Дисциплина удалена!</div>");
            else
                exit("<div class='alert alert-danger'>Ошибка удаления дисциплины</div>");

        }

        //Получение ифнориации о дисциплине
        case 'get':
        {
          $ID = $_POST['DisciplineID'];
          $Query = "Select DISC_name As Name, DISC_LeadTeacher_id As TeacherID, DISC_Description As Description from discipline WHERE DISC_id = :ID";

          $stmp = $db->prepare($Query);

          $stmp->execute(['ID'=>$ID]);

          $Result = $stmp->fetch();

          exit(json_encode($Result));

        }

        default:
        {
            exit("<div class='alert-danger alert'>API Error: Не могу разобрать тип запроса!</div>");
        }

    }
}catch (PDOException $exception)
{
    exit("<div class='alert alert-danger'>Ошибка обработки запроса!<br>Код ошибки: ".$exception->getCode()."</div>");
}


