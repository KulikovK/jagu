<?php
/*
 * Copyright (c) 2021. Kulikov K. P. [kostj1998.10.13@yandex.ru]
 */
//TODO: пересмотреть стуктуру lessonInfo опираясь на StudyLoad
?>


<div class="card border-primary">
	<div class="card-header bg-info text-white">
		<div class="card-text h5 text-center">Журнал академической группы</div>

		<div>
			<form class="">
				<input id="TeacherID" hidden type="number"
				       value="<?= $_SESSION[$_COOKIE['jagu_user_key']]['UserID'] ?>">
				<select id="SelectListAG" class="mr-sm-2 custom-select" name="AGCodeList"></select>


				<select id="SelectListDiscipline" class="mr-sm-2 custom-select" name="Discipline"></select>

			</form>
		</div>

		<div id="DivBlockBtnJournal" style="display: none">
			<a id="btnAddLesson" href="#mdAddLesson" class="btn btn-light">Добавить занятие</a>
		</div>

	</div>

	<div class="card-body">

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
			<div class="modal-body">
				<div id="CreateLesson_Status">
					<!--статус создания занятия-->
				</div>

				<div id="divBlockCreateLesson" class="">
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
								<textarea maxlength="254" class="form-control" name="CL_Topic" required></textarea>
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

			</div>
			<div class="modal-footer">
				<button id="btnCreateLessonNext" class="btn btn-outline-info" form="CreateLesson">Продолжить</button>
			</div>
		</div>
	</div>
</div>

<script>

	$.get("API/GetNumberLesson.php", {}, function (json) {
		json = JSON.parse(json);
		for (let id in json) {
			$("#LessonNumber").append(new Option(json[id]['Number'] + " пара (" + json[id]['StartTime'] + ' - ' + json[id]['EndTime'] + ")", json[id]['Number']));
		}
	});

	$("#btnAddLesson").click(function () {

		$("#CL_AGCode").val($("#SelectListAG").val());
		$("#CL_Teacher").val($("#TeacherID").val());
		$("#CL_Discipline").val($("#SelectListDiscipline option:selected").val())
		$("#DisciplineName").val($("#SelectListDiscipline option:selected").text());


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
			}
		})

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
		theme: 'classic',
		allowClear: true,
		placeholder: 'Выберите значение'
	});

	$("#CreateLesson").on("submit", function (e) {
		e.preventDefault();

		$.ajax({
			method: 'POST',
			url: 'API/AddLesson.php',
			dataType: 'json',
			cache: 'false',
			data: $("#CreateLesson").serialize(),
			success: function (json) {

				if (json === true) {
					$("#CreateLesson_Status").html("<p class='alert alert-success'>" +
							"Информация о занятии добавлена. Сейчас вы можете заполнить посещаемость или сделать это позже" +
							"</p>");

					$.ajax({
						method: 'post',
						url: 'API/WriteAttendanceInfo.php',
						data: {AGCode: $("#CL_AGCode").val(), SubGroups: 0},
						dataType: 'html',

						success: function (html) {
							$("#divBlockCreateLesson").html(html);
						}
					})


				} else {
					$("#CreateLesson_Status").html("<p class='alert alert-danger'>" +
							"Не удалось создать занятие. проверьте корректность заполнения данных." +
							"</p>");
				}

			}


		})

	});

</script>