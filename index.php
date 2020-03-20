<?php
require_once 'lib/autoload.php';

$css = array( "style.css");
$VS->BasicHead( $css );

$MS->ShowMessages();

print $VS->LoadTemplate('task_form');
