<?php 

echo date('Y:H:i, JS F ');
$out = `ls -la`;
$git = `git status`;
echo "<pre> $out </pre><br/>";
echo "<pre> $git </pre><br/>";

if(is_dir('/home/user')) {
	echo "is file";
} else {
	echo "is not file";
}

 ?>