<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/cfg/core.php');

if(isAuthUser() !== 'admin') {
    echo json_encode('Нарушение прав доступа!');
    exit();
}

$query = "select User_id as ID, u.User_email As Email,
       TP_Surname As Surname,
       TP_Name As Name,
       TP_MiddleName As MiddleName,
       TP_Gender As Gender,
       TP_DataOfBirth As DOB,
       a2.AT_name As Title,
       d.DEP_Abbreviation As Departament,
       f.FCT_Abbreviation As Faculty
from teacherprofile
left join users u on teacherprofile.TP_UserID = u.User_id
left join academictitle a2 on teacherprofile.TP_AcademicTitle = a2.AT_id
left join departments d on teacherprofile.TP_Department = d.DEP_id
left join faculties f on d.DEP_Faculty_id = f.FCT_id";

$db = db_connect();

if($db==NULL) {
    echo json_encode('Ошибка подключения к базе данных');
    exit();
        }

$stmp = $db->query($query);

$TeacherData = $stmp->fetchAll(PDO::FETCH_ASSOC);

$json = array();


foreach($TeacherData as $row)
{
  $json[] = array(
     $row['ID'],
      $row['Email'],
      $row['Surname'],
      $row['Name'],
      $row['MiddleName'],
      $row['Gender'],
      $row['DOB'],
      $row['Title'],
      $row['Departament'],
      $row['Faculty'],
      '<td xmlns="http://www.w3.org/1999/html"><div class="btn-group" role="group">
<button title="Редактировать информацию о пользователе" class="btn btn-info" onclick="showEditForm(' . $row['ID'] . ')" id="btnTeacherEdit">
<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
</svg>
</button>
<button title="Удалить пользователя" value="" onclick="getUserInfo(' . $row['ID'] . ')" class="btn btn-danger"">
<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
  <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
</svg></button>
</div></td>'
  );
}


$response = array();
$response['data'] = $json;
$response['success'] = true;
echo json_encode($response);
