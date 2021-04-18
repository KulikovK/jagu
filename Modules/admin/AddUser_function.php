<?php
/*
 * Copyright (c) 2021. Kulikov K. P. [kostj1998.10.13@yandex.ru]
 * Project: JAGU
 * Module:
 * Submodule:
 * Description:
 * Version:
 */

/*
 * Copyright (c) 2021. Kulikov K. P. [kostj1998.10.13@yandex.ru]
 * Project: JAGU
 * Module:
 * Submodule:
 * Description:
 * Version:
 */

/*Функционал добавления пользователей*/
require_once ($_SERVER['DOCUMENT_ROOT'].'/cfg/core.php');

if (isset($_GET['student'])) {
    //Header('Location: /Modules/Admin/?page=Users');
    // Изавлекаем данные из запроса
    $Surname = $_POST['Surname'];
    $Name = $_POST['Name'];
    $MiddleName = $_POST['MiddleName'];
    $BrieflyName = $_POST['BrieflyName'];
    $Gender = $_POST['Gender'];
    $DateOfBirth = $_POST['DateOfBirth'];
    $TypeOfStudy = $_POST['TypeOfStudy'];
    $NumberBook = $_POST['NumberBook'];
    $AG_Code = $_POST['AG_Code'];
    $Email = $_POST['Email'];
    $Login = $_POST['Login'];
    $Password = $_POST['Password'];

    // Если хоть одно из полей(обязательных) пустое - отправлем пользователя обратно
    if ($Surname == "" || $Name == "" || $Gender == "" || $DateOfBirth == "" || $TypeOfStudy == "" || $NumberBook == "" ||
        $AG_Code == "" || $Email == "" || $Login == "" || $Password == "") {
        header("Location: /Modules/admin?page=Users");
        exit();
    }

    try {
        $db = db_connect();

        if ($db == NULL)
            header('Location: /?Error=db');

        $queryAddUsers = "INSERT INTO users( user_login, user_email, user_passwd, user_role) VALUE(:login, :email, :password, :role)";

        $stmp = $db->prepare($queryAddUsers);

        if ($stmp->execute(array('login' => $Login, 'email' => $Email, 'password' => password_hash($Password, PASSWORD_DEFAULT), 'role' => 4))) {
            $NewUserId = $db->lastInsertId(); //Получаем id вставленного пользователя
            $queryAddUsersProfile = "INSERT INTO studentprofile(
                           SP_id,
                           SP_Surname, 
                           SP_Name, 
                           SP_MiddleName, 
                           SP_BrieflyName, 
                           SP_Gender, 
                           SP_DataOfBirth, 
                           SP_TypeOfStudy, 
                           SP_NumberOfBook, 
                           SP_AcademGroup_id) VALUE(:SP_id,:Surname, :Name, :MiddleName, :BrieflyName, :Gender, :DOB, :TypeOfStudy, :NumberBook, :AG_Code)";
            $stmp = $db->prepare($queryAddUsersProfile);

            if ($stmp->execute(array(":SP_id" => $NewUserId, ":Surname" => $Surname, ":Name" => $Name, ":MiddleName" => $MiddleName, ":BrieflyName" => $BrieflyName, ":Gender" => $Gender, ":DOB" => $DateOfBirth, ":TypeOfStudy" => $TypeOfStudy, ":NumberBook" => $NumberBook, ":AG_Code" => $AG_Code))) {
               if(GenerationActivationCode($NewUserId, $Email))
                  Header('Location: /Modules/admin/?page=Users&operation=addStudent&status=ok&id=' . $NewUserId);
            else
                Header('Location: /Modules/admin/?page=Users&operation=addStudent&status=error');
            }
        }

    }
    catch (PDOException $exception)
    {
        Header('Location: /Modules/admin/?page=Users&operation=addStudent&status=error');
    }
}

if(isset($_GET['teacher'])){

    $Surname  = $_POST['Surname'];
$Name = $_POST['Name'];
$MiddleName = isset($_POST['MiddleName'])? $_POST['MiddleName'] : null;
$BrieflyName = isset($_POST['BrieflyName']) ? $_POST['BrieflyName'] : null;;
$DateOfBirth = $_POST['DateOfBirth'];
$GenderTeacher = $_POST['GenderTeacher'];
$AcademicDegree = isset($_POST['AcademicDegree']) && $_POST['AcademicDegree'] != '' ? $_POST['AcademicDegree'] : null;
$AcademicTitle = isset($_POST['AcademicTitle']) && $_POST['AcademicTitle'] != ''  ?$_POST['AcademicTitle'] : null ;
$Departaments = isset($_POST['Departaments']) && $_POST['Departaments'] != '' ? $_POST['Departaments'] : null ;
$Email = $_POST['Email'];
$Login = $_POST['Login'];
$Password = $_POST['Password'];

if(isset($_POST['SetAdmin']))
$SetAdmin = $_POST['SetAdmin'];
else
    $SetAdmin = 3;

   if($Surname == '' ||   $Name == '' ||
      $DateOfBirth == '' || $GenderTeacher == ''  ||
 $Email == '' || $Login == '' || $Password == '')
   {
       header("Location: /Modules/admin?page=Users");
       exit();
   }

   try{
       $db = db_connect();
       $queryAddUsers = "INSERT INTO users( user_login, user_email, user_passwd, user_role) VALUE(:login, :email, :password, :role)";
       $stmp = $db->prepare($queryAddUsers);

       if($stmp->execute([":login"=>$Login, ":email"=>$Email, ":password"=>password_hash($Password, PASSWORD_DEFAULT), ":role"=>$SetAdmin]))
       {
           $NewUserId = $db->lastInsertId();
           $queryAddTeacherProfile = "INSERT INTO teacherprofile(TP_UserID, TP_Surname, TP_Name, TP_MiddleName, TP_BrieflyName, TP_Gender, TP_DataOfBirth, TP_Degree, TP_AcademicTitle, TP_Department) 
VALUE(:ID,:Surname,:Name,:MiddleName, :BrieflyName, :Gender, :DateOfBirth, :Degree, :AcademicTitle, :Departamets)";
           $stmp = $db->prepare($queryAddTeacherProfile);

           $Result = $stmp->execute([
               ":ID"=>$NewUserId,
               ":Surname"=>$Surname,
               ":Name"=>$Name,
               ":MiddleName"=>$MiddleName,
               ":BrieflyName"=>$BrieflyName,
               ":Gender"=>$GenderTeacher,
               ":DateOfBirth"=>$DateOfBirth,
               ":Degree"=>$AcademicDegree,
               ":AcademicTitle"=>$AcademicTitle,
               ":Departamets" => $Departaments
           ]);

           if($Result)
               if(GenerationActivationCode($NewUserId, $Email))
               Header('Location: /Modules/admin/?page=Users&operation=addTeacher&status=ok&id=' . $NewUserId);
           else
               Header('Location: /Modules/admin/?page=Users&operation=addTeacher&status=error');


       }


   }catch (PDOException $exception)
   {
      // Header('Location: /Modules/admin/?page=Users&operation=addTeacher&status=error');
      echo $exception->getMessage();
   }

}