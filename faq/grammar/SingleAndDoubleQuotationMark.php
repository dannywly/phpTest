<?php 
$username = 'danny wang';

// double quotation mark can recoginize vaiable, single quotaion mark is not.
echo "$username is kind man. </br>";
echo '$username is kind man. </br>';


echo <<<theEnd
	$username
	is
	a
	kind
	man.
theEnd;
?>