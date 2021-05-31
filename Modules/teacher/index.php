<?php
/*
 * Copyright (c) 2021. Kulikov K. P. [kostj1998.10.13@yandex.ru]
 */


require_once $_SERVER['DOCUMENT_ROOT'] . '/cfg/core.php';

if (isAuthUser() != 'teacher')
	Header("Location: /");

define("TEACHER", "");
$Page_Title = 'Преподаватель';
?>

<html lang="ru">
<head>
	<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/template/head.php"); ?>
</head>

<body class="bg-dark">
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/template/top.php"); ?>

<main id="TeacherMain" class="p-2 m-2">
	<?php
	switch ($_GET['page']) {
		case 'journal':
		{
			require_once 'journal.php';
			break;
		}
		case 'reports':
		{
			require_once 'reports.php';
			break;
		}

		default:
		{
			require_once "home.php";
		}
	}

	?>
</main>

<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/template/footer.php"); ?>
<script src="js/script.js"></script>
</body>
</html>

