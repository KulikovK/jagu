<?php
require_once("cfg/core.php");

if($_GET['logout']=='true')
{
    logout();
    header('Location: /');
}
header('Location: /');
