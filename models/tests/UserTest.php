<?php

require_once("_config.php");

require_once (MODEL_PATH."\\users.php");
require_once (LIBS_PATH."\\database.php");

class UsersTest extends PHPUnit_Framework_TestCase implements User{
		
	private $database;
	private $users;
	
	public function setUp(){
		
		$this->database = new MySQLDatabase();
		$this->users = new User();
	}
	
	public function test_is_equal(){
		
		$expected = $actual = "motieiro"; 
		
		$this->assertTrue($this->users->is_equal($expected, $actual));
			
	}
		
}


?>