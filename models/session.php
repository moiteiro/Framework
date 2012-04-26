<?php 

// prevent the direct access
defined('_PREVENT-DIRECT-ACCESS') or die ("Access restrict");

class Session{
	
	public function login($params){
		global $database;
		
		$query = sprintf("SELECT * FROM users WHERE 
												 username = '%s' 
											 AND 
												 password = '%s' 
											 LIMIT 1",
							mysql_real_escape_string($params['username']),
							mysql_real_escape_string(md5($params['password'])));
													  
		$result = $database->query($query);
		
		if($database->num_rows($result)){
			
			$user = $database->fetch_array($result);
			$this->set_session($user);
			
		}
	}
	
	public function logout(){
		$this->unset_session();
	}
	
	public function is_logged(){
		return (isset($_SESSION['user']) ? true:false);	
	}
	
	protected function set_session($user){
		$_SESSION['user']['username'] 	= $user['username'];
		$_SESSION['user']['id']			= $user['id'];
	}
	
	protected function unset_session(){
		if(isset($_SESSION['user'])){
			unset($_SESSION['user']);
		}
	}
	
}

$session =  new Session();

?>