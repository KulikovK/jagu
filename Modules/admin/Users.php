<?php
/*
 * Copyright (c) 2021. Kulikov K. P. [kostj1998.10.13@yandex.ru]
 * Project: JAGU
 * Module:
 * Submodule:
 * Description:
 * Version:
 */

defined('ADMIN') or Header('Location: /');

if (isset($_GET['operation']))
{
    switch ($_GET['operation']) {
        case 'addStudent':
        {
            if($_GET['status'] == 'error')
                echo '<div class="alert fade show alert-dismissible alert-danger" role="alert"><h5>Ошибка!</h5>
Не удалось добавить пользователя
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';
            else{
                $db = db_connect();
                $query = "Select SP_id, SP_Surname As Surname, SP_Name As Name, SP_AcademGroup_id As AG_Code, AG_NumCuorse As NumCourse from studentprofile join academicgroups a on a.AG_Code = studentprofile.SP_AcademGroup_id where SP_id = :SP_id";
                $stmp = $db->prepare($query);

                $stmp->execute(array(':SP_id'=>$_GET['id']));

                $Teacher = $stmp->fetch();

                echo '<div class="alert fade alert-dismissible show alert-success" role="alert"><h5>Успешно!</h5>
Студент <strong>'.$Teacher['Surname'].' '.$Teacher['Name'].'</strong> добавлен в группу '.$Teacher['AG_Code'].' на '.$Teacher['NumCourse'].' курс.'.'<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';


            }
            break;
        }
        case 'addTeacher':
        {
            if($_GET['status'] == 'error')
                echo '<div class="alert fade show alert-dismissible alert-danger" role="alert"><h5>Ошибка!</h5>
Не удалось добавить преподавателя!
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';
            else{
                $db = db_connect();
                $SelectTeacher = 'Select CONCAT(TP_Surname, " ", TP_Name, " ", TP_MiddleName) as Name from teacherprofile where TP_UserID= :id';
                $stmp = $db->prepare($SelectTeacher);

                $stmp->execute(array(':id'=>$_GET['id']));

                $Teacher = $stmp->fetch();

                echo '<div class="alert fade alert-dismissible show alert-success" role="alert"><h5>Успешно!</h5>
Преподаватель <strong>'.$Teacher['Name'].'</strong> добавлен в систему!'.'<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';


            }
            break;
        }
        case 'delete':
        {

            if($_GET['status'] == 'ok')
            {

              echo  '<div class="alert fade show alert-dismissible alert-info" role="alert"><h5>Успех</h5>
Операция удаления пользователя выполнена успешно.
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';
            }else{
               echo '<div class="alert fade show alert-dismissible alert-danger" role="alert"><h5>Ошибка!</h5>
Не удалось удалось удалить пользователя!
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';
            }
break;
        }
        case 'edit':
        {
            if($_GET['status'] == 'ok')
            {

                echo  '<div class="alert fade show alert-dismissible alert-info" role="alert"><h5>Успех</h5>
Информация успешно обновлена.
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';
            }else {
                echo '<div class="alert fade show alert-dismissible alert-danger" role="alert"><h5>Ошибка!</h5>
Ошибка при обновлении записи!
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';

            }
        }

            break;
        }
}

?>




<div class="card">
    <div class="card-header">
        <h5 class="text-center">Пользователи</h5>
        <div type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#ModalAddUser">
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-plus mr-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M8 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10zM13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
            </svg>Добавить cтудента
        </div>
        <div type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#ModalAddTeacher">
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-plus mr-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M8 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10zM13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
            </svg>
            Добавить преподавателя
        </div>
        <!-- Modal подключаем модальные окна -->
	    <?php require_once("UsersModalDialog.php") ?>
    </div>




        <ul class="nav nav-tabs mt-3 ml-2 mr-3" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link text-dark active" id="student-tab" data-toggle="tab" href="#student" role="tab" aria-controls="student" aria-selected="true">Студенты</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" id="teacher-tab" data-toggle="tab" href="#teacher" role="tab" aria-controls="teacher" aria-selected="false">Преподаватели</a>
            </li>

        </ul>
        <div class="tab-content ml-3 mr-3 mt-3" id="myTabContent">
            <div class="tab-pane fade active show" id="student" role="tabpanel" aria-labelledby="student-tab">

	            <?php
                $db = db_connect();
                $query = "select User_id, u.User_email As email,
       SP_Surname As SurName,
       SP_Name As Name,
       SP_MiddleName As MiddleName,
       SP_Gender As Gender,
       SP_DataOfBirth As DOB,
       SP_TypeOfStudy As TOS,
       SP_NumberOfBook As NOB,
       SP_AcademGroup_id As AG_Code
