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

<div id="mdAddLesson">
	<!--THIS IS IMPORTANT! to close the modal, the class name has to match the name given on the ID  class="close-animatedModal" -->
	<div class="close-mdAddLesson">
		X
	</div>

	<div class="modal-content">
		<!--Your modal content goes here-->
	</div>
</div>

<script>
	$("#btnAddLesson").click(function () {
		//alert("Test");
		$.sweetModal({
			title: "Добавить занятие",
			content: '<form>' +
					'</form>',
			theme: $.sweetModal.THEME_MIXED
		});

	})

	//$("#btnAddLesson").animatedModal({
	//	color: "#45b8d5"
	//});

</script>