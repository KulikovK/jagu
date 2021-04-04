<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/cfg/core.php');
//if(isset($_POST['id']))
$DEP_id = $_GET['id'];

//echo $DEP_id;

if($DEP_id === "")
    exit(json_encode(''));

$query = 'Select DEP_id As ID, DEP_Name As Name from departments where DEP_Faculty_id = :id';

$db = db_connect();

$stmp = $db->prepare($query);

$stmp->execute(Array('id'=>$DEP_id));

$OutData = $stmp->fetchAll();
echo json_encode($OutData);

/*foreach ($OutData As $row)
{
    echo '<option value="'.$row['ID'].'">'.$row['Name'].'</option>';
}*/

//echo json_encode($OutData);