from studentprofile join users u on studentprofile.SP_id = u.User_id";
                $Users = $db->query($query);
                ?>
<div class="table-responsive">

                <table id="TableStudentList" class="table table-hover table-bordered" >
                    <thead class="text-center thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Фамилия</th>
                        <th>Имя</th>
                        <th>Отчество</th>
                        <th>Пол</th>
                        <th>Дата рождения</th>
                        <th>Тип обуч.</th>
                        <th title="Номер зачетной книжки">Номер зачётной книжки</th>
                        <th>Группа</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                foreach ($Users as $UsersRow)
                {

echo '<tr class="'. ($Teacher['SP_id'] == $UsersRow['User_id'] ?  'table-success">': ''. '">');

                   foreach ($UsersRow As $UsersCol) {
                       echo '<td>' . $UsersCol . '</td>';
                   }
                    echo '<td><div class="btn-group" role="group"><a title="Удалить пользователя" class="btn  btn-danger" href="DeleteUsers.php?id='.$UsersRow['User_id'].'">
<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
  <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
</svg></a>';
                    echo '<a title="Редактировать информацию о пользователе" class="btn btn-info" href="EditUsers.php?type=student&id='.$UsersRow['User_id'].'">
<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
</svg>
</a></div></td>';
echo '</tr>';
                }
                ?>

                    </tbody>
                    <!--<tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Фамилия</th>
                        <th>Имя</th>
                        <th>Отчество</th>
                        <th>Пол</th>
                        <th>Дата рождения</th>
                        <th>Тип обуч.</th>
                        <th title="Номер зачетной книжки">Номер З/К</th>
                        <th>Группа</th>
                        <th></th>

                    </tr>
                    </tfoot>-->
                </table>
</div>

            </div>

            <div class="tab-pane fade" id="teacher" role="tabpanel" aria-labelledby="teacher-tab-tab">
	            <?php



                ?>
                <div class="table-responsive">
                    <table id="TableTeacherList" class="table table-hover table-bordered"
                           cellspacing="0" width="100%">
                        <thead class="text-center thead-dark">
                        <tr>
                            <th style="top: 0; position: sticky">id</th>
                            <th style="top: 0; position: sticky">Email</th>
                            <th style="top: 0; position: sticky">Фамилия</th>
                            <th style="top: 0; position: sticky">Имя</th>
                            <th style="top: 0; position: sticky">Отчество</th>
                            <th style="top: 0; position: sticky">Пол</th>
                            <th style="top: 0; position: sticky">Дата рождения</th>
                            <th style="top: 0; position: sticky">Должность</th>
                            <th style="top: 0; position: sticky">Кафедра</th>
                            <th style="top: 0; position: sticky">Факультет</th>
                            <th style="top: 0; position: sticky"></th>
                        </tr>
                        </thead>
                        <tbody id="TableTeacherBody">
                        <?php
                        ?>


                        </tbody>
                    </table
                </div>>
            </div>


        </div>



    </div>

