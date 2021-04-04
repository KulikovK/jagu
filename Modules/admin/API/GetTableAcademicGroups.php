<?php
// API: получение подробных данных об академических группах

require_once ($_SERVER['DOCUMENT_ROOT'].'/cfg/core.php');
if(!isset($_POST['AGCode']))
{
    $query = "Select AG_Code As AGCode,
            f2.FCT_name As Faculty,
            CONCAT(s.SL_Name , ' / ',
            s4.SProf_name) As Specialty,
            AG_YearOfStart As YearStart,
       AG_YearOfEnd As YearEnd,
       AG_NumCuorse As NumberCurse,
       CONCAT(t.TP_Surname, ' ', t.TP_Name, ' ', t.TP_MiddleName) As Curator,
       CONCAT(s2.SP_Surname, ' ', s2.SP_Name, ' ', s2.SP_MiddleName) As Headman,
       f.FOS_Name As FormOfStudy,
       count(s3.SP_id) As CountStudent
from academicgroups
join specialtylist s on academicgroups.AG_specialty = s.SL_id
join specialtyprofile s4 on s.SL_Profile_id = s4.SProf_id
join faculties f2 on s.SL_Faculty_id = f2.FCT_id
left join teacherprofile t on academicgroups.AG_Curator = t.TP_UserID
left  join studentprofile s2 on academicgroups.AG_Headman = s2.SP_id
left join studentprofile s3 on s3.SP_AcademGroup_id = AG_Code
join formatofstudy f on f.FOS_id = academicgroups.AG_FormOfStudy
group by AG_Code";

    try {
          $db = db_connect();
          if($db==null)
          {
              echo json_encode(array('success'=>false));
          }

          $stmp = $db->query($query);

          $AGData = $stmp->fetchAll(PDO::FETCH_ASSOC);

          $json = Array();

          foreach ($AGData As $row)
          {
              $json[] = array(
                  $row['AGCode'],
                  $row['Faculty'],
                  $row['Specialty'],
                  $row['YearStart'],
                  $row['YearEnd'],
                  $row['FormOfStudy'],
                  $row['NumberCurse'],
                  $row['Curator'],
                  $row['Headman'],
                  $row['CountStudent']
              );
          }

         /* $response = array();
          $response['data'] = $json;
          $response['success'] = true;*/

        $RESPONSE_AJAX['data']=$json;
        $RESPONSE_AJAX['success']=true;
          echo json_encode($RESPONSE_AJAX);


    }catch (PDOException $exception)
    {
        echo json_encode(array('success'=>false));
    }

} // Вывод всех академических гупп

if(isset($_POST['AGCode']))       // Вывод академической группы по ее коду
{
    $AGCode = $_POST['AGCode'];
    $query = "Select AG_Code As AGCode,
       s.SL_id As SpecialtyID,
       s.SL_Name As SpecialtyName,
       f2.FCT_id As FacultyID,
       AG_YearOfStart As YearStart,
       AG_YearOfEnd As YearEnd,
       AG_NumCuorse As Course,
       concat(s2.SP_Surname, ' ', s2.SP_Name, ' ', s2.SP_MiddleName) as HeadmanFIO,
       AG_Headman As HeadmanID, # староста id
       t.TP_UserID As TeacherID,
       f.FOS_id As FOSID,
       f.FOS_Name As FOSName
from academicgroups
join specialtylist s on academicgroups.AG_specialty = s.SL_id
left join faculties f2 on s.SL_Faculty_id = f2.FCT_id
left join teacherprofile t on academicgroups.AG_Curator = t.TP_UserID
join formatofstudy f on academicgroups.AG_FormOfStudy = f.FOS_id
left join studentprofile s2 on academicgroups.AG_Headman = s2.SP_id
where AG_Code = :AGCode";

    try{
        $db=db_connect();
        if($db==null)
        {
            exit(json_encode('Ошибка подключения к базе данных'));
        }

        $stmp = $db->prepare($query);
        $stmp->execute(array('AGCode'=>$AGCode));

        $AGData = $stmp->fetch();

        if(!$AGData)
            exit(json_encode('Запись не найдена!'));
        else
            echo json_encode($AGData);

    }
    catch (PDOException $exception)
    {
        $RESPONSE_AJAX['success'] = false;
        $RESPONSE_AJAX['ErrorInfo']=$exception->getMessage();

        echo json_encode($RESPONSE_AJAX);
    }
}
