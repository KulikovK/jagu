
<script type="text/javascript">
    function autoResize(iframe) {
        $(iframe).height($(iframe).contents().find('html').height());
    }
</script>


<footer class="blockquote-footer">
    <p class="m-2">&copy; Kulikov K. P., <?= date("Y");?>
    </p>
</footer>

<!--<script type="text/javascript">
    $(document).ready( function () {
        $('#TableStudentList').bdt();
    });
</script>-->

<script>
    /* $(document).ready(function(){

         $('#TableStudentList').DataTable({
             responsive: true,
             language: {
                 url: "//cdn.datatables.net/plug-ins/1.10.22/i18n/Russian.json"
             },
            bAutoWidth: false,
             columns
         });

     });*/

    /*---------*/
    var tableStudentList = $('#TableStudentList').DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.22/i18n/Russian.json"
        },
        length: 5,
        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Все"]],
        dom: 'QB<"clear">lfrtip',
        buttons: [
            {
                extend: 'print',
                text: 'Печать',
                className: '.btn .btn-success',
               messageTop: 'Список студентов',
                exportOptions: {
                    columns: ':visible',
                    text: 'Выбрать столбцы',
                }
            },
            {
                extend: 'colvis',
                text: 'Выбрать столбцы'
            }
        ],

        stateSave: true
    });

   



    var tableTeacherList = $('#TableTeacherList').DataTable({
        processing: true,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.22/i18n/Russian.json",
                    },



        "ajax": {
            "type" : "POST",
            "url"  : "/Modules/admin/getTeacherTable.php",
            "dataSrc": function ( json ) {
                return json.data;
            }
        },
        columns: [
            {data: '0'},
            {data: '1'},
            {data: '2'},
            {data: '3'},
            {data: '4'},
            {data: '5'},
            {data: '6'},
            {data: '7'},
            {data: '8'},
            {data: '9'},
            {data: '10'}
        ],



        stateSave: true,

    });





</script>

<script>
    $(function () {
        var location = window.location.href;
        //alert(location);
        var cur_url =  location.split('/').pop();

        if(cur_url.length === 0)
            cur_url = "/";

     //   alert(cur_url);
        $('.nav-item').each(function () {
            var link = $(this).find('a').attr('href');
           // link = link.split('/').pop();
//alert(link+"\n"+cur_url);

            if (cur_url === link) {
                $(this).addClass('active alert-link');
            }
        });
    });


   /* $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })*/


</script>
