<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/cfg/core.php');


if(isAuthUser() != 'admin' || !isset($_POST['id']) || $_POST['id']=='') {
    echo '<p class="alert-warning h4">Ошибка передачи данных или авторизованности!<p>';
    exit();
}

$id = $_POST['id'];

$query = "
select TP_Surname as Surname,
       TP_Name as Name,
       TP_MiddleName As MiddleName,
       TP_BrieflyName As BrieflyName,
       TP_Gender As Gender,
       TP_DataOfBirth As DOB,
       a.AD_name As Degree,
       a2.AT_name As AcademicTitle,
       FCT_id As FCT_id,
       d.DEP_Name As DEP,
       u.User_email As Email,
       u.User_login As Login,
       TP_UserID As ID
       
       from teacherprofile
left join academicdegree a on teacherprofile.TP_Degree = a.AD_id
left join academictitle a2 on teacherprofile.TP_AcademicTitle = a2.AT_id
left join departments d on teacherprofile.TP_Department = d.DEP_id
left join faculties f on d.DEP_Faculty_id = f.FCT_id
join users u on teacherprofile.TP_UserID = u.User_id

where TP_UserID = :id;
";

$db = db_connect();

if($db==null) {
    echo 'Не могу подключится к базе!';
    exit();
}

$stmp = $db->prepare($query);
$stmp->execute(array('id'=>$id));

$Data = $stmp->fetch();

if(!$Data) {
    echo 'Пришли пустые данные!';
    exit();
}

?>

