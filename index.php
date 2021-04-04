<?php require_once("cfg/core.php");
if(isAuthUser()) {
    RedirectUser();
    exit();
}

require_once("template/auth_function.php");
$Page_Title = "Авторизация"

?>



<html lang="ru">
<head>
    <? require_once("template/head.php"); ?>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>
<? require_once("template/top.php"); ?>

<? require_once ("template/auth.php");?>

<? require_once("template/footer.php");?>
</body>
</html>
