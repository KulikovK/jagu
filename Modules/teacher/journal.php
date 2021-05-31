<?php
/*
 * Copyright (c) 2021. Kulikov K. P. [kostj1998.10.13@yandex.ru]
 */
//TODO: пересмотреть стуктуру lessonInfo опираясь на StudyLoad
?>


<div class="card  text-dark">
	<div class="card-header bg-primary text-white">
		<div class="card-text h5 text-center">Журнал академической группы</div>

		<div>
			<form class="">
				<input id="TeacherID" hidden type="number"
				       value="<?= $_SESSION[$_COOKIE['jagu_user_key']]['UserID'] ?>">
				<select id="SelectListAG" class="mr-sm-2 custom-select" name="AGCodeList"></select>


				<select id="SelectListDiscipline" class="mr-sm-2 custom-select" name="Discipline"></select>

				<select id="SelectTypeLesson" name="TypeLesson" class="mr-sm-2 custom-select"></select>

				<div class="custom-control custom-checkbox custom-control-inline">
					<input type="checkbox" checked id="ShowAllLesson" name="ShowAll" value="1"
					       class="custom-control-input">
					<label class="custom-control-label" for="ShowAllLesson">Только мои занятия</label>
				</div>

			</form>
		</div>

		<div id="DivBlockBtnJournal" class="" style="display: none">
			<a id="btnAddLesson" href="#mdAddLesson" class="btn btn-light">Добавить занятие</a>
		</div>


	</div>

	<div class="card-body">
		<div id="LessonInfo">
			<table id='tableLessonInfo' class="text-center table-bordered table-info table-sm">
				<thead>
				<tr>
					<th>Тип занятия</th>
					<th>Часов по плану</th>
					<th>Пройдено часов</th>
				</tr>
				</thead>
				<tbody id="tLessonInfoBody">

				</tbody>
			</table>
		</div>
		<div id="AttendanceStatus">
			<!--AllStatus-->
		</div>
		<div id="TableAttendanceStudents" class="text-center">
			<div class='alert text-center alert-info'>Выберите группу и дисциплину для просмотра журнала.</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalAddLesson" data-backdrop="static" data-toggle="modal" role="dialog">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<p class="modal-title text-center h5">Добавить занятие
				</p>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div id="CreateLesson_Status">
				<!--статус создания занятия-->
			</div>
			<div class="modal-body">
				<div id="divBlockCreateLesson" class="" style="display: block">
					<form id="CreateLesson" class="from">

						<input hidden id="CL_AGCode" name="CL_AGCode" required>
						<input hidden id="CL_Teacher" name="CL_TeacherID" required>
						<input hidden id="CL_Discipline" name="CL_DisciplineID" required>

						<div class="form-group row">
							<label class="control-label col-form-label col-sm-4">Дата</label>
							<div class="col-sm-8">
								<input class="form-control" value="<?= date("d.m.Y") ?>" type="text" id="Lesson_date"
								       name="CL_Date"
								       required></div>
						</div>

						<div class="form-group row">
							<label class="control-label col-form-label col-sm-4">Дисциплина:</label>
							<div class="col-sm-8">
								<input type="text" id="DisciplineName" disabled class="form-control">
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-form-label col-sm-4">Тип занятия:</label>
							<div class="col-sm-8">
								<select required id="TypeLesson" name="CL_TypeLesson" class="custom-select"></select>
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-form-label col-sm-4">Тема занятия</label>
							<div class="col-sm-8">
								<textarea maxlength="254" class="form-control" id="LessonTopic" name="CL_Topic"
								          required></textarea>
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-form-label col-sm-4">Номер пары:</label>
							<div class="col-sm-8">
								<select required id="LessonNumber" name="CL_LessonNumber"
								        class="custom-select"></select>
							</div>
						</div>


					</form>
				</div>


				<div id="divBlockWriteAttendance" class="card border border-primary m-1 p-2" style="display: block">
					<div class="card-header">
						<p class="card-title text-center">Посещаемость</p>
						<div>
							<label>Подгруппа:
								<select class="custom-select" id="SelectListSubgroups">
									<option value="0">Все студенты</option>
								</select>
							</label>
						</div>
					</div>
					<div class="card-body">
						<table id='WriteAttendanceTable' class='table table-hover table-primary table-bordered'>
							<thead>
							<tr>
								<th>ID</th>
								<th>Студент</th>
								<th>Пропущено</th>
								<th>Баллы</th>
								<th>Коментарий</th>
							</tr>
							</thead>

							<tbody>

							</tbody>
						</table>
					</div>
				</div>

			</div>
			<div class="modal-footer d-flex justify-content-between">
				<div class="">
					<button value="" style="display: none" id="btnDeleteLesson" class="btn btn-outline-danger">Удалить
						данное занятие
					</button>
				</div>
				<button value="" id="btnCreateLessonNext" class="btn btn-outline-info" form="CreateLesson">Сохранить
				</button>
			</div>
		</div>
	</div>
</div>


