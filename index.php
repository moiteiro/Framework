<?php

require_once('core/init.php');

$url         = $_SERVER['REQUEST_URI'];
$params      = array();
$match_found = false;

$params = array_merge($params,$_POST);

if($route_app->check_url($url,$matches)){
		
	$params = array_merge($params, $matches);
	
	try{

		require_once( CONTROLLER_PATH.DS.'application.php' );

		if($route_app->controller != "application") // para que o controller aplication nao seja incluido mais de uma vez.
			include( CONTROLLER_PATH.DS.$route_app->controller.'.php' );

		$match_found = true;
		
		if (file_exists(VIEW_PATH.DS.'layouts'.DS.$route_app->controller.'.php')){
			include(VIEW_PATH.DS.'layouts'.DS.$route_app->controller.'.php');
		} else {
			include(VIEW_PATH.DS.'layouts'.DS.'application.php');
		}

	} catch(Exception $e){
		
		// tratar os erros aqui
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