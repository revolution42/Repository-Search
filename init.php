<?php

define("DIR_BASE", dirname (__FILE__) . "/");

// Register a basic autoloader
spl_autoload_register("autoload");
function autoload($class_name) {
	$file =  DIR_BASE . "class/" .  $class_name . '.php';
	if( file_exists($file) )
	{
   		require DIR_BASE . "class/" .  $class_name . '.php';
	}
}

// Register the different searches
RepoSearch::instance()->register("Github");
RepoSearch::instance()->register("BitBucket");
RepoSearch::instance()->register("Freshmeat");