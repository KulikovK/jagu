<?php
defined('ADMIN') or Header("Location: /");
?>

<div class="modal fade bg-dark" id="ModalAddUser" tabindex="-1" role="dialog" aria-labelledby="ModalAddUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h5 class="modal-title text-center" id="ModalAddUserLabel">Добавление студента</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Отмена">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="AddStudentForm" class="col-12" action="AddUser_function.php?student" method="post">
                    <label>
                        <input name="Surname" id="StudentSurname" class="form-control" onchange="BrieflyName.value= this.value+ ' ' + Name.value.charAt(0) +'. '+MiddleName.value.charAt(0)+'.'" type="text" placeholder="Фамилия*" required>
                    </label>
                    <label>
                        <input name="Name" id="StudentName" class="form-control" onchange="BrieflyName.value=Surname.value+ ' ' + this.value.charAt(0) +'. '+MiddleName.value.charAt(0)+'.'" type="text" placeholder="Имя*" required>
                    </label>
                    <label>
                        <input name="MiddleName" id="StudentMiddleName" class="form-control"  onchange="BrieflyName.value=Surname.value+ ' ' + Name.value.charAt(0) +'. '+this.value.charAt(0)+'.'" type="text" placeholder="Отчество">
                    </label>
                    <label>
                        <input name="BrieflyName" id="StudentBriefly" class="form-control" type="text" placeholder="Инициалы">
                    </label>

                    <div class="form-group">
                        <label class="form-text">Пол*:</label>
                         <div class="custom-control custom-radio custom-control-inline">
                             <input type="radio" id="Gender1" name="Gender" value="М" class="custom-control-input" required>
                             <label class="custom-control-label" for="Gender1">Мужской</label>
                         </div>
                         <div class="custom-control custom-radio custom-control-inline">
                             <input type="radio" id="Gender2" name="Gender" value="Ж" class="custom-control-input" required>
                             <label class="custom-control-label" for="Gender2">Женский</label>
                         </div>
                    </div>

                    <div class="form-group">
                        <label class="form-text">Дата рождения*:</label>
                        <label>
                            <input name="DateOfBirth" class="form-control" type="Date" required>
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="form-text">Тип обучения*:</label>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="TypeOfStudy1" name="TypeOfStudy" value="Б" class="custom-control-input" required>
                            <label class="custom-control-label" for="TypeOfStudy1">Бюджет</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="TypeOfStudy2" name="TypeOfStudy" value="К" class="custom-control-input" required>
                            <label class="custom-control-label" for="TypeOfStudy2">Коммерция</label>
                        </div>
                    </div>

                    <label>
                        <input name="NumberBook" class="form-control" type="text" placeholder="Номер зачет. книжки*" required>
                    </label>

                    <div class="form-group">
                        <label class="form-text">Выберите академическую группу для студента:</label>
                        <label>
                            <select name="AG_Code" class="custom-select mb-3" required>
                                <option selected disabled></option>

                                <?
                                  $db = db_connect();
                                  $query = "Select AG_Code, AG_NumCuorse, s.SL_Abbreviation, s.SL_Name, f.FOS_Name from academicgroups join specialtylist s on academicgroups.AG_specialty = s.SL_id join formatofstudy f on academicgroups.AG_FormOfStudy = f.FOS_id";
                                  $AG_LIST = $db->query($query);

                                  foreach ($AG_LIST As $AG)
                                      echo '<option value="'.$AG['AG_Code'].'" title="'.$AG['SL_Name'].'">'.$AG['AG_Code'].' ('.$AG['SL_Abbreviation'].', '.$AG['AG_NumCuorse'].' курс, '.$AG['FOS_Name'].' форма обучения)'.'</option>';

                                  ?>

                            </select>
                        </label>
                    </div>
                    <label>
                        <input name="Email" class="form-control" type="email" placeholder="E-mail*" required>
                    </label>

                    <label>
                        <input name="Login" class="form-control" type="text" placeholder="Логин*" required>
                    </label>

                    <label>
                        <input name="Password" id="Password1" class="form-control" type="password" placeholder="Пароль*" required>
                    </label>
                    <label>
                        <input name="Password2" id="Password2" class="form-control" onkeyup="checkPass()" type="password" placeholder="Пароль*" required>
                    </label>
                    <label id="warning">
                        <span id="confirmMessage" class="confirmMessage"></span>
                    </label>

                    <hr>
                    <label class="form-text">
                        <p class="text-danger">поля помеченные звездочкой (*) обязательны для заполнения</p>
                    </label>

<!--                    <iframe class="form-control" frameborder="no" seamless name="result"></iframe>
-->
                </form>


            </div>
            <div class="modal-footer">
                <input type="submit" id="btnAddUser" disabled form="AddStudentForm" value="Добавить" class="btn btn-outline-success">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>

