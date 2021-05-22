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

//exit(json_encode($_POST['ShowAllLesson']));

$LessonListQuery = "SELECT LI_id AS LessonID, LI_date AS date, s.SL_TypeLesson_code AS TypeLesson, LI_LessonTopic As Topic FROM lessoninfo
JOIN studyload s ON lessoninfo.StudyLoad_id = s.SL_Id " .
		"WHERE s.SL_AcademGroup_code = :AGCode AND s.SL_DISC_id = :Discipline" . ($_POST['TypeLesson'] != '0' && $_POST['TypeLesson'] != '' ? " And s.SL_TypeLesson_code = :TypeLessonID " : "") . ($_POST['ShowAllLesson'] == '1' ? " And SL_Teacher_id = :TeacherID " : "") .
		" ORDER BY LI_date, LI_LessonNumber_id";

//exit($LessonListQuery);

try {
	$db = db_connect();
	$stmp = $db->prepare($LessonListQuery);


	$ArryaQuery = [
			'AGCode' => $AGCode,
			'Discipline' => $Discipline,
	];

	if ($_POST['TypeLesson'])
		$ArryaQuery['TypeLessonID'] = $_POST['TypeLesson'];

	if ($_POST['ShowAllLesson'])
		$ArryaQuery['TeacherID'] = $Teacher;

//	exit(json_encode($ArryaQuery));

	$stmp->execute($ArryaQuery);

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


	<table id="AttendanceTable" class="table table-bordered table-info table-hover" style="width: 100%">
		<thead class="text-center border border-dark">

		<tr>
			<th class="">Студенты</th>
			<?php
			foreach ($LessonList as $row)
				echo "<th title='Нажмите чтобы редактировать' onclick='ShowEditLesson(" . $row['LessonID'] . ")' style='cursor: pointer' class='no-sort btn-sm btn-outline-info'>" . date('d.m.y', strtotime($row['date'])) . "<hr>" . $row['TypeLesson'] . "</th>"
			?>
			<th class="">Пропущено<br> часов</th>
			<th class="">Баллы</th>
		</tr>

		</thead>


		<?php
		foreach ($StudentList as $row) {
			echo "<tr class='text-sm-left'>
<td class=''>" . $row['FIO'] . "</td>";

			$GlobalGrande = 0;
			$GlobalAttendance = 0;

			foreach ($LessonList as $item) {
				$query = "SELECT AL_NumberHours AS NumberHours, AL_LessonGrande AS Grande, AL_Coments AS Comment FROM attendancelesson WHERE AL_LessonInfo_id = :LessonID AND AL_Student_id = :StudentID";
				$stmp = $db->prepare($query);
				$stmp->execute(['LessonID' => $item['LessonID'], 'StudentID' => $row['ID']]);

				$Att = $stmp->fetch(PDO::FETCH_ASSOC);

				if ($Att) {
					echo sprintf("<td onclick='' class='%s text-center' ><i>%s (%s)</i></td>", $Att['NumberHours'] >= 2 ? 'table-danger' : ($Att['NumberHours'] == 1 ? 'table-warning' : 'table-success'), $Att['Grande'], $Att['NumberHours'] == 2 ? 'Н/б' : ($Att['NumberHours'] == 1 ? 'Опздл' : 'Был'));
					$GlobalAttendance += $Att['NumberHours'];
					$GlobalGrande += $Att['Grande'];
				} else
					echo "<td class='table-secondary'></td>";

			}
			?>
			<td class="text-center"><?=
				$GlobalAttendance
				?></td>

			<td class="text-center">
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
		$("#AttendanceTable").DataTable({

			select: 'single',
			ordering: true,

			language: {
				url: "//cdn.datatables.net/plug-ins/1.10.22/i18n/Russian.json",
			},
			dom: 'ftB',
			scrollY: false,
			scrollX: true,
			scrollCollapse: true,
			paging: false,
			fixedColumns: {
				leftColumns: 1,
				rightColumns: 2
			},

			aoColumnDefs: [
				{'bSortable': false, 'aTargets': ['no-sort']}
			]
		});


		$("#ShowHelpToAttendanceTable").click(function () {
			$("#HelpToAttendanceTable").slideToggle();
		});


	</script>


	<?php
} catch (PDOException $exception) {
	exit("<p class='alert alert-danger'>Ошибка запроса. Код:" . $exception->getMessage() . " </p>");
}
