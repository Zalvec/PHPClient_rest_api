<?php

$begin_url = $_SERVER['DOCUMENT_ROOT'] . "/Groepswerken/TaskPHP/";

//load Models
require_once $begin_url . "Model/Task.php";

//load Services
require_once $begin_url . "Service/Container.php";
require_once $begin_url . "Service/MessageService.php";
require_once $begin_url . "Service/ViewService.php";
require_once $begin_url . "Service/TaskService.php";

$Container = new Container();
$VS = $Container->getViewService();
$TS = $Container->getTaskService();
$MS = $Container->getMessageService();

session_start();