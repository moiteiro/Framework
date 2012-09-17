<?php 

class Session extends DatabaseObject{
	
	public function login($user){
		
		self::create_session($user);
	}
	
	public function logout(){
		$this->destroy_session();
	}
	
	public function is_logged(){
		return (isset($_SESSION['user']) ? true:false);	
	}
	
	protected function create_session($user){
		$_SESSION['user']['id']			= $user->id;
	}
	
	protected function destroy_session(){
		if(isset($_SESSION['user'])){
			unset($_SESSION['user']);
		}
	}
	
}

$session =  new Session();

?>