<script>

	const AlertStatus = {OK: 'alert-success', INFO: 'alert-info', WARNING: 'alert-warning', ERROR: 'alert-danger'}

	function SetStatus(string, title = 'Информация', status = AlertStatus.INFO) {
		$("#AttendanceStatus").html('<div class="alert ' + status + ' alert-dismissible fade show" role="alert">' +
				'<h4 class="alert-heading">' + title + '</h4><p>' + string + '</p>' +
				'<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
				'<span aria-hidden="true">&times;</span>' +
				'</button>' +
				'</div>');
	}

	let TableWriteAttendance = $("#WriteAttendanceTable").DataTable({
		ordering: false,
		info: false,
		paging: false,
		processing: true,
		width: '100%',

		language: {
			url: "//cdn.datatables.net/plug-ins/1.10.22/i18n/Russian.json",
		},

		ajax: {
			type: "post",
			url: "API/WriteAttendanceInfo.php",
			serverSide: true,
			cache: false,
			data: {
				AGCode: function () {
					return $("#CL_AGCode").val()
				},
				Subgroups: function () {
					return $("#SelectListSubgroups").val();
				},
				LessonID: function () {
					return $("#btnCreateLessonNext").val();
				}

			},

			dataSrc: function (json) {
				console.log(json);
				return json.data;
			}
		},


		column: [
			{data: 0},
			{data: 1},
		],


		columnDefs: [

			{
				targets: 2,
				data: 2,
				className: '',
				defaultContent: "<input name='AttendanceHours' class='form-control' type='number' min='0' max='2' value='0' >",
				render: function (data, type, row) {
					return '<input type="number" min="0" max="2" name="AttendanceHours" value="' + data + '" class="form-control">';
				},
			},

			{
				targets: 3,
				data: 3,
				defaultContent: "<input name='Grande' class='form-control' type='number' value='0' >",
				render: function (data, type, row) {
					return '<input type="number" name="Grande" value="' + data + '" class="form-control">';
				},
			},
			{
				targets: 4,
				data: 4,
				defaultContent: "<input name='Comments' type='text' class='form-control'>",
				render: function (data, type, row) {
					return '<input type="text" name="Comments" value="' + data + '" class="form-control">';
				}
			}

		]

	});
	TableWriteAttendance.column(0).visible(false);

	$("#SelectTypeLesson").select2({
		width: '25%',
		//	theme: 'classic',
		allowClear: true,
		placeholder: 'Тип занятий'
	});

	$("#SelectListSubgroups").change(function () {
		LoadStudentList();
	})

	//Изменен тип занятия
	$("#TypeLesson").change(function () {
		$("#SelectListSubgroups").html(new Option("Все студенты", '0'));
		$.ajax({
			method: 'post',
			url: 'API/GetListSubGroups.php',
			data: {
				AGCode: $("#CL_AGCode").val(),
				DisciplineID: $("#CL_Discipline").val(),
				TeacherID: $("#CL_Teacher").val(),
				TypeLessonID: $("#TypeLesson").val(),
			},

			success: function (json) {
				json = JSON.parse(json);
				for (let id in json)
					$("#SelectListSubgroups").append(new Option(json[id]['Number'] + " подгруппа", json[id]["ID"]));
			}

		});

	})

	//Получаем список студентов
	function LoadStudentList() {
		TableWriteAttendance.ajax.reload();
	}

	//Получение доступных типов занятий
	function LoadTypeLesson() {
		$("#TypeLesson").html(new Option());
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
					$("#TypeLesson").append(new Option(json[id]['Name'], json[id]['ID']));
				}
			},
			error: function () {
				alert("Не могу получить тип заниятия!");
			}
		});
	}


	$.get("API/GetNumberLesson.php", {}, function (json) {
		json = JSON.parse(json);
		for (let id in json) {
			$("#LessonNumber").append(new Option(json[id]['Number'] + " пара (" + json[id]['StartTime'] + ' - ' + json[id]['EndTime'] + ")", json[id]['Number']));
		}
	});

	//Add Lesson
	$("#btnAddLesson").click(function () {


		$("#CreateLesson").trigger('reset');
		$("#CreateLesson *").trigger('reset');
		$("#CreateLesson select").trigger('change');

		$("#btnCreateLessonNext").val(null);
		$("#btnDeleteLesson").hide();

		$("#CL_AGCode").val($("#SelectListAG").val());
		$("#CL_Teacher").val($("#TeacherID").val());
		$("#CL_Discipline").val($("#SelectListDiscipline option:selected").val())
		$("#DisciplineName").val($("#SelectListDiscipline option:selected").text());

		$("#divBlockCreateLesson *").prop('disabled', false);
		$("#divBlockWriteAttendance").show();
		$("#btnCreateLessonNext").prop('hidden', false)
		$("#CreateLesson_Status").html("");

		LoadTypeLesson();


		$("#SelectListSubgroups").html(new Option("Все студенты", '0'));

		LoadStudentList();


		$("#modalAddLesson").modal({
			keyboard: false,
		});

	});

	$("#Lesson_date").datepicker({
		changeMonth: true,
		showWeek: true,
		beforeShowDay: function (date) {
			var dayOfWeek = date.getDay();
			if (dayOfWeek == 0) {
				return [false];
			} else {
				return [true];
			}
		}

	});

	$("#CreateLesson select").select2({
		width: '100%',
		//theme: 'classic',
		allowClear: true,
		placeholder: 'Выберите значение'
	});

	//create lesson
	$("#CreateLesson").on("submit", function (e) {
		e.preventDefault();

		let StudentListID = [];
		let StudentAttendanceHours = []
		let StudentGrade = []
		let StudentComments = []

		$.each(TableWriteAttendance.rows().data(), function () {
			StudentListID.push(this["0"]);
		});
		//console.log(StudentListID);

		$.each(TableWriteAttendance.rows().data().$('input[name = "AttendanceHours"]'), function () {
			StudentAttendanceHours.push($(this).val());
		});
		//	console.log(StudentAttendanceHours);

		$.each(TableWriteAttendance.rows().data().$('input[name = "Grande"]'), function () {
			StudentGrade.push($(this).val());
		});
		//console.log(StudentGrade);

		$.each(TableWriteAttendance.rows().data().$('input[name = "Comments"]'), function () {
			StudentComments.push($(this).val());
		});
		//console.log(StudentComments);


		$.ajax({
			method: 'POST',
			url: 'API/AddLesson.php',
			dataType: 'json',
			cache: 'false',
			data: {
				Lesson: $("#CreateLesson").serialize(),
				StudentsID: StudentListID,
				StudentAttendance: StudentAttendanceHours,
				StudentGrade: StudentGrade,
				StudentComments: StudentComments,
				LessonID: $("#btnCreateLessonNext").val()
			},

			success: function (json) {

				if (json !== false) {
					SetStatus("Информация добавлена!", "Успех", AlertStatus.OK);
					GetTableAttendance();

					$("#modalAddLesson").modal('hide');

				} else {
					$("#CreateLesson_Status").html("<p class='alert alert-danger'>" +
							"Не удалось создать занятие. проверьте корректность заполнения данных." +
							"</p>");
					SetStatus("При добавлении занятия возникла ошибка", "Внимание!", AlertStatus.ERROR);
				}

			}


		})

	});

	$("#SelectTypeLesson").change(function () {
		GetTableAttendance();
	})

	$("#ShowAllLesson").change(function () {
		GetTableAttendance();
	})


	function ShowEditLesson(LessonID) {

		$.ajax({
			method: 'post',
			url: 'API/GetLessonInfo.php',
			data: {ID: LessonID},
			dataType: 'json',
			cache: false,

			success: function (json) {
				//console.log(json);


				$("#CL_AGCode").val($("#SelectListAG").val());
				$("#CL_Teacher").val($("#TeacherID").val());
				$("#CL_Discipline").val($("#SelectListDiscipline option:selected").val())
				$("#DisciplineName").val(json['Discipline']);

				$("#btnCreateLessonNext").val(null)
				$("#divBlockCreateLesson *").prop('disabled', false);
				$("#divBlockWriteAttendance").show();
				$("#btnCreateLessonNext").prop('hidden', false)
				$("#CreateLesson_Status").html("");

				//$("#btnAddLesson").trigger('click');


				$("#Lesson_date").val(json['Date']);

				//	LoadTypeLesson();


				$("#TypeLesson").val(json['TypeLesson']);
				$("#TypeLesson").trigger('change');

				$("#LessonTopic").val(json['Topic']);


				$("#LessonNumber").val(json['LessonNumber']);
				$("#LessonNumber").trigger('change');

				if (json['TeacherID'] != $("#TeacherID").val()) {
					//	alert(json['TeacherID']);
					//alert("У вас нет прав для редактирования этих данных!");
					$("#CreateLesson_Status").html("<p class='alert alert-warning'>У вас нет прав для редактирования этих данных!</p>")
					$("#divBlockCreateLesson *").prop('disabled', true);
					$("#divBlockWriteAttendance").hide();
					$("#btnCreateLessonNext").prop('hidden', true);
					$("#btnDeleteLesson").hide();
					//return;
				} else {
					$("#btnCreateLessonNext").val(json['ID']);
					LoadStudentList();
					$("#btnDeleteLesson").val(json['ID']);
					$("#btnDeleteLesson").show();
				}

				$("#modalAddLesson").modal({
					keyboard: false
				});

			},


			error: function () {
				SetStatus("Не могу получить информацию о занятии!", "Ошибка", AlertStatus.ERROR);
			}
		});


	}

	$("#btnDeleteLesson").click(function () {
		let t = confirm("Вы уверены? Данная операция удалит всю информацию об этом занятии, включая данные о посещаемости студентов и их баллах!");

		if (t) {

			$.ajax({
				method: 'post',
				url: 'API/DeleteLesson.php',
				dataType: 'json',
				data: {
					LessonID: function () {
						return $("#btnDeleteLesson").val();
					}
				},

				success: function () {
					SetStatus("Занятие удалено", "Информация", AlertStatus.OK);
					$("#modalAddLesson").modal('hide');
				},

				error: function () {
					SetStatus("Не удалось удалить занятие!", 'Ошибка!', AlertStatus.ERROR);
				}
			});

			GetTableAttendance();
		}

	})
</script>