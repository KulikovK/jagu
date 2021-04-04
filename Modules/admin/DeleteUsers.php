<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/cfg/core.php');
$Page_Title='Удаление пользователя';
if(isAuthUser() != 'admin' || !isset($_GET['id']) || !$_GET['id']) {
    header("Location: /");
    exit();
}

$UserID = $_GET['id'];

if(!isset($_GET['comf'])){


    $db = db_connect();
    $queryInStudents = 'Select CONCAT(SP_Surname, " ", SP_Name, " ", SP_MiddleName) As FIO, 
      SP_NumberOfBook As NumberBook, AG_Code, s.SL_Name,AG_NumCuorse , f.FOS_Name from studentprofile join academicgroups a on a.AG_Code = studentprofile.SP_AcademGroup_id 
join specialtylist s on a.AG_specialty = s.SL_id
join formatofstudy f on a.AG_FormOfStudy = f.FOS_id
where SP_id = :id';
    $queryInTeacher = 'Select * from teacherprofile where TP_UserID= :id';

    $stmp = $db->prepare($queryInStudents);



    if(!$stmp->execute(array('id'=>$UserID))) {
        $stmp = $db->prepare($queryInTeacher);
        $stmp->execute(array('id' => $UserID));
    }

$data = $stmp->fetch();

    if(!$data)
        Header("Location: /Modules/admin/?page=Users");


    require_once ($_SERVER['DOCUMENT_ROOT'].'/template/head.php');
?>
<body class="bg-dark">

    <div class="alert top" tabindex="-1" role="dialog">

        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h4 class="modal-title">Подтверждение</h4>
                </div>
                <div class="modal-body">
                  <p>Вы уверены, что хотите удалить следующего пользователя?</p>
<table class="table">
    <thead class="text-center thead-light">


    </thead><tbody class="">

            <tr>
                <th class="text-right">Студент:</th>
                <td><?=$data['FIO']?></td>
            </tr>
    <tr>
        <th class="text-right">Номер зачетной книжки:</th>
        <td><?=$data['NumberBook']?></td>
    </tr>

    <tr>
        <th class="text-right">Группа/Специальность:</th>
        <td><?=$data['AG_Code'].' - '.$data['SL_Name']?></td>
    </tr>

    <tr>
        <th class="text-right">Курс/форма обучения:</th>
        <td><?=$data['AG_NumCuorse'].' курс, '.$data['FOS_Name'].' форма обучения'?></td>
    </tr>

        <?
    ?>

    </tbody>
</table>

                </div>
                <div class="modal-footer bg-danger justify-content-between">
                    <p class="left text-light"><strong>Внимание:</strong> данная операция необратима!</p>
                    <div>
                    <a href="?comf&id=<?= $_GET['id']?>" class="btn btn-light">Да, удалить</a>
                    <a href="../admin/?page=Users" class="btn btn-light" data-dismiss="modal">Отмена</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
    <?php
    exit();
}

    ?>
<?php
try {
    $db = db_connect();
    $query = "Delete from users WHERE User_id= :id";
    $stmp = $db->prepare($query);

    $delete = $stmp->execute(array('id'=>$UserID));
    if($delete)
        Header("Location: /Modules/admin/?page=Users&operation=delete&status=ok");
    else
        Header("Location: /Modules/admin/?page=Users&operation=delete&status=error");


}catch (PDOException $exception)
{
    Header("Location: /Modules/admin/?page=Users&operation=delete&status=error");
}


