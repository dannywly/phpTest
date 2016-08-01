<?php 

	//变量类型转换
	$count = 0;
	echo $count . " </br>";
	$floatCount = (float)$count;
	echo "$floatCount <br/>";

	//声明和使用常量
	define('FILE', 1000);
	echo FILE;
	//可变变量
	

	//超全局变量
	var_dump($GLOBALS);
	;var_dump($_SERVER)
 ?>