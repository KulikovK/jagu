<?php
/*
 * Copyright (c) 2021. Kulikov K. P. [kostj1998.10.13@yandex.ru]
 */

//API: формирование файла отчета

if (empty($_POST))
    exit('Empty post!');

const MONTH = [
    9 => "СЕНТЯБРЬ",
    10 => "ОКТЯБРЬ",
    11 => "НОЯБРЬ",
    12 => 'ДЕКАБРЬ',
    1 => 'ЯНВАРЬ',
    2 => "ФЕВРАЛЬ",
    3 => "МАРТ",
    4 => "АПРЕЛЬ",
    5 => "МАЙ",
    6 => "ИЮНЬ"

];

require_once $_SERVER["DOCUMENT_ROOT"] . '/cfg/core.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\{Font, Border, Alignment};
use PhpOffice\PhpSpreadsheet\Style\Borders;

$QueryTeacherInfo = "SELECT CONCAT(TP_Surname, ' ', TP_Name,' ', TP_MiddleName) AS FIO,
       d.DEP_Name AS Departaments,
       f.FCT_name AS Faculty,
       a.AD_Abbreviation AS Degree,
       a2.AT_name AS Title
FROM teacherprofile 
JOIN departments d ON teacherprofile.TP_Department = d.DEP_id
JOIN faculties f ON d.DEP_Faculty_id = f.FCT_id
JOIN academicdegree a ON teacherprofile.TP_Degree = a.AD_id
JOIN academictitle a2 ON teacherprofile.TP_AcademicTitle = a2.AT_id

WHERE TP_UserID = :TeacherID";

$TeacherInfo = array();

try {
    $db = db_connect();

    $stmp = $db->prepare($QueryTeacherInfo);
    $stmp->execute(['TeacherID' => $_POST['TeacherID']]);

    $TeacherInfo = $stmp->fetch(PDO::FETCH_ASSOC);

    if (!$TeacherInfo)
        exit("Teacher info empty!");


    $ArrayData = array();
    $ArrayData = $_POST;
    $RESPONSE_AJAX['success'] = false;

    $QueryReports = "SELECT 
       DATE_FORMAT(LI_date, '%d.%m.%y') AS date,
      CONCAT(DATE_FORMAT(l.LN_StartTime, '%H:%i'), '-', DATE_FORMAT(l.LN_EndTime, '%H:%i')) AS HoursLesson,
       f.FCT_Abbreviation AS Faculty,
       a.AG_NumCuorse AS Course, 
       a.AG_Code AS AGCode,
       LI_LessonTopic AS Topic,
       SL_TypeLesson_code AS TypeLesson,
       LI_CountHours AS CountHours
     
       
       FROM lessoninfo
JOIN studyload s ON s.SL_Id = lessoninfo.StudyLoad_id
JOIN lessonnumber l ON lessoninfo.LI_LessonNumber_id = l.LN_Number
JOIN academicgroups a ON s.SL_AcademGroup_code = a.AG_Code
JOIN specialtylist s2 ON a.AG_specialty = s2.SL_id
JOIN faculties f ON s2.SL_Faculty_id = f.FCT_id
WHERE s.SL_Teacher_id = :TeacherID AND EXTRACT(MONTH FROM LI_date) = :Month
ORDER BY date, LI_LessonNumber_id";


    $stmp = $db->prepare($QueryReports);

    $stmp->execute([
        'TeacherID' => $_POST['TeacherID'],
        'Month' => $_POST['Month']
    ]);

    $Result = $stmp->fetchAll(PDO::FETCH_ASSOC);

    if (!$Result)
        exit(json_encode($RESPONSE_AJAX));

    /*      $RESPONSE_AJAX['data']=$Result;
          $RESPONSE_AJAX['success']=true;*/


} catch (PDOException $exception) {
    $RESPONSE_AJAX['info'] = $exception->getMessage();
    exit(json_encode($RESPONSE_AJAX));
}


$spreadSheet = new Spreadsheet();

$workSheet = $spreadSheet->getActiveSheet();
$workSheet->setTitle('Месяц');
$workSheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
$workSheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
$workSheet->getPageSetup()->setFitToWidth(1);
$workSheet->getPageSetup()->setFitToHeight(0);

$workSheet->calculateColumnWidths();


$workSheet->mergeCells('A1:F1');
$workSheet->mergeCells('A2:F2');
$workSheet->setCellValue("A1", "Тульский государственный педагогический");
$workSheet->setCellValue('A2', 'университет им. Л.Н. Толстого');

