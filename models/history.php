<?php
						   
class History{
	
	protected $_action = array ('','cadastrou','removeu','alterou','alocou sala','logou','deslogou','punido','cadastrou senha','renovou sala','liberou sala');
	protected $_user_type = array('','administrador', 'porteiro','professor','aluno','sala','sistema');
	
	
	public function create($who_type, $who_id, $who_name, $action, $to_who_type, $to_who_id, $to_who_name){
		
		global $database;
		
		$query = sprintf("INSERT INTO history 
										  SET 
										who_type = %s,
										who_id = %s,
										who_name = '%s',
										action = %s,
										to_who_type = %s,
										to_who_id = %s,
										to_who_name = '%s',
										date = NOW()
										",
										mysql_real_escape_string($who_type),
										mysql_real_escape_string($who_id),
										mysql_real_escape_string($who_name),
										mysql_real_escape_string($action),
										mysql_real_escape_string($to_who_type),
										mysql_real_escape_string($to_who_id),
										mysql_real_escape_string($to_who_name));
		
		return $result = $database->query($query);
		
	}
	
	public function create_reserve($who_type, $who_id, $who_name, $action, $classroom_id, $classroom_name ,$to_who_type, $to_who_id, $to_who_name){
		
		global $database;
		
		$query = sprintf("INSERT INTO history_reserve 
										  SET 
										who_type = %s,
										who_id = %s,
										who_name = '%s',
										action = %s,
										classroom_id = %s,
										classroom_name = '%s',
										to_who_type = %s,
										to_who_id = %s,
										to_who_name = '%s',
										date = NOW()
										",
										mysql_real_escape_string($who_type),
										mysql_real_escape_string($who_id),
										mysql_real_escape_string($who_name),
										mysql_real_escape_string($action),
										mysql_real_escape_string($classroom_id),
										mysql_real_escape_string($classroom_name),
										mysql_real_escape_string($to_who_type),
										mysql_real_escape_string($to_who_id),
										mysql_real_escape_string($to_who_name));
		
		return $result = $database->query($query);
		
	}
	
	public function total_amount(){
		
		global $database;
		
		$query = sprintf("SELECT count(id) as total FROM users");
		
		$result = $database->query($query);
		
		list($total) = $database->fetch_array($result);
		
		return $total;
	}
	
	public function select_all($start, $per_page){
		
		global $database;
		
		$query = sprintf("SELECT * FROM history ORDER BY date DESC LIMIT %s, %s ", 
						  mysql_real_escape_string($start), 
						  mysql_real_escape_string($per_page)
		);
		
		$result = $database->query($query);
		
		return $database->result_to_array($result);
	}
	
	public function select_by_id($id){
		
		global $database;
		
		$query = sprintf("SELECT * FROM users WHERE id = '%s' LIMIT 1", mysql_real_escape_string($id));	
		
		$result = $database->query($query);
		
		$user = $database->fetch_array($result);
		
		return $user;	
	}
	
	public function select_by_name($params){
		
		global $database;
		
		$query = sprintf("SELECT users.username, users.email, users.job_id, jobs.name as job
										FROM users,jobs 
										WHERE 
											users.username like '%%%s%%' 
											AND
											users.job_id = jobs.id
										LIMIT 1", 
										mysql_real_escape_string($params['search_field'])
										);
										
		$result = $database->query($query);
		
		return $database->result_to_array($result);
		
	}
	
	public function organize($array){
		
		
		
		$history_array = array();
		
		foreach($array as $row => $history){
			
			// change the action values
			$history['action'] = $this->get_action($history['action']);
			
			
			// change the users_type
			$history['who_type'] 	= $this->get_user_type($history['who_type']);
			$history['to_who_type'] = $this->get_user_type($history['to_who_type']);
			
			
			$history_array[] = $history;
			
		}
		
		return $history_array;
	} 
	
	protected function get_action( $number){
		
		return $this->_action[$number];
	}
	
	protected function get_user_type( $number){
		
		return $this->_user_type[$number];
	}
}

$history = new History();

?>