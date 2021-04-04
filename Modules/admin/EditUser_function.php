<?php

if(isset($_GET['save']) && isset($_GET['id'])) {

    switch ($_GET['type'])
    {
        case 'student':
        {
            $id = $_GET['id'];
            $Surname = $_POST['Surname'];
            $Name = $_POST['Name'];
            $Middle = $_POST['Middle'];
            $BrieflyName = $_POST['BrieflyName'];
            $DateOfBirth = $_POST['DateOfBirth'];
            $Gender = $_POST['Gender'];
            $TypeOfStudy = $_POST['TypeOfStudy'];
            $NumberBook = $_POST['NumberBook'];
            $AG_Code = $_POST['AG_Code'];
            $Login = $_POST['Login'];
            $Email = $_POST['Email'];
            try {
                $db = db_connect();

                $UpdateQuery = "Update jagu.studentprofile 
join users u on studentprofile.SP_id = u.User_id
set 
                               u.User_email = :email,
                               u.User_login = :login,
                               SP_Surname = :Surname, 
                               SP_Name = :Name, 
                               SP_MiddleName = :MiddleName, 
                               SP_BrieflyName = :BrieflyName, 
                               SP_DataOfBirth  = :DateOfBirth,
                               SP_Gender = :Gender, 
                               SP_TypeOfStudy = :TypeOfStudy, 
                               SP_NumberOfBook = :NumberBook, 
                               SP_AcademGroup_id = :AG_Code
                               
            WHERE SP_id = :id";

                $stmp = $db->prepare($UpdateQuery);

                if ($stmp->execute([
                    ":email" => $Email,
                    ":login" => $Login,
                    ":Surname" => $Surname,
                    ":Name" => $Name,
                    ":MiddleName" => $Middle,
                    ":BrieflyName" => $BrieflyName,
                    ":DateOfBirth" => $DateOfBirth,
                    ":Gender" => $Gender,
                    ":TypeOfStudy" => $TypeOfStudy,
                    ":NumberBook" => $NumberBook,
                    ":AG_Code" => $AG_Code,
                    ":id"=>$id
                ]))
                    Header("Location: /Modules/admin/?page=Users&operation=edit&status=ok");
                else
                    Header("Location: /Modules/admin/?page=Users&operation=edit&status=error");
                break;
            }
            catch (PDOException $exception)
            {
                Header("Location: /Modules/admin/?page=Users&operation=edit&status=error");
            }
        }

    }


}
