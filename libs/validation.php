<?php

/**
* Valida todos os campos antes de inserir no banco de dados
* @author Bruno Moiteiro  <bruno.moiteiro@gmail.com>
* @version 1.0.1
* @copyright Copyright (c) 2011, Bruno Moiteiro
*/
class Validation {
	
	/**
	* Todos os erros serão inseridos nessa variável
	* @access protected
	* @var string
	*/
	protected $validation_list;
	
	/**
	* Quantidade de erros na tentativa de validar
	* @access protected
	* @var int
	*/
	protected $errors = 0;
	
	/**
	* A lista de campos para não serem avaliados
	* @access protected
	* @var array
	*/
	protected $avoid_fields = array();
	
	
	public function __construct(){
	
		if (!function_exists('filter_list')) {
    		throw new Exception("A class Validation requer Funções Filter's >= PHP 5.2 or PECL.");
		}
	}
	
	/**
	* Verifica se a parâmetro passado é um e-mail válido
	* @access public
	* @param string $email
	* @return string|bool
	*/
    public function is_email($email){
		
		return filter_var($email,FILTER_VALIDATE_EMAIL);
		
	}

	/**
	* Remove todos o caracteres exceto letras, dígitos e !#$%&'*+-/=?^_`{|}~@.[].  
	* @access public
	* @param string $email
	* @return string|bool
	*/
	public function sanitize_email($email){
	
		$this->email = filter_var($email,FILTER_SANITIZE_EMAIL);
        if (!$this->is_email($this->email)){ return false;} 
		if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/",$this->email)){return false;}
		return true;
	}

	/**
	* Verifica se o parâmetro é um inteiro
	* @access public
	* @param int $number
	* @return int|bool
	*/
	public function integer_number($number){
		
		return filter_var($number, FILTER_VALIDATE_INT);

	}

	/**
	* Verifica se o parâmetro é um número real
	* @access public
	* @param float $number
	* @return float|bool
	*/
	public function float_number($number){

		return filter_var($number,FILTER_VALIDATE_FLOAT);

	}
	
	/**
	* Remove todas as tags da uma string
	* @access public
	* @param string $string
	* @return string|bool 
	*/
    public function sanitize_string($string){
               
		return filter_var($string,FILTER_SANITIZE_STRING);

    }

	/**
	* Retorna a listagem e error e sucessos
	* @access public
	* @return string
	*/
	public function get_validation_result(){
		
		return $this->validation_list;
			
	}
	
	/**
	* Retorna a quantidade de erros
	* @access public
	* @return int
	*/
	public function get_errors(){
	
		return $this->errors;
			
	}

	/**
	* Percorre o array contendo o nome dos atributos da classe e o valor armazenado fazendo verificações
	* Se um tipo não corresponder ao que foi requisitado, a função retornará false
	* @access public
	* @param array $params
	* @param array $validation
	* @return bool 
	*/
	public function validate_fields(array $params, array $validation){

		foreach ($validation as $param=>$type){
			
			if(!array_key_exists($param, $this->avoid_fields))
			
			switch($type){
				
				case 'integer':
					if ($params[$param] == 0 && is_numeric($params[$param])){
						$this->set_validation_result(1, $param, $type);
						continue; 
					}
					if (!$this->integer_number($params[$param])) { 
						$this->set_validation_result(0, $param, $type);
						$this->increment_error();
					} else {
						$this->set_validation_result(1, $param, $type);
					}
					
				break;

				case 'integer-void':
					if ($params[$param] == "" ){continue; }
					if (!$this->integer_number($params[$param])) { 
						$this->set_validation_result(0, $param, $type);
						$this->increment_error();
					} else {
						$this->set_validation_result(1, $param, $type);	
					}
					
				break;
								
				case 'float':
				
					if (!$this->float_number($params[$param])) {
						$this->set_validation_result(0, $param, $type);
						$this->increment_error();
					} else {
						$this->set_validation_result(1, $param, $type);
					}
					
				break;
				
				case 'string':
					
					if (!$this->sanitize_string($params[$param])) { 
						$this->set_validation_result(0, $param, $type);
						$this->increment_error();
					}  else {
						$this->set_validation_result(1, $param, $type);
					}
					
				break;
				
				case 'string-void':
				
					if ($params[$param] == "" ){ 
						$this->set_validation_result(1, $param, $type);
						continue; 
					} else if (!$this->sanitize_string($params[$param])) { 
						$this->set_validation_result(0, $param, $type);
						$this->increment_error();
					} else {
						$this->set_validation_result(1, $param, $type);
					}
					
				break;
				
				case 'email':
				
					if (!$this->sanitize_email($params[$param])) { 
						$this->set_validation_result(0, $param, $type);
						$this->increment_error();
					} else {
						$this->set_validation_result(1, $param, $type);
					}
					
				break;
				
				case 'cpf':
				
					if (!$this->cpf($params[$param])) {
						$this->set_validation_result(0, $param, $type);
						$this->increment_error();
					} else {
						$this->set_validation_result(1, $param, $type);
					}
			}
		}
		return true;
	}
	
	/**
	* Recebe um array com os campos para não serem avaliados
	* Ao receber o array, a função transforma o que é key e value e vice-versa e coloca o resultado em {@link $avoid_fields}
	* @access public
	* @param array $fields
	* @return void 
	*/
	public function avoid_fields(array $fields){
		
		$array = array();
		
		foreach($fields as $field=>$value)
			$array[$value] = "";
		
		$this->avoid_fields = $array;
	}
	
	/**
	* Cria um lista com o resultado das validações
	* A função verifica qual foi o resultado das validações e cria com cada uma delas uma linha com os resultados
	* @access private
	* @param int $message
	* @param string $param
	* @param string $type
	* @return void
	*/
	private function set_validation_result($situation, $param, $type){
		if($situation){
			$this->validation_list .= "Ok | " . $param . " => ". $type ."<br />"; 
		} else {
			$this->validation_list .= "Error | ".$param . " => ". $type . "<br />"; 
		}
		
	}
	
	/**
	* Incrementa a quantida de erros guardado na variável {@link @errors}
	* @access private
	* @return void
	*/
	private function increment_error(){
		$this->errors++;
	}		
		
}

$validation = new Validation();

?>