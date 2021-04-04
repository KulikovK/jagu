<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/cfg/core.php');
if(!isset($_POST['id']) || empty($_POST['id']) || isAuthUser() != 'admin')
{
    echo json_encode('false');
    exit();
}

$id = $_POST['id'];

$query = 'Delete from users WHERE User_id= :id';

$db = db_connect();

if($db === NULL)
    exit();

$stmp = $db->prepare($query);

$isDelete = $stmp->execute(array('id'=>$id));

if($isDelete)
    echo json_encode('true');
else
    echo json_encode('false');