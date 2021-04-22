<?php
/*
 * Copyright (c) 2021. Kulikov K. P. [kostj1998.10.13@yandex.ru]
 * Project: JAGU
 * Module:
 * Submodule:
 * Description:
 * Version:
 */

/*
 * Copyright (c) 2021. Kulikov K. P. [kostj1998.10.13@yandex.ru]
 * Project: JAGU
 * Module:
 * Submodule:
 * Description:
 * Version:
 */

/*
 * Copyright (c) 2021. Kulikov K. P. [kostj1998.10.13@yandex.ru]
 * Project: JAGU
 * Module: Administrator
 * Submodule: Discipline Panel
 * Description: Модул управления списклм дисциплин
 * Version: 0.4.1352
 */
?>

<div class="card">
    <div class="card-header">
        <div class="card-title h5 text-center">Дисциплины</div>

	    <div>
            <button id="ShowBlockAddDiscipline" class="btn btn-outline-primary">Создать дисциплину</button>
        </div>
    </div>

    <div class="card-body">
	    <div id="prompt_discipline"></div>

	    <div id="divBlockTableDiscipline">
            <table id="DisciplineList" class="table table-hover table-primary">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Дисциплина</th>
                    <th>Ведущий преподаватель</th>
                    <th>Описание</th>
	                <th></th>
                </tr>
                </thead>
            </table>
        </div>

	    <div id="divBlockManagerDiscipline" class="border border-info bg-light p-2 m-auto" style="display: none;height: 25%; width: 50%; border-radius: 2%">
		    <form id="formDiscipline">
			    <input type="text" id="IDDiscipline" name="DisciplineID" hidden>
			    <div class="form-group row">
				    <label class="col-form-label col-sm-4">Название дисциплины:</label>
				    <div class="col-sm-8">

					    <input name="DisciplineName" id="DisciplineName" type="text" required class="form-control w-100">

				    </div>
			    </div>

			    <div class="form-group row">
				    <label class="col-form-label col-sm-4">Преподаватель:</label>
				    <div class="col-sm-8">

					    <select name="Teacher" class="custom-select" required id="TeacherList"></select>
				    </div>
			    </div>

			    <div class="form-group row">
				    <label class="col-form-label col-sm-4">Описание дисциплины:</label>
				    <div class="col-sm-8">

					    <textarea maxlength="254" class="form-control" id="Description"  name="DisciplineDescription"></textarea>

				    </div>
			    </div>
		    </form>
	    </div>


    </div>

    <div class="card-footer">

	    <div id="divBlockBtnDisciplineManager" class="text-center m-auto" style="display: none">
            <button id="SaveDiscipline" form="formDiscipline" class="btn btn-outline-primary">Сохранить</button>
            <button id="Cancle" class="btn btn-outline-secondary">Отмена</button>
        </div>
    </div>

</div>

<script>
   let TableDisciplineList = $("#DisciplineList").DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.22/i18n/Russian.json"
        },
	   processing: true,
	   responsive: true,
	   orderCellsTop: true,
	   fixedHeader: true,

        ajax: {
            type: 'GET',
            url: "API/DisciplineManager.php",
            cache: false,
	        data: {operation: 'show'},
            dataSrc: function (json) {
                return json.data;
            }
        },

        column: [
            {data: 0},
            {data: 1},
            {data: 2},
            {data: 3},
	        {data: 4}
        ]
    });

    $("#ShowBlockAddDiscipline").click(function (){
	    $("#formDiscipline select").trigger('change');
        $("#divBlockTableDiscipline").slideToggle();
        $("#divBlockManagerDiscipline").toggle();
        $("#divBlockBtnDisciplineManager").toggle();
        $("#ShowBlockAddDiscipline").toggle();
     //   $("#IDDiscipline").val("");
    });

    $("#Cancle").click(function (){
        $("#ShowBlockAddDiscipline").trigger('click');
        $("#formDiscipline").trigger('reset');
    });

    $(document).ready(function (){
        $.ajax({
            method: 'post',
            url: 'API/GetTeacherNameList.php',
            dataType: 'json',
            cache: 'false',

            success: function (json)
            {
                $("#TeacherList").append(new Option(""));
                for(let tID in json)
                {
                    $("#TeacherList").append(new Option(json[tID]['FIO'], json[tID]['ID']));
                }
            }
        });

        $("#TeacherList").select2({
            width: '100%',
            theme: 'classic',
            allowClear: true,
            placeholder: 'Выберите преподавателя'
        });
    });

    $("#formDiscipline").on('submit', function (e){
        e.preventDefault();


        $.ajax({
            method: 'post',
            url: 'API/DisciplineManager.php?operation=add',
            data: $("#formDiscipline").serialize(),
            dataType: 'html',

            success: function (html)
            {
                $("#prompt_discipline").html(html);
            },

            error: function (){
                $("#prompt_discipline").html("<div class='alert-danger alert'>Ошибка отправки запроса!</div>");
            }

        });

	    $("#formDiscipline").trigger('reset');
	    TableDisciplineList.ajax.reload();
        $("#ShowBlockAddDiscipline").trigger('click');
    });

    function DeleteDiscipline(ID){
          let result = confirm("Вы уверены, что хотите удалить данную дисциплину?");

          if(result)
          {	 $.ajax({
		          method: 'POST',
		          url: 'API/DisciplineManager.php?operation=delete',
		          data: {DisciplineID: ID},
		          dataType: 'html',

		          success: function (html){
			          $("#prompt_discipline").html(html);
		          },
		          error: function (){
			          alert("AJAX error request!");
		          }
	          });
	          TableDisciplineList.ajax.reload();
          }


	    /**/



    }

    function EditDiscipline(ID){

    	$.ajax({
		    method: 'post',
		    url: 'API/DisciplineManager.php?operation=get',
		    data: {DisciplineID: ID},
		    dataType: 'json',

		    success: function (json){
		    	console.log(json);
		    	$("#DisciplineName").val(json['Name']);
		    	$("#TeacherList").val(json['TeacherID']);
		    	$("#Description").val(json['Description']);
			    $("#formDiscipline select").trigger('change');
		    },

		    error: function (){
		    	alert("AJAX Fatal Error");
		    }
	    });


    	$("#IDDiscipline").val(ID);

    	$("#ShowBlockAddDiscipline").trigger('click');
    }
</script>


