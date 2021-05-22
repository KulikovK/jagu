/*
 * Copyright (c) 2021. Kulikov K. P. [kostj1998.10.13@yandex.ru]
 */
/*
* Project: JAGU
* Module: Teacher
* Submodule: ALL
* Create date: 24.04.2021 10:07*/

$(document).ready(function () {
    $("#SelectListAG").select2({
        width: '25%',
        theme: 'classic',
        allowClear: true,
        placeholder: 'Выберите группу'
    });

    $("#SelectListDiscipline").select2({
        width: '25%',
        theme: 'classic',
        allowClear: true,
        placeholder: 'Выберите дисциплину'
    });

    $.ajax({
        method: 'post',
        data: {'TeacherID': $("#TeacherID").val()},
        url: 'API/GetStudyLoad.php?get=AGList',
        dataType: 'json',
        cache: false,
        success: function (json) {
            $("#SelectListAG").html(new Option(""));
            for (let id in json)
                $("#SelectListAG").append(new Option(json[id]['AGCode'], json[id]['AGCode']));
            $("#SelectListAG").prop('disabled', false);
        },
        error: function () {
            $("#SelectListAG").html(new Option("Не удалось получить список групп!"));
            $("#SelectListAG").prop('disabled', true);

        }
    });

    $("#AttendanceTable").dataTable();


});

$("#SelectListAG").change(function () {

    if ($("#SelectListAG").val() === "") {
        $("#SelectListDiscipline").html(new Option(""));
        $("#SelectListDiscipline").trigger('change');
        return;
    }

    $("#SelectListDiscipline").html('<div class="spinner-border text-center text-primary" role="status">\n' +
        '  <span class="sr-only">Loading...</span>\n' +
        '</div>')

    $("#SelectListDiscipline").prop('disabled', true);

    let AGCode = $("#SelectListAG").val();

    $.ajax({
        method: 'post',
        url: 'API/GetStudyLoad.php?get=DisciplineList',
        data: {'TeacherID': $("#TeacherID").val(), 'AGCode': AGCode},
        dataType: 'json',
        cache: 'false',

        success: function (json) {
            $("#SelectListDiscipline").html(new Option(""));
            for (let id in json)
                $("#SelectListDiscipline").append(new Option(json[id]['dName'], json[id]['dID']));
            $("#SelectListDiscipline").prop('disabled', false);
        },

        error: function () {
            alert('Не удалось получить список дисциплин! Обновите страницу или обратитесь к администратору.');

        }

    });

});

function GetTableAttendance() {
    $("#TableAttendanceStudents").html('<div class="spinner-border text-center text-primary" role="status">\n' +
        '  <span class="sr-only">Loading...</span>\n' +
        '</div>');

    $("#tLessonInfoBody").html("");
    $.ajax({
        method: 'post',
        url: 'API/GetStudyLoadInfo.php',
        dataType: 'json',
        data: {
            TeacherID: $("#TeacherID").val(),
            DisciplineID: $("#SelectListDiscipline").val(),
            AGCode: $("#SelectListAG").val(),
            TypeLessonID: $("#SelectTypeLesson").val()
        },


        success: function (json) {
            for (let ID in json) {
                $("#tLessonInfoBody").append("<tr><td>" + json[ID]['TypeLesson'] + "</td><td>" + json[ID]['NumberHours'] + "</td><td>" + json[ID]['CurrentHours'] + "</td>");
            }
        }

    })

    $.ajax({
        method: 'POST',
        url: 'API/GetTableAttendanceStudents.php',
        data: {
            AGCode: $("#SelectListAG").val(),
            Discipline: $("#SelectListDiscipline").val(),
            Teacher: $("#TeacherID").val(),
            TypeLesson: $("#SelectTypeLesson").val(),
            ShowAllLesson: function () {
                if ($('#ShowAllLesson').is(':checked')) {
                    return 1;
                } else {
                    return 0;
                }
            }
        },
        dataType: 'html',

        success: function (html) {
            $("#TableAttendanceStudents").html(html);
        },
        error: function () {
            $("#TableAttendanceStudents").html("<div class='alert alert-danger' >Не могу загрузить информацию. Возможно потеряно интернет-соединение или возникла ошибка. Попробуйте обновить страницу или обратитесь к администратору.</div>");
        }
    })
}

$("#SelectListDiscipline").change(function () {

    $("#TableAttendanceStudents").html("<div class='alert text-center alert-info'>Выберите группу и дисциплину для просмотра журнала.</div>")
    $("#DivBlockBtnJournal").slideUp();

    let Discipline;
    Discipline = $("#SelectListDiscipline").val();

    if ("" === Discipline) {
        return;
    }

    //Получаем типы занятий
    $("#SelectTypeLesson").html(new Option("Все занятия", '0'));
    $.ajax({
        method: 'post',
        url: 'API/GetTypeLesson.php',
        dataType: 'json',
        data: {
            AGCode: $("#SelectListAG").val(),
            TeacherID: $("#TeacherID").val(),
            DisciplineID: $("#SelectListDiscipline").val()
        },

        success: function (json) {
            for (let id in json) {
                $("#SelectTypeLesson").append(new Option(json[id]['Name'], json[id]['ID']));
            }
        }
    });

    LoadTypeLesson();

    $("#tLessonInfoBody").html("")


    GetTableAttendance();
    $("#DivBlockBtnJournal").slideToggle();


})



