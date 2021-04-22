<header class="sticky-top">


    <nav class="nav navbar-dark bg-dark border-bottom border-success navbar-expand-lg justify-content-between">
        <div class=" p-2">
            <img src="/img/jagu.png" alt="LOGO" size="15">
            <a class="navbar-brand" style="font-family: 'Calibri',serif; font-size: 100%; font-style: oblique" title="
<?=SITE_DESCRIPTION
            ?>" href="/"><?=SITE_NAME?></a><br>
        </div>
        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">


        <ul class="navbar-nav">
            <!--Menu-->
            <? if(isAuthUser())
            require_once $_SERVER['DOCUMENT_ROOT'].'/Modules/'.isAuthUser().'/menu.php';
            ?>
        </ul>




        </div>
            <?
            $db = db_connect();
            if($db == NULL)
                exit();
          switch (isAuthUser())
          {
              case 'teacher':
              case 'admin':
              {

                  $query = "Select TP_BrieflyName As Name from teacherprofile where TP_UserID = :UserID";

                  $stmp = $db->prepare($query);
                  $stmp->execute(Array('UserID'=>$_SESSION[$_COOKIE['jagu_user_key']]['UserID']));

                  $HeadUserName = $stmp->fetch()['Name'];?>


            <?
                  break;
              }
              case 'student':
              {
                  $query = "Select SP_BrieflyName As Name from studentprofile where SP_id = :UserID";

                  $stmp = $db->prepare($query);
                  $stmp->execute(Array('UserID'=>$_SESSION[$_COOKIE['jagu_user_key']]['UserID']));

                  $HeadUserName = $stmp->fetch();
                  break;
              }

          }
          // Если пользователь авторизован, то ему доступна кнопка выход
if(isAuthUser()){
            ?>

    <div class="dropdown nav-item mt-2">
        <a class="nav-link text-white dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?=$HeadUserName;?>
        </a>
        <div class="dropdown-menu dropdown-menu-lg-left dropdown-menu-right" aria-labelledby="dropdownMenuButton">
            <a href="/UserSetting.php" class="dropdown-item ">
               Настройки
            </a>
            <hr/>
            <a class="dropdown-item text-danger" href="/logout.php?logout=true">Выход</a>
        </div>
    </div>




            <? }?>







    </nav>




</header>
