<?php
/*
 * Copyright (c) 2021. Kulikov K. P. [kostj1998.10.13@yandex.ru]
 */

//API: запись информации о посещаемости

if (empty($_POST))
	exit('empty post!');

require_once $_SERVER['DOCUMENT_ROOT'] . '/cfg/core.php';

try {

	$db = db_connect();
	$StudentsList = array();
	////Если не выбрана подгруппа
	if ($_POST['Subgroups'] == 0) {
		$queryStudentList = "SELECT SP_id AS ID, CONCAT(SP_Surname, ' ', SP_Name, ' ', SP_MiddleName) AS FIO
FROM studentprofile WHERE SP_AcademGroup_id = :AGCode ORDER BY FIO";

		$stmp = $db->prepare($queryStudentList);

		$stmp->execute(['AGCode' => $_POST['AGCode']]);

		$StudentsList = $stmp->fetchAll(PDO::FETCH_ASSOC);

		if (!$StudentsList)
			exit('Student List empty!');

		$tabe = "<table id='WriteAttendanceTable' class='table table-hover table-bordered'><thead><tr><th hidden></th><th>Студенты</th>" .
				"<th>Пропущено(час)</th>" .
				"<th>Баллы</th>" .
				"<th>Комментарий</th>" .
				"</tr></thead><tbody>";

		foreach ($StudentsList as $item) {
			$tabe .= "<tr><td hidden>" . $item['ID'] . "</td><td>" . $item['FIO'] . "</td>" .
					"<td><input class='form-control' name='AttendaneHours' type='number' min='0' max='2' value='0'></td>" .
					"<td><input class='form-control' name='LessonGrande' type='number' value='0'></td>" .
					"<td><input class='form-control' name='Commetnts' type='text'></td>" .
					"</tr>";

		}
		$tabe .= "</tbody></table>";

		echo(($tabe));

	}


} catch (PDOException $exception) {
	exit(($exception->getMessage()));
}

?>

<script>
	$("#WriteWriteAttendanceTable tbody tr td input").change(function (e) {
		if (e.val() == 2) {
			e.prop("background", "#e52c2c");
		}
	});

	$("#WriteAttendanceTable").dataTable({
		ordering: false
	});

</script>
