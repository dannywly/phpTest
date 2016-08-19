<?php 
$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
// $DOCUMENT_ROOT = $HTTP_SERVER_VARS['DOCUMENT_ROOT'];
echo $DOCUMENT_ROOT . '<br/>';

$file = fopen("$DOCUMENT_ROOT/hell.py", 'a+');
$content = fgets($file);
echo "$content";
 ?>