<div class="modal bg-dark fade" id="ModalAddTeacher" tabindex="-1" role="dialog" aria-labelledby="ModalAddTeacherLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h5 class="modal-title text-center" id="ModalAddTeacherLabel">Добавление преподавателя</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Отмена">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

<form id="AddTeacher" class="col-12" action="AddUser_function.php?teacher" method="post">


        <label>
            <input name="Surname" class="form-control" onchange="BrieflyName.value=this.value + ' ' + Name.value.charAt(0)+'. ' + MiddleName.value.charAt(0)+'.'" type="text" placeholder="Фамилия*" required>
        </label>



        <label>
            <input name="Name" class="form-control" onchange="BrieflyName.value=Surname.value + ' ' + this.value.charAt(0)+'. ' + MiddleName.value.charAt(0)+'.'" type="text" placeholder="Имя*" required>
        </label>



        <label>
            <input name="MiddleName" class="form-control" onchange="BrieflyName.value=Surname.value + ' ' + Name.value.charAt(0)+'. ' + this.value.charAt(0)+'.'" type="text" placeholder="Отчество">
        </label>



        <label>
            <input name="BrieflyName" class="form-control" type="text" placeholder="Инициалы">
        </label>


    <div class="form-group row-cols-1">
        <label class="form-text">Дата рождения*:</label>
        <label>
            <input name="DateOfBirth" class="form-control" type="date" required>
        </label>
    </div>

    <div class="form-group">
        <label class="form-text">Пол*:</label>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="GenderTeacher1" name="GenderTeacher" value="М" class="custom-control-input" required>
            <label class="custom-control-label" for="GenderTeacher1">Мужской</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="GenderTeacher2" name="GenderTeacher" value="Ж" class="custom-control-input" required>
            <label class="custom-control-label" for="GenderTeacher2">Женский</label>
        </div>
    </div>

    <div class="form-group row">
        <label for="AcademicDegree" class="col-sm-4 col-form-label control-label">Ученая степень</label>
        <label class="col-sm-8">
            <select name="AcademicDegree" id="AcademicDegree" class="custom-select">
                <option value=""></option>
                <?
                $queryAcademicTitle = 'Select AD_id as ID, AD_name as Name from academicdegree';
                $DegreeList =   $db->query($queryAcademicTitle);

                foreach ($DegreeList as $DL)
                    echo '<option value="'.$DL['ID'].'">'.$DL['Name'].'</option>'

                ?>
            </select>
        </label>
    </div>

    <div class="form-group row">
        <label for="AcademicTitle" class="col-sm-4 col-form-label control-label">Ученое звание(должность):</label>
        <label class="col-sm-8">
            <select name="AcademicTitle" id="AcademicTitle" class="custom-select">
                <option value=""></option>
                <?
                $queryAcademicTitle = 'Select AT_id as ID, AT_name as Name from academictitle';
                $AcademicTitleList =   $db->query($queryAcademicTitle);

                foreach ($AcademicTitleList as $ATL)
                    echo '<option value="'.$ATL['ID'].'">'.$ATL['Name'].'</option>'

                ?>
            </select>
        </label>
    </div>

    <div class="form-group row">
        <label for="Faculty" class="control-label col-form-label col-sm-4">Факультет:</label>
        <label class="col-sm-8">
            <select name="Faculty" id="Faculty" class="custom-select">
                <option value=""></option>
                <?
                $query = 'Select FCT_id as ID, FCT_name as Name from faculties';
                $DEPList=   $db->query($query);

                foreach ($DEPList as $DL)
                    echo '<option value="'.$DL['ID'].'">'.$DL['Name'].'</option>'
                ?>
            </select>
        </label>
    </div>

    <div class="form-group row">
        <label for="Departaments" class="control-label col-form-label col-sm-4">Кафедра:</label>
        <label class="col-sm-8">
        <select name="Departaments" id="Departaments"  disabled class="custom-select">
            <option value=""></option>

        </select>
        </label>
    </div>


    <label>
        <input name="Email" class="form-control" type="email" required placeholder="Email*">
    </label>
    <label>
        <input name="Login" class="form-control" type="text" required placeholder="Логин*">
    </label>
    <label>
        <input name="Password" id="Password3" class="form-control" type="password" required placeholder="Пароль*">
    </label>
    <label>
        <input id="Password4" class="form-control" onkeyup="checkPass2()" type="password" required placeholder="Повторите пароль*">
    </label>
       <label id="warning">
           <span id="confirmMessage1" class="confirmMessage warning"></span>
       </label>


    <div class="form-group">
        <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" id="isAdmin" name="SetAdmin" value="2" class="custom-control-input">
            <label class="custom-control-label" for="isAdmin">Назначить администратором</label>
        </div>

    </div>


    <hr>
    <label class="form-text">
        <p class="text-danger">поля помеченные звездочкой (*) обязательны для заполнения</p>
    </label>


