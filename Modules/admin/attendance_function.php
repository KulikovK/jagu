<?php
 //defined("ADMIN") or die("Доступ закрыт!");
require_once($_SERVER['DOCUMENT_ROOT'].'/cfg/core.php');
if (isset($_POST['AcademicGroups']) and isset($_POST['DateOfStudy']))
{    $Date = date("Y-m-d", strtotime($_POST['DateOfStudy']));


$db = db_connect();
    $query = "select l.LI_LessonNumber_id As NumberLesson,
       l2.LN_StartTime As LessonStart,
       l2.LN_EndTime As LessonEnd,
       d.DISC_name As DisciplineName, 
       t.TP_BrieflyName As Teacher,
       t2.TL_Name As TypeLesson, 
       l.LI_LessonTopic As Themes,
       COUNT(*) As CountStudy
from attendancelesson
join lessoninfo l on attendancelesson.AL_LessonInfo_id = l.LI_id
join discipline d on d.DISC_id = l.LI_Discipline_id
join teacherprofile t on l.LI_Teacher = t.TP_UserID
join typelesson t2 on l.LI_TypeLesson_id = t2.TL_id
join lessonnumber l2 on l.LI_LessonNumber_id = l2.LN_Number
where l.LI_AcademGroup_code=:AG_Code And l.LI_date = :LessonDate
group by d.DISC_id, l.LI_TypeLesson_id";
        $stmp = $db->prepare($query);
    $stmp->execute(Array('AG_Code'=>$_POST['AcademicGroups'], 'LessonDate'=>$Date));

    $DataAnyLesson = $stmp->fetchAll();

    $query = "select  COUNT(*) As Count from attendancelesson
join lessoninfo l on attendancelesson.AL_LessonInfo_id = l.LI_id
join discipline d on d.DISC_id = l.LI_Discipline_id
where l.LI_AcademGroup_code= :AG_Code And l.LI_date = :LessonDate And AL_NumberHours = 0
group by d.DISC_id, l.LI_TypeLesson_id";

    $stmp = $db->prepare($query);
    $stmp->execute(Array('AG_Code'=>$_POST['AcademicGroups'], 'LessonDate'=>$Date));



    if(!$DataAnyLesson){
        ?>
        <p class="text-info h5" style="text-align: center">Информация о посещаемости занятий в группе
            <strong>
                <?=$_POST['AcademicGroups'];?>
            </strong>
            за
            <strong>
                <?= date('d.m.Y', strtotime($_POST['DateOfStudy']));?>
            </strong>
            не найдена!
        </p>
<?php
    }else
    {

        ?>

<p class="h5" style="text-align: center">Информация о посещаемости занятий в группе
    <strong>
        <?=$_POST['AcademicGroups'];?>
    </strong>
    от
    <strong>
        <?= date('d.m.Y', strtotime($_POST['DateOfStudy']));?>
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

        foreach ($DataAnyLesson as $row)
            {
                echo '<tr>';
                echo '<td>';
                echo $row['NumberLesson']. '<br><i>'.date("H:i",strtotime($row['LessonStart'])).'-'.date("H:i",strtotime($row['LessonEnd'])).'</i>';
                echo '</td>';

                echo '<td>';
                echo $row['DisciplineName'];
                echo '</td>';

                echo '<td>';
                echo $row['Teacher'];
                echo '</td>';

                echo '<td>';
                echo $row['TypeLesson'].'<br><i>Тема: '.$row['Themes']. '</i>';
                echo '</td>';

                echo '<td>';
                echo $row['CountStudy'];
                echo '</td>';

                echo '<td>';
                echo $stmp->fetch()['Count'];
                echo '</td>';

                echo '</tr>';

            }

    }

?>
</table>
<?php

//echo $_POST['AcademicGroups']. ' ,'.$_POST['DateOfStudy'];



    }else
        echo "Выберите группу и дату"
    ?>
