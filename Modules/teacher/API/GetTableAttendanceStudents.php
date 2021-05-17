<?php
/*
 * Copyright (c) 2021. Kulikov K. P. [kostj1998.10.13@yandex.ru]
 */

//API: получение таблицы посещаемости студентов

if (empty($_POST))
	exit('<p class="alert alert-danger">Пустой запрос недопустим!</p>');

require_once $_SERVER['DOCUMENT_ROOT'] . '/cfg/core.php';
$AGCode = $_POST['AGCode'];
$Discipline = $_POST['Discipline'];
$Teacher = $_POST['Teacher'];

$LessonListQuery = "SELECT LI_id AS LessonID, LI_date AS date, s.SL_TypeLesson_code AS TypeLesson FROM lessoninfo
JOIN studyload s ON lessoninfo.StudyLoad_id = s.SL_Id
WHERE s.SL_AcademGroup_code = :AGCode AND s.SL_DISC_id = :Discipline ORDER BY LI_date";

try {
	$db = db_connect();
	$stmp = $db->prepare($LessonListQuery);
	$stmp->execute([
			'AGCode' => $AGCode,
			'Discipline' => $Discipline,
	]);

	$LessonList = $stmp->fetchAll(PDO::FETCH_ASSOC);

	if (!$LessonList)
		exit("<p class='alert-success alert'>Нет данных</p>");

	$StudentListQuery = "SELECT SP_id AS ID, CONCAT(SP_Surname, ' ', SP_Name, ' ', SP_MiddleName) AS FIO FROM studentprofile WHERE SP_AcademGroup_id = :AGCode";

	$stmp = $db->prepare($StudentListQuery);
	$stmp->execute(['AGCode' => $AGCode]);

	$StudentList = $stmp->fetchAll(PDO::FETCH_ASSOC);
	?>
	<a id="ShowHelpToAttendanceTable" href="#">Подсказка</a>
	<div id="HelpToAttendanceTable" class="m-2" style="display: none">
		<div class="row">
			<div class="table-danger col-sm-2 ">Пропущено 2 часа</div>
			<div class="table-warning col-sm-2 ">Пропущено 1 час</div>
		</div>
		<div class="row">
			<div class="table-success col-sm-2 ">Нет пропусков</div>
			<div class="table-secondary col-sm-4 ">Нет данных/студент в другой подгруппе</div>
		</div>
	</div>

	<table id="AttendanceTable" class="table table-sm table-responsive table-hover table-bordered">
		<thead class="thead-light text-sm-center">
		<tr>
			<th>Студенты</th>
			<?php
			foreach ($LessonList as $row)
				echo "<th class=''>" . date('d.m.y', strtotime($row['date'])) . "</br>" . $row['TypeLesson'] . "</th>"
			?>
			<th>Пропусков</th>
			<th>Баллы</th>
		</tr>

		</thead>


		<?php
		foreach ($StudentList as $row) {
			echo "<tr class='text-center'>
<td class='bg-light'>" . $row['FIO'] . "</td>";

			$GlobalGrande = 0;
			$GlobalAttendance = 0;

			foreach ($LessonList as $item) {
				$query = "SELECT AL_NumberHours AS NumberHours, AL_LessonGrande AS Grande, AL_Coments AS Comment FROM attendancelesson WHERE AL_LessonInfo_id = :LessonID AND AL_Student_id = :StudentID";
				$stmp = $db->prepare($query);
				$stmp->execute(['LessonID' => $item['LessonID'], 'StudentID' => $row['ID']]);

				$Att = $stmp->fetch(PDO::FETCH_ASSOC);

				if ($Att) {
					echo sprintf("<td onclick='ShowEditAttendance(%s, %s)' class='%s' ><i>%s</i></td>", $item['LessonID'], $row['ID'], $Att['NumberHours'] == 2 ? 'table-danger' : ($Att['NumberHours'] == 1 ? 'table-warning' : 'table-success'), $Att['Grande']);
					$GlobalAttendance += $Att['NumberHours'];
					$GlobalGrande += $Att['Grande'];
				} else
					echo "<td class='table-secondary'>-</td>";

			}
			?>
			<td><?=
				$GlobalAttendance
				?></td>

			<td>
				<?=
				$GlobalGrande
				?>
			</td>

			<?php
			echo "</tr>";
		}
		?>


	</table>

	<script>
		$("#AttendanceTable").dataTable({
			processing: true,
			language: {
				url: "//cdn.datatables.net/plug-ins/1.10.22/i18n/Russian.json",
			}
		});


		$("#ShowHelpToAttendanceTable").click(function () {
			$("#HelpToAttendanceTable").slideToggle();
		});

		function ShowEditAttendance(LessonID, StudentID) {
			alert(LessonID + "\n" + StudentID);
		}
	</script>


	<?php
} catch (PDOException $exception) {
	exit("<p class='alert alert-danger'>Ошибка запроса. Код:" . $exception->getCode() . " </p>");
}
