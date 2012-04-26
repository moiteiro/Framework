<?php

session_start();

include('includes/config.php');
include(MODEL_PATH."/session.php");
include(MODEL_PATH."/history.php");

$url = $_SERVER['REQUEST_URI'];

$match_found = false;

$params = array();

$params = array_merge($params,$_POST);

foreach($routes as $urls => $route){
		
	if (preg_match($route['url'],$url,$matches)){
		
		$params = array_merge($params, $matches);
		
		include(CONTROLLER_PATH.DS.$route['controller'].'.php');
		
		$match_found = true;
		
		if($session->is_logged()){ // verifica se o usuário está logado.
			
			if (file_exists(VIEW_PATH.DS.'layouts'.DS.$route['view'].'.php')){
				include(VIEW_PATH.DS.'layouts'.DS.$route['view'].'.php');
			} else {
				include(VIEW_PATH.DS.'layouts'.DS.'application.php');
			}
		} else {
			include(VIEW_PATH.DS.'layouts'.DS.'session.php');	
		}
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