<?php

require_once('core/init.php');

$url         = $_SERVER['REQUEST_URI'];
$params      = array();
$match_found = false;

$params = array_merge($params,$_POST);

if($route->check_url($url,$matches)){
		
	$params = array_merge($params, $matches);
	
	require_once( CONTROLLER_PATH.DS.'application.php' );

	if($route->controller != "application") // para que o controller aplication nao seja incluido mais de uma vez.
		include( CONTROLLER_PATH.DS.$route->controller.'.php' );
	
	$match_found = true;
		
	if (file_exists(VIEW_PATH.DS.'layouts'.DS.$route->controller.'.php')){
		include(VIEW_PATH.DS.'layouts'.DS.$route->controller.'.php');
	} else {
		include(VIEW_PATH.DS.'layouts'.DS.'application.php');
	}
}

unset($_SESSION['flash']['notice']);
unset($_SESSION['flash']['warning']);
unset($_SESSION['flash']['tip']);
unset($_SESSION['params']);

if (!$match_found){
	include(VIEW_PATH.DS.'layouts'.DS.'failed.php');
}

unset($database);

?>