<form id="formEditTeacher" class="form-horizontal">

    <label>
        <input name="ID" hidden value="<?=$Data['ID'];?>">
    </label>
    <div class="form-group row">
        <label class="control-label col-form-label col-sm-4">Фамилия</label>

        <div class="col-sm-8">
            <input class="form-control" name="Surname" value="<?= $Data['Surname'];?>">
        </div>

    </div>

    <div class="form-group row">
        <label class="control-label col-form-label col-sm-4">Имя</label>

        <div class="col-sm-8">
            <input class="form-control" name="Name" value="<?= $Data['Name'];?>">
        </div>

    </div>

    <div class="form-group row">
        <label class="control-label col-form-label col-sm-4">Отчество</label>

        <div class="col-sm-8">
            <input class="form-control" name="MiddleName" value="<?= $Data['MiddleName'];?>">
        </div>

    </div>

    <div class="form-group row">
        <label class="control-label col-form-label col-sm-4">Инициалы</label>

        <div class="col-sm-8">
            <input class="form-control" name="BrieflyName" value="<?= $Data['BrieflyName'];?>">
        </div>

    </div>

    <div class="form-group row">
        <label class="control-label col-form-label col-sm-4">Пол:</label>
        <div class="col-sm-8">
        <div class="custom-control custom-radio">
            <label class="form-check-label">
                <input class="custom-control-input" id="TeacherGenderMan" type="radio" name="Gender" required value="М" <?= $Data['Gender']=='М' ? 'checked' : '' ?>/>
                <label class="custom-control-label" for="TeacherGenderMan">Мужской</label>
            </label>
        </div>

            <div class="custom-control custom-radio">
                <label class="form-check-label">
                    <input class="custom-control-input" id="TeacherGenderWoman" type="radio" name="Gender" required value="Ж" <?= $Data['Gender']=='Ж' ? 'checked' : '' ?>/>
                    <label class="custom-control-label" for="TeacherGenderWoman">Женский</label>
                </label>

            </div>

        </div>
    </div>

    <div class="form-group row">
        <label class="control-label col-form-label col-sm-4">Дата рождения</label>

        <div class="col-sm-8">
            <input class="form-control" type="date" name="DOB" value="<?= $Data['DOB'];?>">
        </div>

    </div>

    <?
    $query = 'Select AD_id, AD_name from academicdegree';

    $dataDegree = $db->query($query)->fetchAll();
    ?>

    <div class="form-group row">
        <label class="control-label col-form-label col-sm-4">Ученая степень</label>
            <label class="col-sm-8">
                <select name="AcademicDegree" class="custom-select">
                    <option></option>
                    <?
                    foreach ($dataDegree as $row)
                        echo '<option value="'.$row['AD_id'].'" '.($Data['Degree'] == $row['AD_name'] ? 'selected' : '') .' >'.$row['AD_name'].'</option>';
                    ?>
                </select>
            </label>
    </div>

    <?
    $query = "Select AT_id, AT_name from academictitle";

    $dataAcademicTitle = $db->query($query)->fetchAll();
    ?>

    <div class="form-group row">
        <label class="control-label col-form-label col-sm-4">Ученое звание(должность):</label>
            <label class="col-sm-8">
                <select name="AcademicTitle" class="custom-select">
                    <option></option>
                    <?
                    foreach ($dataAcademicTitle as $row)
                        echo '<option value="'.$row['AT_id'].'" '.($Data['AcademicTitle'] == $row['AT_name'] ? 'selected' : '') .' >'.$row['AT_name'].'</option>';
                    ?>
                </select>
            </label>
    </div>

    <?
      $query = "Select FCT_id, FCT_name from faculties";

      $dataFaculty = $db->query($query)->fetchAll();
    ?>

    <div class="form-group row">
        <label class="control-label col-form-label col-sm-4">Факультет</label>
        <label class="col-sm-8">
            <select id="FacultyList" class="custom-select">
                <option></option>
                <?
                foreach ($dataFaculty as $row)
                    echo '<option value="'.$row['FCT_id'].'" '.($Data['FCT_id'] == $row['FCT_id'] ? 'selected' : '') .' >'.$row['FCT_name'].'</option>';
                ?>
            </select>
        </label>
    </div>

    <?
    $query = "select DEP_id, DEP_Name from departments where DEP_Faculty_id = :FCT_id";
    $stmp = $db->prepare($query);
    $stmp->execute(array('FCT_id'=>$Data['FCT_id']));
    $dataDEP = $stmp->fetchAll();
    ?>

    <div class="form-group row">
        <label class="control-label col-form-label col-sm-4">Кафедра</label>
        <label class="col-sm-8">
            <select name="Departaments" id="DepartamentsList" class="custom-select">
                <option></option>
                <?
                foreach ($dataDEP as $row)
                    echo '<option value="'.$row['DEP_id'].'" '.($Data['DEP'] == $row['DEP_Name'] ? 'selected' : '') .' >'.$row['DEP_Name'].'</option>';
                ?>
            </select>
        </label>
    </div>

    <div class="form-group row">
        <label class="control-label col-form-label col-sm-4">Email:</label>

        <div class="col-sm-8">
            <input class="form-control" name="Email" value="<?= $Data['Email'];?>">
        </div>

    </div>

    <div class="form-group row">
        <label class="control-label col-form-label col-sm-4">Логин:</label>

        <div class="col-sm-8">
            <input class="form-control" name="Login" value="<?= $Data['Login'];?>">
        </div>

    </div>

</form>

<script>
    $("#FacultyList").change(function (){
        let id = $("#FacultyList").val();
      //  $('#DepartamentsList').prop('disabled', true)
        $.ajax({
            method: 'GET',
            url: 'departaments.php',
            data: {id: id},
            dataType: 'JSON',
            cache: false,
            success: function (ListDEP)
            {
                $("#DepartamentsList")
                    //.prop("disabled", false)
                    .html($("<option></option>"));
                 console.log(ListDEP);
                for(let id in ListDEP){
                    // alert(DepartamentsList[id]['ID']+'\n'+DepartamentsList[id]['Name']);
                    $("#DepartamentsList").append("<option value='"+ListDEP[id]['ID']+"'>"+ListDEP[id]['Name']+"</option>")
                }
            }
        });
    })

    $("#formEditTeacher *").change(function (){
        $("#btnEditTeacher").prop('disabled', false);
    })
</script>
