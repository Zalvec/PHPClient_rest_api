<?php
require_once 'lib/autoload.php';

$css = array( "style.css");
$VS->BasicHead( $folderpath, $css );

$MS->ShowMessages();

print $VS->LoadTemplate('Task_header');
print $VS->LoadTemplate('task_form');
print $VS->LoadTemplate('All_tasks');
$TS->GetTasks();


