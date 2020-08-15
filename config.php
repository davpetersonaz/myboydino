<?php
function doDefine($name, $value){
	if(!defined($name)){ define($name, $value); }
}

error_reporting(E_ALL);
ini_set('display_errors', 'On');

//'real' paths
doDefine('REAL_PATH', realpath(dirname(__FILE__)).'/');
doDefine('HTMLS_PATH', REAL_PATH.'htmls/');

//setup logging
doDefine('EOL', "\r\n");
doDefine('DEBUG_LOG', REAL_PATH.'logs/myDebug.log');
doDefine('DEBUG_TIMESTAMP', 'D M d H:i:s');
date_default_timezone_set('America/Los_Angeles');
if(!function_exists('logDebug')){
	function logDebug($text1, $text2=false){
		if($text2){//log an error
			error_log('['.date(DEBUG_TIMESTAMP).'] DAVERROR '.$text2.PHP_EOL, 3, DEBUG_LOG);
		}else{//log a debug
			error_log('['.date(DEBUG_TIMESTAMP).'] '.$text1.PHP_EOL, 3, DEBUG_LOG);
		}
	}
}

//paths from www/
doDefine('CSS_URL_PATH', '/css/');
doDefine('JS_URL_PATH', '/js/');

if(!function_exists('ourautoload')){
	function ourautoload($classname){
		if(file_exists(REAL_PATH."classes/core/". $classname .".php")){
			require_once("classes/core/". $classname .".php");
		}
		if(file_exists(REAL_PATH."classes/". $classname .".php")){
			require_once("classes/". $classname .".php");
		}
	}
}
spl_autoload_register('ourautoload');

//start session AFTER loading all the classes
session_start();
$alreadyLoggedIn = (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true);

$db = new DBCore();

logDebug('config complete');