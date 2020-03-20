<?php
require_once 'autoload.php';

$css = array( "style.css");
$VS->BasicHead( $css );

$MS->ShowMessages();

if ( $_SERVER['REQUEST_METHOD'] == "POST" ){
    if ( isset($_POST['AllTasks']) )        $TS->GetTasks();
    elseif ( isset($_POST['OneTask']) )     $TS->GetOneTask($_POST['ID']);
    elseif ( isset($_POST['CreateTask']) )  $TS->CreateTask($_POST['date'], $_POST['task']);
    elseif ( isset($_POST['EditTask']) )    $TS->EditTask($_POST['ID'], $_POST['date'], $_POST['task']);
    elseif ( isset($_POST['DeleteTask']) )  $TS->DeleteTask($_POST['ID']);
    else $MS->AddMessage('Failed to execute', 'error');
} else $MS->AddMessage( 'Failed to send request', 'error');

print '<a href="../index.php">Return to index.php</a>';