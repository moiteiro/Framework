<?php

// prevent the direct access
defined('_PREVENT-DIRECT-ACCESS') or die ("Access restrict");

switch($route_app->view){
	case "create":
		$session->login($params);
		
		if($session->is_logged());
			$history->create($_SESSION['permission_level'],$_SESSION['user_id'],$_SESSION['username'],5,6,0);
		redirect_to("");
		
		break;
	
	case "delete":
	
		$history->create($_SESSION['permission_level'],$_SESSION['user_id'],$_SESSION['username'],6,6,0);
		$session->logout();
		redirect_to("");
		
		break;
	
}

?>