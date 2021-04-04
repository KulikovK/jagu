

<!--Авторизация-->
<div class="d-table mt-5 bg-light border border-info ml-auto mr-auto text-center justify-content-center"
style="border-radius: 5px">
    <H2 class="bg-info p-2 text-white">Авторизация</H2>
    <form class="" action="" method="post">
<div class="card-body form-group">
<p class="text-info">Данная система явяется закрытой.<br> Для продолжения работы прйдите авторизацию!</p>

        <label class="mr-sm-2">

            <input name="Login" class="form-control" type="text" placeholder="Введите логи"
            value="<?=$_POST['Login']?>">
        </label>
<br>

        <label class="mr-sm-2">
            <input name="Password" class="form-control" type="password" placeholder="Введите пароль">
        </label class="mr-sm-2">
<br>
    <label>
        <div class="g-recaptcha mt-2" data-sitekey="6LcBPfwZAAAAAB6rTO17anlbm3Wn73vljkxufHCM" style="margin-bottom: 1em; margin-top: 1em;" ></div>
    </label>
    <br>
        <label>
            <input type="submit" class="btn mt-2 mr-sm-2 btn-outline-info" value="Войти">
        </label>
    <br>
    <label>
        <p class="text-dark">
            <?=$AuthTxtWarning?>
        </p>
    </label>

</div>
    </form>

    <div id="resetPassword" class="btn btn-info">Забыли пароль?</div>
</div>

<div class="modal fade" id="WindowResetPassword" role="dialog" data-toggle="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white">Восстановление пароля</h5>
            </div>
            <div class="modal-body" id="WRP_Body">
                 <form id="FormResetPassword">
                     <label class="col-form-label">Укажите адрес вашей электронной почты, на которую выполнялась регистрация аккаунта.</label>
                     <label>
                         <input type="email" id="email" name="Email" class="form-control" placeholder="Введите email">
                     </label>
                 </form>
                <hr>
                <p class="small">Если вы не имеет доступа к электронной почте - обратитесь к администрации ВУЗа, они помогут восстановить доступ к аккаунту.</p>
            </div>
            <div class="modal-footer bg-light justify-content-end">
                <div>
                    <button type="button" id="btnResetPassword" disabled class="btn btn-info">Продолжить</button>
                    <button type="button" id="" class="btn btn-secondary" onclick="$('#WindowResetPassword').fadeOut()" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
$('#resetPassword').click(function (){
    $("#WindowResetPassword").modal({
        keyboard: false
    });
})

$('#email').change(function (){
    if($("#email").val().length !== 0)
        $("#btnResetPassword").prop('disabled', false);
    else
        $("#btnResetPassword").prop('disabled', true);
})

$("#btnResetPassword").click(function (){
    $.ajax({
        method: 'POST',
        url: "/resetPassword.php",
        data: $("#FormResetPassword").serialize(),
        dataType: "html",

        success: function (answer){
            $("#WRP_Body").html(answer);
            $('#btnResetPassword').prop('hidden', true);
        },

        error: function (xhr, ErrorText, Error)
        {
            $('#WRP_Body').html(Error+": "+ErrorText);
            $("#btnResetPassword").prop('hidden', true);
        }

    })
})
</script>
