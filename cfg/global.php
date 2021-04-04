<?php
// Конфигурация сайта
const SITE_NAME='JAGU';
const SITE_DESCRIPTION = "Журнал академичесой группы вуза";
const SITE_URL ='www.jagu.ru';
$Page_Title = SITE_NAME; //Глобальная переменная - title page

// Конфигурация БД

const DB_HOST='localhost';
const DB_USERNAME = 'Admin';
const DB_PASSWORD = 'admin';
const DB_NAME = 'jagu';


$RESPONSE_AJAX = array(
    'data'=>array(),
    'success'=>false,
    'ErrorInfo'=>''
);
