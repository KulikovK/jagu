<?php
/*
 * Copyright (c) 2021. Kulikov K. P. [kostj1998.10.13@yandex.ru]
 */

 //defined("ADMIN") or die("Доступ закрыт!");
require_once($_SERVER['DOCUMENT_ROOT'].'/cfg/core.php');
if (isset($_POST['AcademicGroups']) and isset($_POST['DateOfStudy']))
{
	$Date = date("Y-m-d", strtotime($_POST['DateOfStudy']));


	try {
		$db = db_connect();
		$query = "Select l.LN_Number As NumberLesson,
       l.LN_StartTime As LessonStart,
       l.LN_EndTime As LessonEnd,
       d.DISC_name As DisciplineName,
       CONCAT(t.TP_Surname, ' ', t.TP_Name, ' ', t.TP_MiddleName) As Teacher,
       t2.TL_Name As TypeLesson,
       LI_LessonTopic As Themes,
       (Select COUNT(*) from attendancelesson WHERE AL_LessonInfo_id = lessoninfo.LI_id) As CountStudents,
       (Select Count(*) FROM attendancelesson WHERE AL_LessonInfo_id = lessoninfo.LI_id AND (AL_NumberHours = 2)) As AttenStudents
from lessoninfo
join studyload s ON lessoninfo.StudyLoad_id = s.SL_Id
join discipline d ON s.SL_DISC_id = d.DISC_id
join teacherprofile t ON s.SL_Teacher_id = t.TP_UserID
join typelesson t2 ON s.SL_TypeLesson_code = t2.TL_id
join lessonnumber l ON lessoninfo.LI_LessonNumber_id = l.LN_Number
WHERE s.SL_AcademGroup_code = :AGCode And LI_date = :LessonDate
";
		$stmp = $db->prepare($query);
		$stmp->execute(array('AGCode' => $_POST['AcademicGroups'], 'LessonDate' => $Date));

		$DataAnyLesson = $stmp->fetchAll();


		if (!$DataAnyLesson) {
			?>
			<p class="text-info h5" style="text-align: center">Информация о посещаемости занятий в группе
				<strong>
					<?= $_POST['AcademicGroups']; ?>
				</strong>
				за
				<strong>
					<?= date('d.m.Y', strtotime($_POST['DateOfStudy'])); ?>
				</strong>
				не найдена!
			</p>
			<?php
		} else {

			?>

			<p class="h5" style="text-align: center">Информация о посещаемости занятий в группе
				<strong>
					<?= $_POST['AcademicGroups']; ?>
				</strong>
				от
				<strong>
					<?= date('d.m.Y', strtotime($_POST['DateOfStudy'])); ?>
				</strong>
			</p>
			<table border="" style="margin: auto; border-style: dashed" class="table table-bordered table-responsive-lg table-hover table-fixed">
			<thead class="thead-dark">

			<tr class="text-center">
				<th style="top: 0" class=" position-sticky">Номер пары</th>
				<th style="top: 0" class=" position-sticky">Дисциплина</th>
				<th style="top: 0" class=" position-sticky">Преподаватель</th>
				<th style="top: 0" class=" position-sticky">Тип занятия</th>
				<th style="top: 0" class=" position-sticky">Всего студентов</th>
				<th style="top: 0" class=" position-sticky">Отсутсвует</th>
			</tr>
			</thead>
			<?php

			foreach ($DataAnyLesson as $row) {
				echo '<tr>';
				echo '<td>';
				echo $row['NumberLesson'] . '<br><i>' . date("H:i", strtotime($row['LessonStart'])) . '-' . date("H:i", strtotime($row['LessonEnd'])) . '</i>';
				echo '</td>';

				echo '<td>';
				echo $row['DisciplineName'];
				echo '</td>';

				echo '<td>';
				echo $row['Teacher'];
				echo '</td>';

				echo '<td>';
				echo $row['TypeLesson'] . '<br><i>Тема: ' . $row['Themes'] . '</i>';
				echo '</td>';

				echo '<td>';
				echo $row['CountStudents'];
				echo '</td>';

				echo '<td>';
				echo $row['AttenStudents'];
				echo '</td>';

				echo '</tr>';

			}

		}
	} catch (PDOException $exception) {
		echo "<p class='alert alert-danger'>" . $exception->getMessage() . "</p>";
	}

?>
</table>
<?php

//echo $_POST['AcademicGroups']. ' ,'.$_POST['DateOfStudy'];



    }else
        echo "Выберите группу и дату"
    ?>