$workSheet->mergeCells('I1:N1');
$workSheet->mergeCells('I2:N2');
$workSheet->mergeCells('Q1:R1');
$workSheet->setCellValue('I1', "УТВЕРЖДЕНА");
$workSheet->setCellValue('I2', "Министерством образования РФ 24.01.98 г.");
$workSheet->setCellValue('Q1', 'Форма №2');

$workSheet->getStyle('A1:F2')->applyFromArray([
    'font' => [
        'name' => 'Times New Roman',
        'bold' => true,
        'size' => '10'
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
        'wrapText' => true,
    ]
]);

$workSheet->getStyle("I1:N2")->getAlignment()
    ->setVertical(Alignment::VERTICAL_CENTER)
    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

$workSheet->getStyle('Q1:R1')->getAlignment()
    ->setVertical(Alignment::VERTICAL_CENTER)
    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

$workSheet->getStyle('A1:R2')->getFont()
    ->setSize(10)
    ->setName('Times New Roman');

$workSheet->mergeCells("A3:R3");
$workSheet->mergeCells("A4:R4");
$workSheet->mergeCells("A5:R5");
$workSheet->setCellValue('A3', "МЕСЯЧНАЯ ВЕДОМОСТЬ");
$workSheet->setCellValue("A4", "учета работы профессорско-преподавательского состава");
$workSheet->setCellValue("A5", "за " . MONTH[$_POST['Month']] . " " . date("Y") . " г.");

$workSheet->getStyle('A3:R5')
    ->getAlignment()
    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
    ->setVertical(Alignment::VERTICAL_CENTER);
$workSheet->getStyle("A3:R5")->getFont()
    ->setSize(12)
    ->setName('Times New Roman')
    ->setBold(true);

$workSheet->mergeCells('A6:B6');
$workSheet->mergeCells("C6:F6");
$workSheet->mergeCells('A7:F7');

$workSheet->setCellValue('A6', "Факультет");
$workSheet->setCellValue('C6', $TeacherInfo['Faculty']);
$workSheet->getStyle('C6:F6')->getFont()->setBold(true)->setName('Times New Roman')->setSize(12)->setItalic(true);
$workSheet->setCellValue('A7', "Ученое звание и степень");
$workSheet->mergeCells("I6:J6");
$workSheet->setCellValue("I6", "Кафедра");
$workSheet->getStyle('I6')->getFont()->setName('Times New Roman')->setSize(12);
$workSheet->getStyle('A6:A7')->getFont()->setName('Times New Roman')->setSize(12);

$workSheet->mergeCells('K6:R6');
$workSheet->setCellValue('K6', $TeacherInfo['Departaments']);
$workSheet->getStyle('K6')
    ->getFont()
    ->setName('Times new Roman')
    ->setSize(12)
    ->setBold(true)
    ->setItalic(true);

$workSheet->mergeCells('I7:R7');
$workSheet->setCellValue("I7", $TeacherInfo["Degree"] . ', ' . $TeacherInfo['Title'] . ', ' . $TeacherInfo['FIO']);
$workSheet->getStyle('I7')->getFont()->setItalic(true)
    ->setBold(true)
    ->setSize(12)
    ->setName('Times New Roman');

$workSheet->mergeCells('A8:A9');
$workSheet->mergeCells('B8:B9');
$workSheet->mergeCells('C8:C9');
$workSheet->mergeCells('D8:D9');
$workSheet->mergeCells('E8:E9');
$workSheet->mergeCells('F8:F9');
$workSheet->mergeCells('R8:R9');
$workSheet->mergeCells("G8:Q8");


$workSheet->setCellValue("A8", "Дата");
$workSheet->setCellValue("B8", "Часы занятий");
$workSheet->setCellValue("C8", "Факультет");
$workSheet->setCellValue("D8", "Курс");
$workSheet->setCellValue("E8", "Группа");
$workSheet->setCellValue("F8", "Содержание занятий");

$workSheet->setCellValue("G8", "Количество выполненных часов по видам занятий");