</form>

            </div>
            <div class="modal-footer">
                <input type="submit" id="btnAddUserTeacher" disabled form="AddTeacher" value="Добавить"  class="btn btn-outline-success">
                <button type="button"  class="btn btn-outline-danger" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>

<script>
    function checkPass() {


        const password = document.getElementById('Password1'),
            password2 = document.getElementById('Password2'),
            message = document.getElementById('confirmMessage'),
            button = document.getElementById('btnAddUser');
        const colors = {
            "goodColor": "#fff",
            "goodColored": "#087a08",
            "badColor": "#fff",
            "badColored": "#ed0b0b"
        };
        const strings = {
            "confirmMessage": ["<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-check-all\" viewBox=\"0 0 16 16\">\n" +
            "  <path fill-rule=\"evenodd\" d=\"M8.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L2.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093L8.95 4.992a.252.252 0 0 1 .02-.022zm-.92 5.14l.92.92a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 1 0-1.091-1.028L9.477 9.417l-.485-.486-.943 1.179z\"/>\n" +
            "</svg>",
                "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-exclamation-circle\" viewBox=\"0 0 16 16\">\n" +
                "  <path fill-rule=\"evenodd\" d=\"M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z\"/>\n" +
                "  <path d=\"M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z\"/>\n" +
                "</svg> Пароли не совпадают!"]
        };

        if(password.value === password2.value && (password.value + password2.value) !== "") {
            password2.style.backgroundColor = colors["goodColor"];
            message.style.color = colors["goodColored"];
            message.innerHTML = strings["confirmMessage"][0];
            button.disabled = false;
        }
        else if(!(password2.value === "")) {
            password2.style.backgroundColor = colors["badColor"];
            message.style.color = colors["badColored"];
            message.innerHTML = strings["confirmMessage"][1];
            button.disabled = true
        }
        else {
            message.innerHTML = "Повторите пароль";
        }

    }

    function checkPass2() {


        const password = document.getElementById('Password3'),
            password2 = document.getElementById('Password4'),
            message = document.getElementById('confirmMessage1'),
            button = document.getElementById('btnAddUserTeacher');
        const colors = {
            "goodColor": "#fff",
            "goodColored": "#087a08",
            "badColor": "#fff",
            "badColored": "#ed0b0b"
        };
        const strings = {
            "confirmMessage": ["<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-check-all\" viewBox=\"0 0 16 16\">\n" +
            "  <path fill-rule=\"evenodd\" d=\"M8.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L2.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093L8.95 4.992a.252.252 0 0 1 .02-.022zm-.92 5.14l.92.92a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 1 0-1.091-1.028L9.477 9.417l-.485-.486-.943 1.179z\"/>\n" +
            "</svg>",
                "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-exclamation-circle\" viewBox=\"0 0 16 16\">\n" +
                "  <path fill-rule=\"evenodd\" d=\"M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z\"/>\n" +
                "  <path d=\"M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z\"/>\n" +
                "</svg> Пароли не совпадают!"]
        };

        if(password.value === password2.value && (password.value + password2.value) !== "") {
            password2.style.backgroundColor = colors["goodColor"];
            message.style.color = colors["goodColored"];
            message.innerHTML = strings["confirmMessage"][0];
            button.disabled = false;
        }
        else if(!(password2.value === "")) {
            password2.style.backgroundColor = colors["badColor"];
            message.style.color = colors["badColored"];
            message.innerHTML = strings["confirmMessage"][1];
            button.disabled = true
        }
        else {
            message.innerHTML = "Повторите пароль";
        }

    }


    function insertInitials( inputID, outputID)
    {
        var input = this.document.getElementById(inputID);
        var output = this.document.getElementById(outputID);
       // alert(input.value);

        if(input.value==='')
            output.value='';

        if (output.value === '')
        output.value = input.value;
        else
            output.value+= " " + input.value.charAt(0) +".";

    }

</script>

<script>
    let Faculty = $("#Faculty");

    Faculty.on('change', function (ev){
        //alert(Faculty.val());
        let facultyID = Faculty.val();
        $("#Departaments").prop('disabled', true);
        $.ajax({
            method: 'GET',
            url: "departaments.php",
            data: {id: facultyID},
            dataType: 'json',
            cache: false,
            success: function (DepartamentsList){

                $("#Departaments")
                    .prop("disabled", false)
                    .html($("<option></option>"));
               // console.log(DepartamentsList);
                for(let id in DepartamentsList){
                    // alert(DepartamentsList[id]['ID']+'\n'+DepartamentsList[id]['Name']);
                     $("#Departaments").append("<option value='"+DepartamentsList[id]['ID']+"'>"+DepartamentsList[id]['Name']+"</option>")
                }
            }
        })

    });
</script>