<?php
function loadClass($class){
	require $class. ".class.php";
}
spl_autoload_register("loadClass");
$db = new Db();