$workSheet->setCellValue("G9", "Лекции");
$workSheet->setCellValue("H9", "Практ. занятия");
$workSheet->setCellValue("I9", "Консультации");
$workSheet->setCellValue("J9", "Зачеты");
$workSheet->setCellValue("K9", "Экзамены");
$workSheet->setCellValue("L9", "Руков. пед. практик.");
$workSheet->setCellValue("M9", "Руков. курс. и дипл.раб");
$workSheet->setCellValue("N9", "Вычис-лит. практ.");
$workSheet->setCellValue("O9", "КР");
$workSheet->setCellValue("P9", "КСРС");
$workSheet->setCellValue("Q9", "ИГА");
$workSheet->setCellValue('R8', "Подпись преподавателя");

$workSheet->getStyle("A8:R9")->getFont()
    ->setName("Times New Roman")
    ->setSize(9);
$workSheet->getStyle('A8:R9')->getAlignment()->setWrapText(true)
    ->setVertical(Alignment::VERTICAL_CENTER)
    ->setHorizontal(Alignment::HORIZONTAL_CENTER);


//$workSheet->getColumnDimension("A")->setWidth(5.3);

$BeginCol = 10;


//$workSheet->fromArray($Result, null, "A10");


foreach ($Result as $item) {
    $workSheet->setCellValue('A' . $BeginCol, $item['date']);
    $workSheet->setCellValue('B' . $BeginCol, $item['HoursLesson']);
    $workSheet->setCellValue('C' . $BeginCol, $item['Faculty']);
    $workSheet->setCellValue('D' . $BeginCol, $item['Course']);
    $workSheet->setCellValue('E' . $BeginCol, $item['AGCode']);
    $workSheet->setCellValue('F' . $BeginCol, $item['Topic']);

    $Row = "G";
    switch ($item['TypeLesson']) {
        case 'ЛК':
        {
            $Row = 'G';
            break;
        }
        case "ПЗ":
        {
            $Row = 'H';
            break;
        }
        case "Конс.":
        {
            $Row = 'I';
            break;
        }
        case "Зач.":
        {
            $Row = 'J';
            break;
        }
        case "Экз.":
        {
            $Row = 'K';
        }
    }

    $workSheet->setCellValue($Row . $BeginCol, $item['CountHours']);


    $BeginCol++;
}

$workSheet->setCellValue("F" . $BeginCol, "ИТОГО за " . MONTH[$_POST['Month']]);
$workSheet->getStyle("F" . $BeginCol)->getFont()
    ->setName('Times New Roman')
    ->setSize(9)
    ->setBold(true);

$workSheet->getStyle("A10:R" . $BeginCol)->getFont()
    ->setSize(9)
    ->setName('Times New Roman');
$workSheet->getStyle("A10:R" . $BeginCol)->getAlignment()
    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
    ->setVertical(Alignment::VERTICAL_CENTER)
    ->setWrapText(true);

$workSheet->getStyle("F10:F" . $BeginCol)->getAlignment()
    ->setHorizontal(Alignment::HORIZONTAL_LEFT);

foreach (range('G', 'R') as $columnID) {
    $SumRange = $columnID . '10:' . $columnID . ($BeginCol - 1);
    $workSheet->setCellValue($columnID . $BeginCol, "=SUM($SumRange)");
    $workSheet->getStyle($columnID . $BeginCol)->getFont()
        ->setName('Times New Roman')
        ->setSize(9);
}

$borderStyleArray = array(
    'borders' => array(
        'outline' => array(
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => array('rgb' => '000000'),
        ),
        'horizontal' => array(
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => array('rgb' => '000000'),
        ),
        'vertical' => array(
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => array('rgb' => '000000'),
        ),
    ),
);

$workSheet->getStyle('A8:R' . $BeginCol)->applyFromArray($borderStyleArray);


foreach (range('G', 'Q') as $columnID) {
    $workSheet->getColumnDimension($columnID)
        ->setWidth(6);
}

$workSheet->getColumnDimension("F")->setWidth(20.4);


$BeginCol += 2;


$workSheet->setCellValue('C' . $BeginCol, "Декан факультета");
$workSheet->setCellValue("G" . $BeginCol, "Зав. кафедрой");


try {
    /*$writer = new Xlsx($spreadSheet);
    $writer->save('hello.xlsx');*/

    $filename = 'Месячная ведомость ' . $TeacherInfo['FIO'] . '.xlsx';
    $writer = new Xlsx($spreadSheet);
    $writer->save($filename);


    $RESPONSE_AJAX['Data'] = "API/" . $filename;
    $RESPONSE_AJAX['success'] = true;

    exit(json_encode($RESPONSE_AJAX));


} catch (PhpOffice\PhpSpreadsheet\Writer\Exception $e) {
    echo $e->getMessage();
}