<div class="modal bg-dark" id="modalUserInfo" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white">Предупреждение!</h5>
            </div>
            <div class="modal-body" id="ModalUserInfoBody">

            </div>
            <div class="modal-footer bg-danger justify-content-between">

               <p class="text-white"> <strong>Внимание:</strong> данная операция необратима!</p>

                <div>
                <button type="button" id="btnDelete" disabled class="btn btn-light">Да, удалить</button>
                <button type="button" id="modalClose" class="btn btn-light" onclick="$('#modalUserInfo').fadeOut()" data-dismiss="modal">Отмена</button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade bg-dark" id="modalEditTeacher" role="dialog" data-toggle="modal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white">Редактирование информации</h5>
            </div>
            <div class="modal-body" id="ModalEditTeacherBody">

            </div>
            <div class="modal-footer bg-light justify-content-end">



                <div>
                    <button type="button" id="btnEditTeacher" disabled class="btn btn-info">Сохранить</button>
                    <button type="button" id="" class="btn btn-secondary" onclick="$('#modalEditTeacher').fadeOut()" data-dismiss="modal">Отмена</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function getUserInfo(id)
    {
       // alert(id);
        $("#ModalUserInfoBody").html("<div class='text-center'><img width='313' src='/img/loaderData.gif' alt='Загрузка'/><p class='text-info h4'>Получение информации...</p></div>");

        $.ajax({
            method: 'POST',
            url: "GetUserInfo.php",
            cache: false,
            data: {type: 'teacher', id: id},
            success: function(TeacherInfo){
                //  alert("OK");
                TeacherInfo = JSON.parse(TeacherInfo);

                $("#ModalUserInfoBody").html('<p class="text-dark">Вы уверены, что хотите удалить этого пользователя?</p>'                    )
               for(let hID in TeacherInfo)
               {
                   if(TeacherInfo[hID] !== null)
                    $("#ModalUserInfoBody").append('<tr><th><b style="margin: 10px;">'+hID+':</b></th><td><p>'+TeacherInfo[hID]+'</p></td></tr>')
               }


               $("#btnDelete").val(id)
                .prop('disabled', false);
            },
            fail: function (){alert("Беда!");},
            error: function (xhr, textStatus, error)
            {
                $("#ModalUserInfoBody").html(textStatus+': '+error);
            }
        });


        $("#modalUserInfo").fadeIn();


    }





    $("#btnDelete").click(function ()
    {
        let deleteUserID = $('#btnDelete').val();

        $.ajax({
            method: 'POST',
            url: 'deleteTeacher.php',
            data: {id: deleteUserID},
            dataType: 'JSON',
            success: function (resultOperation)
            {
                resultOperation = JSON.parse(resultOperation);
                console.log(resultOperation);
                if(resultOperation == true) {
                    $('#messageInfo').addClass("alert-info");
                    $('#messageInfo').fadeIn();
                    $('#messageInfoTitle').html("Успех");
                    $('#messageInfoText').html('Операция выполнена успешно!');
                    tableTeacherList.ajax.reload(); //Обновляем табицу после удаления
                }
                else {
                    $('#messageInfo').addClass("alert-danger");
                    $('#messageInfo').fadeIn();
                    $('#messageInfoTitle').html('Ошибка');
                    $('#messageInfoText').html('Операция не выполнена!');
                    $('#TableTeacherList').find()
                }
                $('#modalUserInfo').fadeOut();
            },
            error: function (xhr, errorText, error) {
                $('#messageInfo').addClass("alert-danger");
                $('#messageInfo').fadeIn();
                $('#messageInfoTitle').html('Ошибка');
                $('#messageInfoText').html('Операция не выполнена!');

            }
        });
    })


    function showEditForm(id)
    {
        $('#btnEditTeacher').prop('disabled', true);
        $.ajax({
            method: 'POST',
            data: {id: id},
            url: "editTeacher.php",
            dataType: 'html',

            success: function (OutData){
                $('#ModalEditTeacherBody').html(OutData);
            },

           error: function (xhr, errorText, error)
           {
               $('#modalEditTeacher').html(errorText+error);
           }

        });


        $("#modalEditTeacher").modal({
            keyboard: false
        })
    }


    $("#btnEditTeacher").click(function (){

        $.ajax({
            method: 'POST',
            url: 'editTeacherSave.php',
            cache: false,
            data: $('#formEditTeacher').serialize(),

            success: function (Return){


                $('#messageInfo').fadeIn();
                $("#messageInfoText").html(Return);
                tableTeacherList.ajax.reload();
            }
        })
        $("#modalEditTeacher").modal('hide');

    });




</script>

<script>
  
</script>