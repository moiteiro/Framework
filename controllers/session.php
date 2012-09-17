<?php

// prevent the direct access
defined('_PREVENT-DIRECT-ACCESS') or die ("Access restrict");

switch( $route_app->view ){
	
	case "create":

		$user = User::authenticate($params);

		if(isset($user->id)){
			$session->login($user);	
		}
		
		if($session->is_logged()){
			if(isset($_SESSION['session']['login_error']))
				unset($_SESSION['session']['login_error']);
			
		} else {
			$_SESSION['session']['login_error'] = "error";
			flash_warning("Email e senha n&atilde;o conferem com nenhum usu&aacute;rio cadastrado.<br/> Tente novamente.");
		}
			
		redirect_to("");
		
	break;
	
	case "delete":
	
		$session->logout();
		
		redirect_to("");
		
	break;
	
}

?>