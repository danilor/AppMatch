<?php

/**
 * Show All errors
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

/**
 * AUTOLOAD
 */

// This is the array of directories we want to search for information and files
$directories = [ "config" , "classes" , "includes" ];

/**
 * This function will load all files in the given directory
 * @param $directory
 */

foreach( $directories AS $directory ){
	if(is_dir($directory)) {
		$scan = scandir($directory);
		unset($scan[0], $scan[1]); //unset . and ..
		foreach($scan as $file) {
			$file = $directory . DIRECTORY_SEPARATOR .$file;
			if(is_file( $file )) {
				require_once( $file );
			}
		}
	}
}

/**
 * Creating the database
 */
DB::$user       =       $config_database["user"];
DB::$password   =       $config_database["password"];
DB::$dbName     =       $config_database["name"];
DB::$host       =       $config_database["host"]; //defaults to localhost if omitted
DB::$port       =       '3306'; // defaults to 3306 if omitted
DB::$encoding   =       'utf8'; // defaults to latin1 if omitted
//DB::debugMode();
//DB::$error_handler=     true;
//DB::$success_handler =  true;
