<?php defined('ADMIN') or die("Доступ закрыт!");
/*
 * Copyright (c) 2021. Kulikov K. P. [kostj1998.10.13@yandex.ru]
 * Project: JAGU
 * Module:
 * Submodule:
 * Description:
 * Version:
 */

?>

<div class="card">
    <div class="card-header">
        <h5 class="text-center">Посещаемость занятий</h5>


        <form class="form-inline justify-content-center" id="formFindAttendance" action="" method="post">
            <div class="form-group mr-sm-2">

                <label for="AcademicGroups" class="mr-sm-2">Группа</label>
                <label>
                    <select class="form-control" id="AcademicGroups" name="AcademicGroups">
                        <?
                        $db = db_connect();
                        $query = "Select AG_Code, AG_NumCuorse, f.FOS_Name from academicgroups join formatofstudy f on f.FOS_id = academicgroups.AG_FormOfStudy";


                        foreach ($db->query($query) as $AG_List){?>
                        <option data-toggle="tooltip" data-placement="bottom" <? if($_POST['AcademicGroups'] == $AG_List['AG_Code'])  echo 'selected'; ?>
                            title="<?=$AG_List['AG_NumCuorse'].' курс, '.$AG_List['FOS_Name'].' форма обучения';?>">
                            <?=$AG_List['AG_Code'];?>
                            <?}
                            ?>
                    </select>


                </label>
            </div>
            <div class="form-group">
                <label for="Date" class="mr-sm-2" >Дата</label>
                <input class="form-control mr-sm-2" id="Date" value="<?=date('d-m-Y')?>" required type="text" name="DateOfStudy">
                <input type="submit" id="btnShowTable" class="btn btn-primary mr-sm-2" value="Показать">


            </div>


        </form>
    </div>
    <div class="card-body text-center" id="content" >
<!--        <iframe name="Attendance" width="100%" height="100%" frameborder="no" seamless src="/Modules/admin/attendance_function.php" ">
-->        <?
                require_once("attendance_function.php");
        ?>
    </div>
</div>

<script>

    $("#Date").datepicker({
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true
    });

    function show(AGCode, Date)
    {
        $.ajax({
            method: 'POST',
            url: "attendance_function.php",
            cache: false,
            data: {AcademicGroups: AGCode, DateOfStudy: Date},
            success: function(html){
                //  alert("OK");
                $("#content").html(html);
            },
            fail: function (){alert("Беда!");},
            error: function (xhr, textStatus, error)
            {
                $("#content").html(textStatus+': '+error);
            }
        });

    };

    let fromAttendance = $("#formFindAttendance");

    fromAttendance.on('submit', function (ev){
        $("#content").html("<img width='100' src='/img/loaderData.gif' alt='Загрузка'/><p class='text-info h4'>Получение информации...</p>");
        ev.preventDefault();
        let AGCode = $("#AcademicGroups").val();
        let Date = $("#Date").val();
       //  alert(AGCode);

       setTimeout(show, 1000,  AGCode, Date);
    });

   /* $(document).ready(function(){
        show();
       setInterval('show()',100);
    });*/
</script>