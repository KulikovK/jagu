<?php
defined('ADMIN') or Header("Location: /");
?>

<!--TODO: добавить динамическую подгрузку специальностей, в зависимости от факультета-->


<div class="card">
    <div class="card-header">
        <p class="h5 text-center">Академические группы</p>
        <p class="lead text-center">На этой страницы вы может осуществять управление академическими группами вашего
            ВУЗа.</p>
        <div>
            <button class="btn btn-outline-info" id="btnAddAcademicGroups">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                     class="bi bi-plus-square" viewBox="0 0 16 16">
                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>
                Создать группу
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="AcademicGroupsTable" class="table table-hover table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th>Код</th>
                    <th>Факультет</th>
                    <th>Направление/Профиль</th>
                    <th>Год начала</th>
                    <th>Год окончания</th>
                    <th>Форма обучения</th>
                    <th>Текущий курс</th>
                    <th>Куратор</th>
                    <th>Староста</th>
                    <th>Кол-во студентов</th>
                </tr>
                </thead>
                <tbody>

                </tbody>

                <tfoot>
                <tr>
                    <th>Код</th>
                    <th>Факультет</th>
                    <th>Направление/Профиль</th>
                    <th>Год начала</th>
                    <th>Год окончания</th>
                    <th>Форма обучения</th>
                    <th>Текущий курс</th>
                    <th>Куратор</th>
                    <th>Староста</th>
                    <th>Кол-во студентов</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalCreateAG" data-backdrop="static" data-toggle="modal" role="dialog" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <p class="h5 modal-title">Создание академической группы</p>
            </div>
            <div class="modal-body">
                <form id="FromCreateAG">

                    <div class="form-group row">
                        <label class="control-label col-form-label col-sm-4">Код группы:</label>

                        <div class="col-sm-8">
                            <input class="form-control" type="text" required name="AGCode">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-form-label  col-sm-4">Факультет:</label>
                        <div class="col-sm-8">
                           <select name="" required class="selectpicker form-control" data-live-search="true" id="ListFaculty">

                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-form-label col-sm-4">Направление/Профиль:</label>
                        <div class="col-sm-8">
                            <select name="Specialty" style="width: 100%;" required class="selectpicker form-control" data-live-search="true" id="ListSpecialty">

                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-form-label col-sm-4">Срок обучения:</label>
                        <div class="col-sm-6 form-check-inline">
                            <div class="col-sm-8">
                                <input class="form-control" placeholder="Год начала" name="DateStart" type="number"
                                       list="ListYS" required>
                                <datalist id="ListYS">
                                    <?
                                    for ($i = date('Y') - 5; $i <= date('Y'); $i++)
                                        echo '<option>' . $i . '</option>';
                                    ?>
                                </datalist>
                            </div>
                            <label class="h4 control-label col-form-label">-</label>
                            <div class="col-sm-8">

                                <input class="form-control" name="DateEnd" placeholder="Год окончания" type="number"
                                       list="ListYE" required>
                                <datalist id="ListYE">
                                    <?
                                    for ($i = date('Y'); $i <= date('Y') + 5; $i++)
                                        echo '<option>' . $i . '</option>';
                                    ?>
                                </datalist>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-form-label col-sm-4">Текущий курс:</label>

                        <div class="col-sm-8">
                            <input class="form-control" type="number" min="1" value="1" max="6" name="NumberCourse"
                                   required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-form-label col-sm-4">Куратор группы:</label>

                        <div class="col-sm-8">
                            <select class="custom-select" required name="Curator" id="TeacherList">
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-form-label col-sm-4">Форма обучения:</label>
                        <div class="col-sm-8">
                            <select class="custom-select" name="FormOfStudy" required id="ListFormOfStudy">
                            </select>
                        </div>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <div class="justify-content-end">
                    <button class="btn btn-success" id="btnCreateAG">Создать</button>
                    <button class="btn btn-secondary" data-toggle="modal" onclick="$('#ModalCreateAG').modal('hide')">
                        Отмана
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="AGConfiguration" data-backdrop="static" data-toggle="modal" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title text-center h5">Управление академической группой <strong id="AGC_AGCode"></strong>
                </p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">


                <div class="row">
                    <div class="col-2 p-2 card-header">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                             aria-orientation="vertical">
                            <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill"
                               href="#vp-agedit-general"
                               role="tab" aria-controls="v-pills-home" aria-selected="true">Конфигурация</a>
                            <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#vp-agedit-students"
                               role="tab" aria-controls="v-pills-profile" aria-selected="false">Студенты</a>
                            <a class="nav-link" id="v-pills-discipline" data-toggle="pill" href="#vp-agedit-discipline"
                               role="tab" aria-controls="v-pills-discipline" aria-selected="false">Дисциплины</a>
                            <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#vp-agedit-subgroups"
                               role="tab" aria-controls="v-pills-messages" aria-selected="false">Подгруппы</a>
                            <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#vp-agedit-delete"
                               role="tab" aria-controls="v-pills-settings" aria-selected="false">Удалить группу</a>
                        </div>
                    </div>
                    <div class="col-10">
                        <div class="tab-content" id="v-pills-tabContent">
                            <!--GeneralSetting-->
                            <div class="tab-pane fade show active" id="vp-agedit-general" role="tabpanel"
                                 aria-labelledby="v-pills-home-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title text-center h5">Общии настроки группы</div>
                                    </div>

                                    <div class="card-body">
                                        <!--Form Edit AG-->
                                        <form id="EditAG">
                                            <div class=" form-group row">
                                                <label class="control-label col-form-label col-sm-4">Код группы:</label>
                                                <div class="col-sm-8">

                                                    <input name="AGCode" id="AGEditAGCode" class="form-control"
                                                           type="text"
                                                           required>

                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="control-label col-form-label col-sm-4">Факультет:</label>
                                                <div class="col-sm-8">
                                                    <select id="FacultyList"
                                                            class="custom-select"></select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="control-label col-form-label col-sm-4">Направление/Профиль:</label>
                                                <div class="col-sm-8">
                                                    <select name="Specialty" id="SpecialtyList"
                                                            class="custom-select"></select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="control-label col-form-label col-sm-4">Срок
                                                    обучения:</label>
                                                <div class="col-sm-6 form-check-inline">
                                                    <div class="col-sm-8">
                                                        <input class="form-control" placeholder="Год начала"
                                                               id="YearStart" name="YearStart" type="number"
                                                               list="ListYS" required>
                                                        <datalist id="ListYS">
                                                            <?
                                                            for ($i = date('Y') - 5; $i <= date('Y'); $i++)
                                                                echo '<option>' . $i . '</option>';
                                                            ?>
                                                        </datalist>
                                                    </div>
                                                    <label class="h4 control-label col-form-label">-</label>
                                                    <div class="col-sm-8">

                                                        <input class="form-control" name="YearEnd" id="YearEnd"
                                                               placeholder="Год окончания" type="number" list="ListYE"
                                                               required>
                                                        <datalist id="ListYE">
                                                            <?
                                                            for ($i = date('Y'); $i <= date('Y') + 5; $i++)
                                                                echo '<option>' . $i . '</option>';
                                                            ?>
                                                        </datalist>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="control-label col-form-label col-sm-4">Текущий
                                                    курс:</label>

                                                <div class="col-sm-8">
                                                    <input class="form-control" id="NumberCourse" type="number" min="1"
                                                           value="1" max="6" name="NumberCourse" required>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="control-label col-form-label col-sm-4">Куратор
                                                    группы:</label>

                                                <div class="col-sm-8">
                                                    <select class="custom-select" required name="Curator"
                                                            id="AGEditTeacherList">
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="control-label col-form-label col-sm-4">Староста
                                                    группы:</label>

                                                <div class="col-sm-8">
                                                    <select class="custom-select" required name="Headman"
                                                            id="AGEditHeadmanList">
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="control-label col-form-label col-sm-4">Форма
                                                    обучения:</label>
                                                <div class="col-sm-8">
                                                    <select class="custom-select" name="FormOfStudy" required
                                                            id="AGEditListFormOfStudy">
                                                    </select>
                                                </div>
                                            </div>

                                            <input name="AGCodeOld" id="EditAGCodeOld" value="" hidden>
                                        </form>
                                    </div>

                                    <div class="card-footer d-flex justify-content-sm-between">
                                        <div>
                                            <button class="btn btn-info" id="btnSaveAG" disabled>Сохранить</button>
                                        </div>
                                        <div class="info" id="infoUpdateAG"><p class="h5"></p></div>

                                    </div>
                                </div>
                            </div>
                            <!--Students-->
                            <div class="tab-pane fade" id="vp-agedit-students" role="tabpanel"
                                 aria-labelledby="v-pills-profile-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title text-center h5">Список студентов группы</div>
                                        <!--                                        <button id="btnAddStudent" class="btn btn-info">Добавить студента</button>-->

                                    </div>
                                    <div id="prompt_select_student" class="text-center alert alert-info">
                                        <p>Выберите студента для получение подройбной информаии или редактирования.</p>

                                    </div>
                                    <div class="card-body d-flex">


                                        <div id="StudentsListBoby" class="list-group border border-primary"
                                             role="tablist">


                                        </div>


                                        <div class="col-sm-8 bg-white">

                                            <div id="EditStudentBlock"
                                                 class="border border-primary bg-white border-right">
                                                <div id="spinner_load_student_info" class="text-center alert alert-info"
                                                     hidden>
                                                    <!--                                                    <img width='25px' src='/img/loaderData.gif' alt='Загрузка'/>-->
                                                    <span class='spinner-border text-center' role='status'></span>
                                                    <p>Получение информации...</p>
                                                </div>
                                                <div id="prompt_msgErrorToLoadStudentInfo" class="alert alert-danger"
                                                     hidden>
                                                    <p>Не удалось получить информацию. Обновите
                                                        страницу или попробуйте чуть позже.</p>
                                                </div>
                                                <form id="FormEditStudents" class="form-horizontal m-2">

                                                    <div class="form-group row">
                                                        <label class="col-form-label col-sm-4">Фамилия</label>

                                                        <label class="col-sm-8">
                                                            <input name="Surname" type="text" required
                                                                   class="form-control" id="FormEditStudentSurname">
                                                        </label>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-form-label col-sm-4">Имя</label>

                                                        <label class="col-sm-8">
                                                            <input name="Name" type="text" required class="form-control"
                                                                   id="FormEditStudentName">
                                                        </label>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-form-label col-sm-4">Отчество</label>

                                                        <label class="col-sm-8">
                                                            <input name="MiddleName" type="text" required
                                                                   class="form-control" id="FormEditStudentMiddleName">
                                                        </label>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-form-label col-sm-4">Инициалы</label>

                                                        <label class="col-sm-8">
                                                            <input name="BrieflyName" type="text" required
                                                                   class="form-control" id="FormEditStudentBrieflyName">
                                                        </label>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="control-label col-form-label col-sm-4">Пол:</label>
                                                        <div class="col-sm-8">
                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                <label class="form-check-label">
                                                                    <input class="custom-control-input"
                                                                           id="FormEditStudentGenderMan" type="radio"
                                                                           name="Gender" required value="М"/>
                                                                    <label class="custom-control-label"
                                                                           for="FormEditStudentGenderMan">Мужской</label>
                                                                </label>
                                                            </div>

                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                <label class="form-check-label">
                                                                    <input class="custom-control-input"
                                                                           id="FormEditStudentGenderWoman" type="radio"
                                                                           name="Gender" required value="Ж"/>
                                                                    <label class="custom-control-label"
                                                                           for="FormEditStudentGenderWoman">Женский</label>
                                                                </label>

                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-form-label col-sm-4">Дата рождения</label>

                                                        <label class="col-sm-8">
                                                            <input name="DateOfBirth" type="date" required
                                                                   class="form-control" id="FormEditStudentDateOfBirth">
                                                        </label>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="control-label col-form-label col-sm-4">Тип
                                                            обучения:</label>
                                                        <div class="col-sm-8">
                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                <label class="form-check-label">
                                                                    <input class="custom-control-input"
                                                                           id="FormEditStudentTypeOfStudyB" type="radio"
                                                                           name="TypeOfStudy" required value="Б"/>
                                                                    <label class="custom-control-label"
                                                                           for="FormEditStudentTypeOfStudyB">Бюджет</label>
                                                                </label>
                                                            </div>

                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                <label class="form-check-label">
                                                                    <input class="custom-control-input"
                                                                           id="FormEditStudentTypeOfStudyK" type="radio"
                                                                           name="TypeOfStudy" required value="К"/>
                                                                    <label class="custom-control-label"
                                                                           for="FormEditStudentTypeOfStudyK">Коммерция</label>
                                                                </label>

                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-form-label col-sm-4">Номер зачетной
                                                            книжки</label>

                                                        <label class="col-sm-8">
                                                            <input name="NumberBook" type="text" required
                                                                   class="form-control" id="FormEditStudentNumberBook">
                                                        </label>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-form-label col-sm-4">Академ. Группа</label>

                                                        <label class="col-sm-8">
                                                            <select name="AGCode" class="custom-select"
                                                                    id="FormEditStudentListAG"></select>
                                                        </label>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-form-label col-sm-4">Email</label>

                                                        <label class="col-sm-8">
                                                            <input name="Email" type="email" required
                                                                   class="form-control" id="FormEditStudentEmail">
                                                        </label>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-form-label col-sm-4">Логин</label>

                                                        <label class="col-sm-8">
                                                            <input name="Login" type="text" required
                                                                   class="form-control" id="FormEditStudentLogin">
                                                        </label>
                                                    </div>


                                                </form>


                                                <div id="divBtnForAddStudent"
                                                     class="m-2 center-block d-flex justify-content-end"
                                                     style="display: none">
                                                    <button id="btnUpdateInfoOfStudent" class="btn btn-success mr-sm-2"
                                                            disabled>
                                                        Сохранить
                                                    </button>
                                                    <button id="AddStudentCancel" class="btn btn-secondary mr-sm-2">
                                                        Отмена
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="card-footer">

                                    </div>
                                </div>
                            </div>
                            <!--Discipline Setting for Academic groups-->
                            <div class="tab-pane fade" id="vp-agedit-discipline" role="tabpanel"
                                 aria-labelledby="v-pills-discipline">
                                <div class="card">
                                    <div class="card-header">
                                        <p class="text-center card-text h5">Учебная нагрузка группы</p>
                                        <p>Здесь Вы можете назначить списко дисциплин для академической группы.</p>
                                        <button id="btnShowFormAddDisciplineForAG" class="btn btn-outline-primary">Добавить нагрузку</button>
                                    </div>

                                    <div class="card-body">
                                        <div id="prompt-infoStudyLoad" class="">

                                        </div>
                                        <div id="divBlockFormAddDisciplineForAG" style="border-radius: 1%" class="border bg-light p-2 border-info" hidden>
                                            <form id="formAddDisciplineForAG"  class="">
                                                <input id="EditAG-Discipline-AGCode" name="AGCode" hidden value=""/>
                                                <div class="form-group row">
                                                    <label class="col-form-label control-label  col-sm-4 " for="ListFaculty">Факультет</label>
                                                    <div class="col-sm-8"><select id="EditAG-Discipline_ListFaculty" style="width: 33%;"
                                                               name="ListFaculty_id"></select></div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="control-label col-form-label col-sm-4" for="ListTeacher">Ведущий преподаватель</label>
                                                    <div class="col-sm-8">
                                                        <select class="custom-select" id="EditAG-Discipline_ListTeacher"
                                                               name="Teacher_id"></select>
                                                    </div>
                                                </div>

                                                <div class="form-group row"><label class="col-form-label control-label col-sm-4"
                                                          for="ListDiscipline">Дисциплина*</label>
                                                    <div class="col-sm-8">
                                                        <select class="custom-select"
                                                               id="EditAG-Discipline_ListDiscipline"
                                                               name="Discipline_id" required></select>
                                                    </div>
                                                </div>


                                                <div class="form-group row"><label class="col-form-label control-label col-sm-4 " for="TypeLesson">Тип
                                                        занатий*</label>
                                                    <div class="col-sm-8"><select class="custom-select"
                                                               id="EditAG-Discipline_TypeLesson"
                                                               name="TypeLesson_id" required></select>
                                                    </div>
                                                </div>

                                                <div class="form-group row"><label class="col-form-label control-label col-sm-4" for="NumberHours">Количество
                                                        часов*</label>
                                                    <div class="col-sm-8"><input id="EditAG-Discipline-NumberHours" name="NumberHours" type="number" min="1" max="150"
                                                              required/></div></div>

                                                <div class="form-group row">
                                                    <label class="col-form-label control-label col-sm-4">Перподаватель данного вида занятий*:</label>
                                                    <div class="col-sm-8">
                                                        <select class="custom-select" id="TeacherForThisTypeLesson" required name="EditAG-Discipline_ThisTeacher_id"></select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox custom-control-inline">
                                                        <input type="checkbox" id="AdditionalLoad" name="AdditionalLoad" value="1" class="custom-control-input">
                                                        <label class="custom-control-label" for="AdditionalLoad">Считать данную нагрузку дополнительной для выбранного преподавателя.</label>
                                                    </div>
                                                </div>


                                            </form>
                                            <button class="btn btn-outline-success mr-sm-2" form="formAddDisciplineForAG" id="AddDisciplineForAcademicGroups" disabled>Добавить</button>
                                            <button class="btn btn-outline-secondary mr-sm-2"  onclick="$('#divBlockFormAddDisciplineForAG').attr('hidden', true); $('#divBlockTablesStudyLoad').attr('hidden', false);">Отмена</button>
                                        </div>

                                        <div id="divBlockTablesStudyLoad" class="mt-2">
                                            <table id="TableStudyLoad" class="table table-bordered thead-dark">
                                                <thead>
                                                <tr>
                                                    <th>Дисциплина</th>
                                                    <th>Преподаватель</th>
                                                    <th>Тип занятий</th>
                                                    <th>Количество часов</th>
                                                    <th>Доп. нагрузка</th>
                                                    <th>id</th>
                                                </tr>
                                                </thead>

                                                <tbody>

                                                </tbody>

                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!--Subgroups-->
                            <div class="tab-pane fade" id="vp-agedit-subgroups" role="tabpanel"
                                 aria-labelledby="v-pills-messages-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <p class="text-center card-text h5">Подгруппы</p>
                                        <form id="formAddSubGroups" class="mr-sm-4 form-inline">
                                            <div class="form-group mr-sm-4" style="width: 50%">
                                            <select class="custom-select" name="StudyLoad_id" required id="StudyLoadList"></select>
                                            </div>
                                            <input class="form-control mr-sm-4" name="NumberSubGoups" style="width: auto" type="number" min="1" max="4" id="NumberSubgroups" required placeholder="Номер подгруппы"/>
                                        </form>
                                        <button class="btn btn-outline-primary" form="formAddSubGroups" id="btnCreateSubGroups">Создать подгруппу</button>

                                    </div>
                                    <div id="promptInfoSubgroups">

                                    </div>

                                    <div class="card-body">
                                         <div id="divBlockSubGroupsList">
                                             <table id="TableSubGroupsList" class="table table-bordered">
                                                 <thead>
                                                 <tr>
                                                     <th>Дисциплина</th>
                                                     <th>Преподаватель</th>
                                                     <th>Тип занятий</th>
                                                     <th>Номер подгруппы</th>
                                                     <th>Количество студентов</th>
                                                 </tr>
                                                 </thead>
                                             </table>
                                         </div>
                                    </div>
                                </div>


                            </div>

                            <!--AG Delete-->
                            <div class="tab-pane fade" id="vp-agedit-delete" role="tabpanel"
                                 aria-labelledby="v-pills-settings-tab">
                                <div class="card border border-danger text-white">
                                    <h5 class="card-header bg-danger">Внимание!</h5>
                                    <div class="card-body alert-danger">
                                        <p class="">Вы уверены, что хотите удалить эту группу?</p>
                                        <p><strong>Учтите, </strong>что вместе с группой будет удалена вся информация о
                                            студентах.</p>
                                        <hr>
                                        <p>Для подтверждения операции необходимо ввести код группы:</p>
                                        <div class="form-inline">
                                            <label for="confirmAGCode" class="mr-sm-2">Подтвердите код:</label>
                                            <input type="text" id="confirmAGCode"
                                                   class="form-control mr-sm-2 col-sm-4"/>
                                            <button id="btnDeleteAG" value="" disabled class="btn btn-danger">Удалить
                                            </button>
                                        </div>

                                    </div>
                                    <div class="card-footer bg-danger d-flex justify-content-between">
                                        <p><strong>Внимание:</strong> данная операция не обратима!</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <div class="justify-content-end">
                    <button class="btn btn-secondary" onclick="$('#AGConfiguration').modal('hide')">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    let AGTable = $("#AcademicGroupsTable").DataTable({
        processing: true,
        responsive: true,

        //  select: true,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.22/i18n/Russian.json"
        },
        stateSave: false,
        // dom: 'QB<"">lfrtip',
        dom: 'Ql<"clear">RSfrtBip',
        buttons: [
            {
                extend: 'collection',
                text: 'Экспорт',
                collectionLayout: 'fixed two-column',

                buttons: [
                    {
                        extend: 'excel',
                        text: 'Excel',
                        filename: 'Список академических групп',
                        title: 'Академические группы',
                        messageTop: 'Список академических групп',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'PDF',
                        orientation: 'landscape',
                        filename: 'Список академических групп',
                        title: 'Академические группы',
                        messageTop: 'Список академических групп',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        text: 'Печать',
                        title: 'Академические группы',
                        messageTop: 'Список академических групп',
                        exportOptions: {
                            columns: ':visible'
                        }
                    }
                ]
            },
            {
                extend: 'colvis',
                text: 'Столбцы',
                collectionLayout: 'fixed two-column'

            }

        ],


        ajax: {
            type: 'POST',
            url: "API/GetTableAcademicGroups.php",
            cache: false,
            dataSrc: function (json) {
                return json.data;
            }
        },


        column: [
            {data: '0'},
            {data: '1'},
            {data: '2'},
            {data: '3'},
            {data: '4'},
            {data: '5'},
            {data: '6'},
            {data: '7'},
            {data: '8'},
            {data: '9'}
        ],

        initComplete: function () {
            this.api().columns().every(function () {
                var column = this;
                var select = $('<select class="custom-select" style="width: 100%;"><option value=""></option></select>')
                    .appendTo($(column.footer()).empty())
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );

                        column
                            .search(val ? '^' + val + '$' : '', true, false)
                            .draw();
                    });

                column.data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>')
                });
            });
        }
    });

    let StudyLoad = $("#TableStudyLoad").DataTable({
        processing: true,
        responsive: true,

        //  select: true,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.22/i18n/Russian.json"
        },
        stateSave: true,



        ajax: {
            type: "post",
            url: "API/GetStudyLoad.php",
            data: {AGCode: function (){
                return $("#AGC_AGCode").text();
                }
                },

            serverSide: true,
            cache: false,

            dataSrc: function (json) {
                return json.data;
            }
        },
        select: true,

        column: [
            {data: 0},
            {data: 1},
            {data: 2},
            {data: 3},
            {data: 4},
            {data: 5}
        ]



    });

    let TableSubgroups = $("#TableSubGroupsList").DataTable({
        processing: true,
        responsive: true,

        //  select: true,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.22/i18n/Russian.json"
        },
        stateSave: true,

        ajax: {
            type: "post",
            url: "API/GetSubGroupsList.php",
            data: {AGCode: function (){
                    return $("#AGC_AGCode").text();
                }
            },

            serverSide: true,
            cache: false,

            dataSrc: function (json) {
                return json.data;
            }
        },
        select: true,

        column: [
            {data: 0},
            {data: 1},
            {data: 2},
            {data: 3},
            {data: 4}
        ],
    });

    StudyLoad.column(5).visible(false);

    $("#formAddSubGroups").on('submit', function (e){
        e.preventDefault();

        $.ajax({
            method: 'post',
            dataType: 'html',
            url: 'API/AddSubGroups.php',
            data: $("#formAddSubGroups").serialize(),

            success: function (html){
                $("#promptInfoSubgroups").html(html);
            },
            error: function (){
                $("#promptInfoSubgroups").html('<p class="alert alert-danger">Ошибка обработти запроса.</p>');
            }
        });
        $("#promptInfoSubgroups").show();
        TableSubgroups.ajax.reload();
    });

    $('#AcademicGroupsTable tbody').on('click', 'tr', function () {
        var data = AGTable.row(this).data();
        AGConfig(data[0]);
    });



    $("#v-pills-discipline").click(function (){
        console.log('Click ok!');
        StudyLoad.ajax.data = {"AGCode": $("#AGC_AGCode").text()};
        StudyLoad.ajax.reload();
        $("#divBlockTablesStudyLoad").attr('hidden', false);
        $("#divBlockFormAddDisciplineForAG").attr('hidden', true);
        $("#prompt-infoStudyLoad").html('');
        $("#formAddDisciplineForAG *").trigger('reset');
    });

    $("#v-pills-messages-tab").click(function (){
        $.ajax({
            method: 'post',
            url: "API/GetStudyLoad.php",
            data: {'type': 'list', 'AGCode': $("#AGC_AGCode").text()},
            cache: false,
            dataType: 'json',

            success: function (json){
                console.log('Study Load List');

                console.log(json);

                $("#StudyLoadList").html(new Option(""));
                for(let id in json)
                {
                  $("#StudyLoadList").append(new Option(json[id]['DisciplineName'] + ' / ' + json[id]['TypeLessonName'] + ' / '+json[id]['TeacherName'], json[id]['ID'], false, false));
                }
            }
        });

        $("#promptInfoSubgroups").hide();

        TableSubgroups.ajax.data = {"AGCode": $("#AGC_AGCode").text()};
        TableSubgroups.ajax.reload();
    })

    $(document).ready(function() {
        $('select').select2({
            width: "100%",
            theme: 'classic',
            placeholder: 'Выберите нужное значение',
            allowClear: true
        });


        $.ajax({
            method: "POST",
            url: "API/getFacultyNameList.php",
            dataType: 'json',
            cache: 'false',

            success: function (jsonListFaculty){
               $("#EditAG-Discipline_ListFaculty").append(new Option(""));

               for(let lfID in jsonListFaculty)
                   $("#EditAG-Discipline_ListFaculty").append(new Option(jsonListFaculty[lfID]["Name"], jsonListFaculty[lfID]['ID'], false, false));
            },

            error: function (){
                $("#EditAG-Discipline_ListFaculty").append(new Option("Ошибка рллучения данных", "-1", true, false))
                $("#EditAG-Discipline_ListFaculty").attr('disabled', true);
            }
        });

        $.ajax({
            method: "POST",
            url: "API/GetTeacherNameList.php",
            dataType: "json",
            cache: "false",

            success: function (jsonTeacherList){
                $("#EditAG-Discipline_ListTeacher").append(new Option(""));
                $("#TeacherForThisTypeLesson").append(new Option(""));

                for(let ltID in jsonTeacherList) {
                    $("#EditAG-Discipline_ListTeacher").append(new Option(jsonTeacherList[ltID]['FIO'], jsonTeacherList[ltID]['ID']));
                    $("#TeacherForThisTypeLesson").append(new Option(jsonTeacherList[ltID]['FIO'], jsonTeacherList[ltID]['ID']));
                }
            }
        });

        $.ajax({
            url: "API/GetTypeLesson.php",
            dataType: 'json',
            cache: 'false',

            success: function (jsonListTypeLesson)
            {
                $("#EditAG-Discipline_TypeLesson").append(
                    new Option("","", false, false)
                );
                for(let tlID in jsonListTypeLesson)
                    $("#EditAG-Discipline_TypeLesson").append(
                        new Option(jsonListTypeLesson[tlID]['Name'], jsonListTypeLesson[tlID]['ID'], false, false)
                    );
            }
        });

        // Get Discipline List
        $.ajax({
            method: "post",
            url: 'API/GetDisciplineList.php',
            dataType: 'json',
            cache: false,

            success: function (jsonDisciplineList)
            {
                $("#EditAG-Discipline_ListDiscipline").append(new Option(""));
                for(let dlID in jsonDisciplineList){
                    $("#EditAG-Discipline_ListDiscipline").append(new Option(jsonDisciplineList[dlID]['Name'], jsonDisciplineList[dlID]['ID'], false, false));
                }
            }
        });



        $("#formAddDisciplineForAG").submit(function (e){
           e.preventDefault();

           $.ajax({
               method: 'post',
               url: 'API/AddStudyLoad.php',
               data: $("#formAddDisciplineForAG").serialize(),
               dataType: 'html',

               cache: false,

               success: function (htmlOut){
                   //alert(htmlOut);
                   $("#prompt-infoStudyLoad").html(htmlOut);
                   StudyLoad.ajax.reload();
                   $("#divBlockFormAddDisciplineForAG").attr('hidden', true);
                   $("#divBlockTablesStudyLoad").attr('hidden', false);
               },

               error: function (error){
                   $("#prompt-infoStudyLoad").html("<p class='alert alert-danger'>" +
                       "Не удалось добавить запись. Повторите операцию позже или обратитесь к администратору.</p>")
                   StudyLoad.ajax.reload();
               }
           })

        });

        $("#EditAG-Discipline_ListDiscipline").change(function (){
            $("#AddDisciplineForAcademicGroups").attr('disabled', false);
        });

        $("#btnShowFormAddDisciplineForAG").click(function (ev){
            $("#divBlockFormAddDisciplineForAG").attr('hidden', false);
            $("#divBlockTablesStudyLoad").attr('hidden', true);
            $('#EditAG-Discipline-AGCode').val($("#AGC_AGCode").text());
            $("#prompt-infoStudyLoad").html("");
        });



    });

    $("#TableStudyLoad tbody").on('click', 'tr', function (){
        //  $("#divBlockTablesStudyLoad").hide();
        var idStudyLoad = StudyLoad.row(this).data();
        //alert(idStuduLoad[5]);

        $("#divBlockTablesStudyLoad").attr('hidden', true);
        $("#divBlockFormAddDisciplineForAG").attr('hidden', false);

        $.ajax({
            method: 'post',
            url: 'API/GetStudyLoad.php',
            data: {'SLID': idStudyLoad[5]},
            dataType: 'json',
            cache: false,


            success: function (json){
                //   JSON.parse(json)
                // $("#EditAG-Discipline_ListDiscipline").val(json[0]['DisciplineID']).selected();
                console.log(json[0]['AdditionalLoad']);

                $("#EditAG-Discipline_ListDiscipline").val(json[0]['DisciplineID']);
                $("#EditAG-Discipline_TypeLesson").val(json[0]['TypeLesson']);
                $("#EditAG-Discipline-NumberHours").val(json[0]['NumberHours']);
                $("#TeacherForThisTypeLesson").val(json[0]['TeacherID']);

                if(json[0]['AdditionalLoad'] === 1) {
                    $("#AdditionalLoad").prop('checked', true);
                }
                else {
                    $("#AdditionalLoad").prop('checked', false);
                }

                $("#formAddDisciplineForAG select").trigger('change');


            },

            error: function (xhr, error, text){
                $("#prompt-infoStudyLoad").html("<p class='alert alert-danger'>Ошибка подгрузки данных для редактирования</p>");
            }
        });




    })

    $("#btnAddAcademicGroups").click(function () {
        $("#ModalCreateAG").modal({
            keyboard: false
        });
        $.ajax({
            method: 'GET',
            url: "API/getFacultyNameList.php",
            dataType: 'json',
            cache: false,

            success: function (json) {
                //  console.log(json);
                $("#ListFaculty").html("<option></option>");
                for (let id in json)
                    $("#ListFaculty").append('<option value="' + json[id]['ID'] + '">' + json[id]['Name'] + '</option>');
            }
        });

        $.ajax({
            method: 'POST',
            url: 'API/GetTeacherNameList.php',
            dataType: 'JSON',
            cache: false,

            success: function (json) {
                $("#TeacherList").html("<option></option>")
                console.log(json);
                for (var id in json)
                    $("#TeacherList").append("<option value='" + json[id]['ID'] + "'>" + json[id]['FIO'] + "</option>");

            }
        });

        $.ajax({
            method: 'GET',
            url: 'API/GetFormOfStudyList.php',
            cache: false,
            dataType: 'JSON',

            success: function (json) {
                $("#ListFormOfStudy").html('<option></option>');

                for (let id in json)
                    $("#ListFormOfStudy").append("<option value='" + json[id]['ID'] + "'>" + json[id]['Name'] + "</option>")
            }
        })

    });

    $("#ListFaculty").change(function () {
        $.ajax({
            method: 'GET',
            url: 'API/getSpecialtyNameList.php',
            data: {id: $("#ListFaculty").val()},
            cache: false,

            success: function (json) {
                json = JSON.parse(json);
                $("#ListSpecialty").html('');
                for (let hID in json) {
                    $("#ListSpecialty").append("<option value='" + json[hID]['ID']  + "'><div>" + json[hID]['Name'] +  "</div></option>");
                }
            }
        })
    });

    $("#btnCreateAG").click(function () {

        $("#FromCreateAG [required]").each(function (i, Elem) {
            if ($(Elem).val() === '') {
                $(Elem).addClass('.invalid');
            }
        });


        $.ajax({
            method: 'POST',
            url: 'API/AddAcademicGrpup.php',
            data: $("#FromCreateAG").serialize(),
            cache: false,
            dataType: 'html',

            success: function (html) {
                console.log(html);
                $("#messageInfo").html(html);
            },

            error: function (xhr, ErrorText, Error) {
                $("#messageInfo").html(Error + ":" + ErrorText);
            }
        });
        AGTable.ajax.reload();
        $("#ModalCreateAG").modal('hide');
        $("#messageInfo").fadeIn();

    })


    function AGConfig(AGCode) {
        $('#EditAG').trigger('reset');
        $('EditAG *').val('');
        $('#EditAG select').empty();
        $('#infoUpdateAG').html("");
        $('#btnDeleteAG').val(AGCode);
        $("#v-pills-home-tab").tab('show');
        $("#confirmAGCode").val('');
        $("#btnDeleteAG").attr('disabled', true);

        $('#AGC_AGCode').html(AGCode);
        $('#AGEditAGCode').val(AGCode);
        $('#EditAGCodeOld').val(AGCode);

        $("#EditAG").toggle();

        $.ajax({
            method: 'post',
            url: 'API/GetTableAcademicGroups.php',
            data: {AGCode: AGCode},
            dataType: 'json',
            cache: false,

            success: function (jsonAcademicGroups) {
                console.log(jsonAcademicGroups);
                $("#YearStart").val(jsonAcademicGroups['YearStart']);
                $("#YearEnd").val(jsonAcademicGroups['YearEnd']);
                $("#NumberCourse").val(jsonAcademicGroups['Course'])
                $.ajax({
                    method: 'post',
                    url: 'API/getFacultyNameList.php',
                    cache: false,
                    dataType: 'json',

                    success: function (jsonFaculty) {
                        console.log(jsonFaculty);
                        $("#FacultyList").html('<option></option>');
                        for (let fctID in jsonFaculty)
                            $('#FacultyList').append('<option value="' + jsonFaculty[fctID]['ID'] + '">' + jsonFaculty[fctID]['Name'] + '</option>');

                        $("#FacultyList option[value='" + jsonAcademicGroups['FacultyID'] + "']").attr("selected", "selected");
                    }
                });

                $.ajax({
                    method: 'GET',
                    url: 'API/getSpecialtyNameList.php',
                    data: {id: jsonAcademicGroups['FacultyID']},
                    cache: false,

                    success: function (jsonSpecialtyList) {

                        console.log(jsonSpecialtyList);
                        $("#SpecialtyList").html('<option></option>');
                        jsonSpecialtyList = JSON.parse(jsonSpecialtyList);
                        for (let spID in jsonSpecialtyList)
                            $('#SpecialtyList').append("<option value='" + jsonSpecialtyList[spID]['ID'] + "'>" + jsonSpecialtyList[spID]['Name'] + "</option>");

                        $("#SpecialtyList option[value='" + jsonAcademicGroups['SpecialtyID'] + "']").attr("selected", "selected");


                    }
                });

                $.ajax({
                    method: 'POST',
                    url: 'API/GetTeacherNameList.php',
                    dataType: 'json',
                    cache: false,

                    success: function (jsonTeacherList) {
                        console.log(jsonTeacherList);
                        $('#AGEditTeacherList').html('<option value=""></option>');
                        for (let teacherID in jsonTeacherList)
                            $("#AGEditTeacherList").append("<option value='" + jsonTeacherList[teacherID]['ID'] + "'>" + jsonTeacherList[teacherID]['FIO'] +
                                "</option>");

                        $("#AGEditTeacherList option[value='" + jsonAcademicGroups['TeacherID'] + "']").attr("selected", "selected");


                    }
                });

                $.ajax({
                    method: 'post',
                    url: 'API/GetFormOfStudyList.php',
                    dataType: 'json',
                    cache: false,

                    success: function (jsonFOS) {
                        console.log(jsonFOS);

                        $("#AGEditListFormOfStudy").html("<option></option>");
                        for (let FOSID in jsonFOS)
                            $("#AGEditListFormOfStudy").append("<option value='" + jsonFOS[FOSID]['ID'] + "'>" + jsonFOS[FOSID]['Name'] + "</option>")

                        $("#AGEditListFormOfStudy option[value='" + jsonAcademicGroups['FOSID'] + "']").attr("selected", "selected");
                    }
                });

                $("#AGEditHeadmanList").html("<option value=''></option>");
                $.ajax({
                    method: 'POST',
                    url: "API/GetStudentsForAG.php",
                    dataType: 'json',
                    data: {AGCode: AGCode},

                    success: function (jsonHeadmanList) {
                        for (let id in jsonHeadmanList)
                            $("#AGEditHeadmanList").append($("<option value='" + jsonHeadmanList[id]['ID'] + "'>" + jsonHeadmanList[id]['StudentFIO'] + "</option>"));

                        $("#AGEditHeadmanList option[value='" + jsonAcademicGroups['HeadmanID'] + "']").attr("selected", "selected");

                    },

                    error: function (xhr, ErrorText, Error) {
                        console.log(Error + ": " + ErrorText);
                    }
                });

                $("#EditAG").toggle();
            }
        });


        //Open modal
        $('#AGConfiguration').modal({
            keyboard: false,
        });
    }

    $("#EditAG *").change(function () {
        $("#btnSaveAG").attr('disabled', false);
        //   $("#infoUpdateAG").html('Есть несохраненные изменения!')
        //  $("#EditAG").css('backgroundColor', '#e2ae8e')
    });

    $('#btnSaveAG').click(function () {

        console.log($("#EditAG").serialize())
        $("#btnSaveAG").attr('disabled', true);
        $("#infoUpdateAG").html('<div class="spinner-border" role="status">\n' +
            '  <span class="sr-only">Loading...</span>\n' +
            '</div>');

        $.ajax({
            method: 'POST',
            data: $('#EditAG').serialize(),
            dataType: 'json',
            url: 'API/UpdateAcademicGroups.php',
            cache: false,

            success: function (jsonResult) {
                $('#infoUpdateAG').html(jsonResult);
                $("#AGC_AGCode").text($("#AGEditAGCode").val());
                AGTable.ajax.reload();
            },

            error: function (xhr, TextError, Error) {
                $("#infoUpdateAG").html(Error + ": " + TextError);
            }
        })
    })

    $("#btnDeleteAG").click(function () {
        var AGID = $("#btnDeleteAG").val();
        $.ajax({
            method: 'POST',
            url: 'API/DeleteAcademicGroups.php',
            data: {AGCode: AGID},
            cache: false,

            success: function (Result) {
                Result = JSON.parse(Result);
                $('#messageInfo').html("<div class='alert alert-info'>" + Result + "</div>")
                    .fadeIn();

                $("#AGConfiguration").modal('hide');
                AGTable.ajax.reload();
            },
            error: function (xhr, TextError, Error) {
                $("#messageInfo").html(Error + ": " + TextError);
            }

        })

    })

    $("#v-pills-profile-tab").click(function () {
        $("#StudentsListBoby").html("<span class='spinner-border text-center' role='status'></span>");
        $("#EditStudentBlock").css('display', 'none');
        $("#StudentsListBoby").css('display', 'block');
        $("#divBtnForAddStudent").css('display', 'none');
        $("#prompt_select_student").css("display", 'block');
        $("#spinner_load_student_info").attr("hidden", false);


        $.ajax({
            method: 'POST',
            url: 'API/GetStudentsForAG.php',
            data: {AGCode: $("#AGC_AGCode").text()},
            dataType: 'JSON',
            cache: false,

            success: function (json) {
                $("#StudentsListBoby").html("<div class=\"list-group-item\">\n" +
                    "                                                 Студенты" +
                    "                                            </div>");

                if(json.length == 0)
                    $("#StudentsListBoby").append("<p class='text-center'>Нет записей</p>")

                for (let id in json) {
                    $("#StudentsListBoby").append('<a href="#" title="Нажмите для получения информации или редактирования." onclick="ShowStudentsInfo(' + json[id]['ID'] + ')" class="list-group-item list-group-item-action" data-toggle="list">' + json[id]['StudentFIO'] + '</a>');
                }
                $("#spinner_load_student_info").attr("hidden", true);
            },

            error: function (xhr, ErrorText, error) {
                $("#StudentsListBoby").html("<div class='alert alert-danger'>Не могу получить список студентов. Обновите страницу или подождите немного.</div>")
            }
        });

        $("#FormEditStudentListAG").html("<option></option>");
        $.ajax({
            url: "API/GetListAG.php",
            dataType: 'json',
            success: function (AGList) {
                for (let list in AGList)
                    $("#FormEditStudentListAG").append('<option value="' + AGList[list]['AGCode'] + '">' + AGList[list]['AGCode'] + '</option>');

                $("#FormEditStudentListAG option[value='" + $("#AGC_AGCode").text() + "']").attr("selected", "selected");

            }
        })


    });

    $("#FacultyList").change(function () {
        $("#SpecialtyList").html("<option></option>");

        $.ajax({
            method: "GET",
            url: "API/getSpecialtyNameList.php",
            data: {id: $("#FacultyList").val()},
            dataType: 'JSON',

            success: function (jsonSpecialty) {
                console.log(jsonSpecialty);
                for (let id in jsonSpecialty)
                    $("#SpecialtyList").append("<option value='" + jsonSpecialty[id]['ID'] + "'>" + jsonSpecialty[id]['Name'] + "</option>");

                $("#SpecialtyList").attr('disabled', false);
            }
        });
    })

    $("#confirmAGCode").keyup(function () {
        if ($("#confirmAGCode").val() === $("#AGEditAGCode").val()) {
            $("#btnDeleteAG").attr('disabled', false);
        } else {
            $("#btnDeleteAG").attr('disabled', true);
        }
    });


    function ShowStudentsInfo(sID) {
        $("#FormEditStudents").trigger('reset');
        $("#FormEditStudents *").attr("disabled", true);
        $("#spinner_load_student_info").attr("hidden", false);
        $("#prompt_msgErrorToLoadStudentInfo").attr('hidden', true);

        $.ajax({
            method: 'POST',
            url: 'API/GetAllInfoOfStudent.php',
            dataType: 'json',
            data: {id: sID},

            success: function (StudentInfo) {
                $("#prompt_select_student").css("display", 'none');
                $("#FormEditStudentSurname").val(StudentInfo['Surname']);
                $("#FormEditStudentName").val(StudentInfo['Name']);
                $("#FormEditStudentMiddleName").val(StudentInfo['MiddleName']);
                $("#FormEditStudentBrieflyName").val(StudentInfo['BrieflyName']);
                $("#FormEditStudentDateOfBirth").val(StudentInfo['DateOfBirth']);
                $("#FormEditStudentNumberBook").val(StudentInfo['NumberBook']);
                $("#FormEditStudentEmail").val(StudentInfo['Email']);
                $("#FormEditStudentLogin").val(StudentInfo['Login']);

                $('input[name="Gender"][value="' + StudentInfo['Gender'] + '"]').prop('checked', true);
                $('input[name="TypeOfStudy"][value="' + StudentInfo['TypeOfStudy'] + '"]').prop('checked', true);


                $("#EditStudentBlock").css('display', 'block');
                $("#FormEditStudents *").attr("disabled", false);
                $("#spinner_load_student_info").attr("hidden", true);
                $("#prompt_msgErrorToLoadStudentInfo").attr('hidden', true);

            },
            error: function (xhr, ErrorText, Error) {
                $("#prompt_msgErrorToLoadStudentInfo").attr('hidden', false)
                $("#spinner_load_student_info").attr("hidden", true);
            }
        })
    }

    $("#btnAddStudent").click(function () {

        $("#FormEditStudents").trigger('reset');
        $("#EditStudentBlock").css('display', 'block');
        $("#StudentsListBoby a").removeClass('active');
        $("#StudentsListBoby").css('display', 'none');
        $("#divBtnForAddStudent").css('display', 'block');
    });

    $("#AddStudentCancel").click(function () {
        $("#EditStudentBlock").css('display', 'none');
        $('#StudentsListBoby').css('display', 'block');
        $("#divBtnForAddStudent").css('display', 'none');

    });

    $("#btnAddNewStudent").click(function () {
        console.log($("#FormEditStudents").serialize());
    })

</script>
