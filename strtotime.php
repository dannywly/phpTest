<?php 
echo(strtotime("now"));
echo "<br/>";
echo(strtotime("3 October 2005"));
echo "<br/>";
echo(strtotime("+5 hours"));
echo "<br/>";
echo(strtotime("+1 week"));
echo "<br/>";
echo(strtotime("+1 week 3 days 7 hours 5 seconds"));
echo "<br/>";
echo(strtotime("next Monday"));
echo "<br/>";
echo(strtotime("last Sunday"));
echo "<br/>";
define('HELLO','Hello World');
require_once(__DIR__ . '/testDir.php');
 ?>