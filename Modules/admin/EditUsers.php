<?php
// Редактирование пользователей - интерфейс
require_once $_SERVER['DOCUMENT_ROOT'].'/cfg/core.php';

if(!isset($_GET['type']) || !isset($_GET['id']) || isAuthUser() != 'admin') {
    header("Location: /");
    exit();
}

require_once("EditUser_function.php");


switch ($_GET['type'])
{
    case 'student':
    {
        $db= db_connect();
        $query = "Select 
       SP_Surname as Surname, 
       SP_Name as Name, 
       SP_MiddleName MiddleName, 
       SP_BrieflyName as BrieflyName,
       SP_Gender as Gender, 
       SP_DataOfBirth As DateOfBirth, 
       SP_TypeOfStudy As TypeOfStudy, 
       SP_NumberOfBook As NumberBook, 
       SP_AcademGroup_id As AG_Code, 
       User_login As Login, 
       User_email As Email
       
       from studentprofile join users u on studentprofile.SP_id = u.User_id where SP_id = :id";
        $stmp = $db -> prepare($query);
        $stmp->execute(array("id"=>$_GET['id']));

        $OutData = $stmp->fetch();

        if(!$OutData) {
            Header("Location: /Modules/admin/?page=Users");
            exit();
        }

        $query = "Select AG_Code, AG_NumCuorse, FOS_Name, SL_Name from academicgroups join specialtylist s on academicgroups.AG_specialty = s.SL_id join formatofstudy f on f.FOS_id = academicgroups.AG_FormOfStudy";
        $AGList = $db->query($query);

        $Page_Title = 'Редактировать';
            require_once($_SERVER['DOCUMENT_ROOT'].'/template/head.php');
        ?>
            <body class="bg-dark">
        <div class="alert fade show active" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-success text-center">
                        <h5 class="modal-title text-white text-center">Редактирование данных</h5>
                    </div>
                    <div class="modal-body">
<div class="container">

                        <form id="StudentProfileEdit" action="?type=student&id=<?=$_GET['id'];?>&save" method="post">
                            <div class="form-group  row">
                            <label for="Surname" class="col-sm-4 col-form-label form-text">Фамилия:</label>
                                <label class="col-sm-8">
                                    <input name="Surname" id="Surname" type="text" class="form-control" required value="<?=$OutData['Surname'];?>">
                                </label>
                            </div>

                            <div class="form-group  row">
                                <label for="Name" class="col-sm-4 col-form-label form-text">Имя:</label>
                                <label class="col-sm-8">
                                    <input name="Name" id="Name" type="text" class="form-control" required value="<?=$OutData['Name'];?>">
                                </label>
                            </div>

                            <div class="form-group  row">
                                <label for="MiddleName" class="col-sm-4 col-form-label form-text">Отчество:</label>
                                <label class="col-sm-8">
                                    <input name="Middle" id="MiddleName" type="text" class="form-control" value="<?=$OutData['MiddleName'];?>">
                                </label>
                            </div>

                            <div class="form-group  row">
                                <label for="BrieflyName" class="col-sm-4 col-form-label form-text">Инициалы:</label>
                                <label class="col-sm-8">
                                    <input name="BrieflyName" id="BrieflyName" type="text" class="form-control" value="<?=$OutData['BrieflyName'];?>">
                                </label>
                            </div>

                            <div class="form-group  row">
                                <label for="DateOfBirth" class="col-sm-4 col-form-label form-text">Дата рождения:</label>
                                <label class="col-sm-8">
                                    <input name="DateOfBirth" id="DateOfBirth" type="date" class="form-control" required value="<?=$OutData['DateOfBirth'];?>">
                                </label>
                            </div>

                            <div class="form-group row">
                                <legend class="col-form-label col-sm-4">Пол:</legend>
                                <div class="col-sm-8">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="Gender" required value="М" <?= $OutData['Gender']=='М' ? 'checked' : '' ?>/>Мужской
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="Gender" required value="Ж" <?= $OutData['Gender']=='Ж' ? 'checked' : '' ?>/>Женский

                                        </label>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row">
                                <legend class="col-form-label col-sm-4">Тип обучения:</legend>
                                <div class="col-sm-8">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="TypeOfStudy" required value="Б" <?= $OutData['TypeOfStudy']=='Б' ? 'checked' : '' ?>/>Бюджет
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="TypeOfStudy" required value="К" <?= $OutData['TypeOfStudy']=='К' ? 'checked' : '' ?>/>Коммерция

                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group  row">
                                <label for="NumberBook" class="col-sm-4 col-form-label form-text">Номер зачетной книжки:</label>
                                <label class="col-sm-8">
                                    <input name="NumberBook" id="NumberBook" type="text" class="form-control" required value="<?=$OutData['NumberBook'];?>">
                                </label>
                            </div>


                            <div class="form-group  row">
                                <label for="AG_Code" class="col-sm-4 col-form-label form-text">Группа:</label>
                                <label class="col-sm-8">
                                    <select name="AG_Code" class="custom-select" required id="AG_Code">
                                        <?
                                        foreach ($AGList as $AG)
                                        {
                                            echo '<option '.($OutData['AG_Code'] == $AG['AG_Code'] ? 'selected':" ").' >'.$AG['AG_Code'].'</option>';
                                        }
                                        ?>
                                    </select>
                                </label>
                            </div>

                            <div class="form-group  row">
                                <label for="Login" class="col-sm-4 col-form-label form-text">Логин:</label>
                                <label class="col-sm-8">
                                    <input name="Login" id="Login" type="text" required class="form-control" value="<?=$OutData['Login'];?>">
                                </label>
                            </div>

                            <div class="form-group  row">
                                <label for="Email" class="col-sm-4 col-form-label form-text">E-mail:</label>
                                <label class="col-sm-8">
                                    <input name="Email" id="Email" type="text" required class="form-control" value="<?=$OutData['Email'];?>">
                                </label>
                            </div>



                        </form>

</div>

                    </div>
                    <div class="modal-footer">
                        <button form="StudentProfileEdit"  class="btn btn-success">Сохранить</button>
                        <a href="../admin/?page=Users" class="btn btn-secondary" data-dismiss="modal">Отмена</a>
                    </div>
                </div>
            </div>
        </div>
            </body>
<?php
    }

    case 'teacher':
    {
        $db = db_connect();
        $query = "SELECT 
       TP_Surname as Surname, 
       TP_Name as Name, 
       TP_MiddleName as MiddleName, 
       TP_BrieflyName as BrieflyName,
       TP_DataOfBirth as DOB,
       TP_Gender As Gender,
       a.AD_name As ADegree,
       a2.AT_name As ATitle,
       d.DEP_Name As Departaments,
       u.User_email As email,
       u.User_login As login
FROM teacherprofile
left JOIN academicdegree a on teacherprofile.TP_Degree = a.AD_id
left join academictitle a2 on teacherprofile.TP_AcademicTitle = a2.AT_id
left join departments d on teacherprofile.TP_Department = d.DEP_id
join users u on teacherprofile.TP_UserID = u.User_id
where TP_UserID = :id";

        $stmp = $db->prepare($query);

        $stmp->execute(Array('id'=>$_GET['id']));

        $OutData = $stmp->fetch();

        if(!$OutData) {
            echo 'error';
          //  Header("Location: /Modules/admin/?page=Users");
            exit();
        }
        $Page_Title = 'Редактировать';
        require_once($_SERVER['DOCUMENT_ROOT'].'/template/head.php');
        ?>





<?php
    }
}


