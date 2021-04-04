<?php
//Активация аккаунта.

if(!isset($_GET['hash']))
    exit();

require_once ($_SERVER['DOCUMENT_ROOT'].'/cfg/core.php');
$hash = $_GET['hash'];

$query = "select AA_UserID As ID from accauntactivation where AA_ActivationCodeHash = :hash";

try {
    $db = db_connect();
    if($db==null)
        exit();

    $stmp = $db->prepare($query);

    $stmp->execute(Array('hash'=>$hash));

    $Data = $stmp->fetch();
    if($Data)
    {
        require_once $_SERVER['DOCUMENT_ROOT'].'/template/head.php';

        require_once $_SERVER['DOCUMENT_ROOT'].'/template/top.php';

        ?>

        <div class="container">
            <div class="card">
                <div class="card-header">
                    <p class="h3">Сброс пароля</p>
                    <p>Придумайте новый пароль для вашего аккаунта</p>
                </div>
                <div class="card-body" id="Status">
                    <form id="NewPasswordForm">

                        <input name="id" hidden value="<?= $Data['ID']?>">

                        <label>
                            <input class="form-control" placeholder="Введите пароль" type="password" id="Password1" required name="password">
                        </label>

                        <label>
                            <input class="form-control" placeholder="Повторите пароль" type="password" required id="Password2">
                        </label>

                        <label id="cMessage" class="label-info"></label>

                    </form>
                    <button id="btnNext" disabled class="btn btn-info">Продолжить</button>
                </div>
            </div>
        </div>

        <script>
            $('#Password2').keyup(function (){
                let Password1 = $('#Password1').val();
                let Msg = $('#cMessage');
                if($('#Password2').val()=== Password1) {
                    Msg.html('<p class="alert alert-success">OK</p>')
                    $('#btnNext').prop('disabled', false);
                }
                else {
                    Msg.html('<p class="alert alert-danger">Пароли не совпадают!</p>');
                    $('#btnNext').prop('disabled', true);
                }
            });

            $('#btnNext').click(function (){
                let Password = $('#Password1').val();

                $.ajax({
                    method: 'POST',
                    cache: false,
                    url: 'newpassword.php',
                    data: $('#NewPasswordForm').serialize(),
                    dataType: 'HTML',

                    success: function (answer)
                    {
                        $('#Status').html(answer);
                    },

                    error: function (xhr, errorText, error){
                        alert(error+":"+errorText);
                    }
                })


            })

        </script>

   <?php
    }else{
        echo 'Недействительная ссылка!';
    }

}
catch (PDOException $exception)
{
    echo $exception->getMessage();
    echo $exception->errorInfo;
}
