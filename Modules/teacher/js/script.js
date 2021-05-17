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

$("#SelectListDiscipline").change(function () {

    $("#TableAttendanceStudents").html("<div class='alert text-center alert-info'>Выберите группу и дисциплину для просмотра журнала.</div>")
    $("#DivBlockBtnJournal").hide();

    let Discipline;
    Discipline = $("#SelectListDiscipline").val();

    if ("" === Discipline) {
        return;
    }

    $("#TableAttendanceStudents").html('<div class="spinner-border text-center text-primary" role="status">\n' +
        '  <span class="sr-only">Loading...</span>\n' +
        '</div>');

    $.ajax({
        method: 'POST',
        url: 'API/GetTableAttendanceStudents.php',
        data: {
            AGCode: $("#SelectListAG").val(),
            Discipline: $("#SelectListDiscipline").val(),
            Teacher: $("#TeacherID").val()
        },
        dataType: 'html',

        success: function (html) {
            $("#TableAttendanceStudents").html(html);
            $("#DivBlockBtnJournal").toggle();
        },
        error: function () {
            $("#TableAttendanceStudents").html("<div class='alert alert-danger' >Не могу загрузить информацию. Возможно потеряно интернет-соединение или возникла ошибка. Попробуйте обновить страницу или обратитесь к администратору.</div>");
        }
    })

})

$("#btnAddLesson").click(function () {

});

