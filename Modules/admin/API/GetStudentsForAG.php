<?php
//API: получение списка студентов академ. группы





if(!isset($_POST['AGCode']) && !isset($_POST['SGID']))
    exit(json_encode('Пустой запрос!'));

require_once($_SERVER['DOCUMENT_ROOT'].'/cfg/core.php');

// Выборка всех студентов группы
if(isset($_POST['AGCode']) And !isset($_POST['isNotSG'])) {
    $AGCode = $_POST['AGCode'];

    $query = "Select SP_id as ID,
       CONCAT(SP_Surname, ' ', SP_Name, ' ', SP_MiddleName) As StudentFIO,
       SP_NumberOfBook As NumberBook,
       SP_TypeOfStudy As TypeOfStudy 
from studentprofile where SP_AcademGroup_id = :AGCode";

    try {
        $db = db_connect();
        if ($db == null)
            exit(json_encode('Error db!'));

        $stmp = $db->prepare($query);
        $stmp->execute(array('AGCode' => $AGCode));

        $Rsult = $stmp->fetchAll(PDO::FETCH_ASSOC);

        //Если данные требуются для объекта DataTables
        if ($_POST['Type'] == 'jsonForDT') {

            $json = array();

            foreach ($Rsult as $row) {
                $json[] = array(
                    '1' => $row['StudentFIO'],
                    '2' => $row['ID'],
                    '3' => $row['NumberBook'],
                    '4' => $row['TypeOfStudy']
                );
            }

            $RESPONSE_AJAX['data'] = $json;
            $RESPONSE_AJAX['success'] = true;

            exit(json_encode($RESPONSE_AJAX));
        }

        exit(json_encode($Rsult));


    } catch (PDOException $exception) {
        $RESPONSE_AJAX['ErrorInfo'] = $exception->getMessage();
        exit(json_encode($RESPONSE_AJAX));
    }
}


//Выборка всех студентов группы AGCode, не входящих в SGID подгруппу

if(isset($_POST['isNotSG']) == true And isset($_POST['AGCode']) And isset($_POST['SGID']))
{
    $AGCode = $_POST['AGCode'];
    $SGID = $_POST['SGID'];
    $query = "Select SP_id As ID,
            CONCAT(SP_Surname, ' ', SP_Name, ' ', SP_MiddleName) As FIO
       from studentprofile 
left join studentlistinsubgroups s on studentprofile.SP_id = s.SLS_Student_id
where SP_AcademGroup_id = :AGCode AND (s.SLS_SubGroups_id != :SGID Or s.SLS_SubGroups_id is null )";

    try{
        $db = db_connect();
        $stmp = $db->prepare($query);
        $stmp->execute([
            'AGCode'=>$AGCode,
            'SGID'=>$SGID
        ]);

        $Result = $stmp->fetchAll(PDO::FETCH_ASSOC);

        $json = array();

        foreach ($Result as $value)
            $json[] = array(
                '1' =>  $value['FIO'],
                '2' => $value['ID']
            );

        $RESPONSE_AJAX['data']= $json;
        $RESPONSE_AJAX['success']=true;

        exit (json_encode($RESPONSE_AJAX));

    }
    catch (PDOException $exception)
    {
       $RESPONSE_AJAX['success']=false;
       $RESPONSE_AJAX['ErrorInfo']=$exception->getMessage();
       exit($RESPONSE_AJAX);
    }



}



// Выборка всех студентов подгруппы
if(isset($_POST['SGID']))
{
    $SGID = $_POST['SGID'];

    $QueryStudentListForSG = "Select s.SP_id As ID, CONCAT(s.SP_Surname, ' ', s.SP_Name, ' ', s.SP_MiddleName) As FIO from studentlistinsubgroups 
    join studentprofile s on s.SP_id = studentlistinsubgroups.SLS_Student_id
    where SLS_SubGroups_id = :SGID";

    try{

        $db = db_connect();

        $stmp = $db->prepare($QueryStudentListForSG);

        $stmp->execute(['SGID'=>$SGID]);

        $Result = $stmp->fetchAll(PDO::FETCH_ASSOC);

        $json = Array();

        foreach ($Result As $value)
            $json[] = array(
               '1'=> $value['FIO'],
                '2'=>$value['ID']
            );


        $RESPONSE_AJAX['data'] = $json;
        $RESPONSE_AJAX['success'] = true;


        exit(json_encode($RESPONSE_AJAX));

    }catch (PDOException $exception)
    {
        $RESPONSE_AJAX['success']=false;
        $RESPONSE_AJAX['ErrorInfo'] = $exception->getMessage();
        exit($RESPONSE_AJAX);
    }
}