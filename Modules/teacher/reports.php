<?php
/*
 * Copyright (c) 2021. Kulikov K. P. [kostj1998.10.13@yandex.ru]
 */
?>

<div class="card bg-light text-white">
	<div class="card-header bg-secondary">
		<h5 class="card-title text-center">Месячная ведомость</h5>
		<form id="formGetReports">
			<select id="SelectListMonth" name="Month">
				<option value="0" selected disabled></option>
				<option value="9">Сентябрь</option>
				<option value="10">Октябрь</option>
				<option value="11">Ноябрь</option>
				<option value="12">Декабрь</option>
				<option value="1">Январь</option>
				<option value="2">Февраль</option>
				<option value="3">Март</option>
				<option value="4">Апрель</option>
				<option value="5">Май</option>
				<option value="6">Июнь</option>
			</select>
			<input id="TeacherID" name="TeacherID" hidden type="number"
			       value="<?= $_SESSION[$_COOKIE['jagu_user_key']]['UserID'] ?>"></form>

	</div>

	<div class="card-body">
		<button id="btnGetFileReports" form="formGetReports" class="mb-2 btn btn-success">Сохранить в Excel</button>
		<table id="tableReports" class="table table-bordered table-sm">
			<thead>
			<tr>
				<th>Дата</th>
				<th>Часы занятий</th>
				<th>Факультет</th>
				<th>Курс</th>
				<th>Группа</th>
				<th>Содержание занятий</th>
				<th>Вид занятий</th>
				<th>Количество часов</th>
			</tr>
			</thead>

			<tbody>

			</tbody>
		</table>

	</div>

</div>


<script>
	$("#SelectListMonth").select2({
		width: '25%',
		placeholder: 'Выберите месяц',

	});

	let TableReports = $("#tableReports").DataTable({
		ordering: false,
		info: true,
		paging: false,
		processing: true,
		// width: '100%',
		language: {
			url: "//cdn.datatables.net/plug-ins/1.10.22/i18n/Russian.json",
		},

		dom: "t",

		ajax: {
			method: 'post',
			url: 'API/GetReports.php',
			serverSide: true,
			cache: false,
			data: {
				TeacherID: function () {

					return $("#TeacherID").val();
				},
				Month: function () {
					return $("#SelectListMonth").val();
				}

			},

			dataSrc: function (json) {
				console.log(json);
				return json.data;
			}
		},

		columns: [
			{data: 'date'},
			{data: 'HoursLesson'},
			{data: 'Faculty'},
			{data: 'Course'},
			{data: 'AGCode'},
			{data: 'Topic'},
			{data: 'TypeLesson'},
			{data: 'CountHours'}
		]

	});

	$("#SelectListMonth").change(function () {
		TableReports.ajax.reload();
	})

	$("#formGetReports").on('submit', function (e) {
		e.preventDefault();


		$.ajax({
			method: 'post',
			url: 'API/GetReportsFile.php',
			data: $("#formGetReports").serialize(),
			dataType: 'json',

			success: function (result) {
				if (result['success'] == true) {
					window.open(result['Data'], '_blank').focus();
				} else {
					alert("Не удалось сформировать файл!");
				}
			}
		})


	})


</script>
