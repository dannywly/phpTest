<?php 
	echo "string";
	$contents1 = file_get_contents('history.csv');
	$contents2 = file_get_contents('history_1.csv');
	var_export($contents1);
	$res = file_put_contents('empty1.csv', $contents1, FILE_APPEND | LOCK_EX);
	var_export($res);
	file_put_contents('empty1.csv', $contents2, FILE_APPEND | LOCK_EX);
 ?>