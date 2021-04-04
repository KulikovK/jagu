<?php require_once($_SERVER['DOCUMENT_ROOT']."/cfg/core.php");
if(isAuthUser() != 'admin')
    Header("Location: /");

define("ADMIN", "");
$Page_Title = "Администратор"?>
<html lang="ru">
<head>
    <? require_once($_SERVER['DOCUMENT_ROOT']."/template/head.php"); ?>
</head>

<body class="">
<? require_once($_SERVER['DOCUMENT_ROOT']."/template/top.php");?>
<main id="AdminMain" class="p-2 m-2">
    <!--Блок уведомлений об операции-->
    <div class="alert fixed-top bg-dark" title="Нажмите на данное сообщение, чтобы закрыть его." id="messageInfo" style="display: none" role="alert">
        <h5 id="messageInfoTitle"></h5>
        <div class="" id="messageInfoText"></div>
    </div>

    <?
    /*if(isset($_GET['action']) And $_GET['action']=='add') {
        require_once("add_user.php");
       exit();
    }*/

    switch ($_GET['page'])
    {
        case 'Users':{
            require_once("Users.php");
            break;
        }
        case 'AcademicGroups':
        {
            require_once("AcademicGroups.php");
            break;
        }
        default:{
            require_once("attendance.php");
        }


    }

    ?>

</main>

<? require_once($_SERVER['DOCUMENT_ROOT']."/template/footer.php");?>
</body>
</html>

<script>
    $("#messageInfo").click(function (){
        $('#messageInfo').fadeOut();
    });
</script>