<?php
// API: Добавление нового студента через управление академ. группой

require_once($_SERVER['DOCUMENT_ROOT'].'/cfg/core.php');
if (empty($_POST) || isAuthUser() == 'student')
    exit(json_encode('Ошибка данных или авторизации'));

$Surname = $_POST['Surname'];
$Name = $_POST['Name'];
$MiddleName = $_POST['MiddleName'];
$BrieflyName = $_POST['BrieflyName'];
$Gender = $_POST['Gender'];
$DateOfBirth = $_POST['DateOfBirth'];
$TypeOfStudy = $_POST['TypeOfStudy'];
$NumberBook = $_POST['NumberBook'];
$AGCode = $_POST['AGCode'];
$Email = $_POST['Email'];
$Login = $_POST['Login'];

