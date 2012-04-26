<?php

/** 
* Class de funçoes comuns entre as classes 
* Essa class retém as funções básicas de relacionadas ao Banco de Dados
* @author Bruno Moiteiro <bruno.moiteiro@gmail.com>
* @version 1.0
* @copyright Copyright (c) 2011, Bruno Moiteiro
*/
 

class DatabaseObject {
	
	/**
	* o nome da tabela relacionada a essa classe
	* será alterado na class que extender essa classe
	* @access protected
	* @var string
	*/
	protected static $table_name;
	
	/**
	* Todos as colunas da tabela precisam ser declaradas aqui, 
	* cada coluna deve ser passada como chave e o volar precisa ser o tipo coluna em PHP (ex. string, integer ...)
	* As colunas que não forem listadas não serão alteradas
	* @access protected
	* @var array
	*/
	protected static $db_fields;
	
	/**
	* Retorna todas entradas da tabela
	* @static
	* @param int $start
	* @param int $per_page
	* @return object|mixed
	*/
	public static function find_all(){
		
		return self::find_by_sql("SELECT * FROM ".static::$table_name);
	}
	
	/**
	* Retorna a linha da tabela referente ao id
	* @access public
	* @static
	* @param int $id
	* @return object|bool
	*/
	public static function find_by_id($id=0){
		
		global $database;
		
		$result_array = self::find_by_sql("SELECT * FROM ".static::$table_name." WHERE id ={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	/**
	* Função para executar qualquer SQL de seleção.
	* Retorna um array de objects ou um object com todas as propriedades declaradas na classe já setadas.
	* @access public
	* @static
	* @param string $sql
	* @return object|mixed
	*/
	public static function find_by_sql($sql=""){
		global $database;
		$result_set = $database->query($sql);
		$object_array = array();
		while ( $row = $database->fetch_array($result_set)){
			$object_array[] = self::instantiate($row);
		}
		return $object_array;
	}
	
	/**
	* Seta valores nos atributos da classe
	* Recebe um array com valores que serão colocados nos atributos.
	* Os atributos só receberam valores se eles estiverem declarados na classe e no array {@link $db_fields}
	* @access public
	* @param array $params
	* @return void
	*/
	public function set_attributes($params){
		
		foreach(static::$db_fields as $attribute=>$type){
			if(array_key_exists($attribute, $params)){
				if(isset($params[$attribute]))
				$this->$attribute = $params[$attribute];	
			}
		}
	}
	
	/**
	* Retorna todos os atributos que existem na tabela do banco de dados
	* @access public
	* @return array
	*/
	public function get_attributes(){
		
		$attributes = array();
		
		foreach(static::$db_fields as $attribute=>$type){

			$attributes[$attribute] = $this->$attribute;
		}
		
		return $attributes;
	}
	
	/**
	* Retorna o array {@link $db_fields}
	* @access public
	* @return array
	*/
	public function get_attributes_type(){
		
		return static::$db_fields;
		
	}
	
	/**
	* Atribui os valores dos atributos na chaves do array {@link $db_fields}
	* Lista todos os valores declarados em {@link $db_fields}, verifica se a propriedade existe na classe e transforma os valores dos {@link $db_fields} em chaves e os valores dos atributos em valores dessas chaves.
	* Retorna true se a linha for apagada e false caso a operação não possa ser realizada
	* @access public
	* @return array
	*/
	public function attributes(){
		// return an array of attributes keys and their values
		// return get_object_vars($this);
		
		foreach(static::$db_fields as $field=>$type){
			if(property_exists($this, $field)){
				$attributes[$field] = $this->$field;
			}
		}
		
		return $attributes;
	}
	
	/**
	* Semelhante a {@link attributes()} mas o valores são escapados
	* Retorna um array com todos os valores escapados por mysql_real_escape_string()
	* @access public
	* @return array
	*/
	public function sanitized_attributes(){
		

		global $database;

		$clean_attributes = array();
		
		foreach($this->attributes() as $key => $value){
			$clean_attributes[$key] = $database->escape_value($value);
		}
		
		return $clean_attributes;
	}
	
	/**
	* Insere os valores dos atributos que estiverem nas colunas da tabela declarada em {@link $table_name} 
	* Retorna true e seta o valor id no $id da classe que implementou esse classe se a linha for inserida com sucesso, caso contrário, false
	* @access public
	* @return bool
	*/
	public function create(){
		
		global $database;
		
		$attributes = $this->sanitized_attributes();
 		$sql  = "INSERT INTO ".static::$table_name." (";
		$sql .= join(", ", array_keys($attributes));
		$sql .= ", created_at "; // campo será obrigatorio para todos os cadastros
		$sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "', NOW())";
		
		if($database->query($sql)){
			$this->id = $database->insert_id();
			return true;
		} else {
			return false;
		}
	}
	
	/**
	* Atualiza os valores dos atributos que estiverem na tabela declarada em {@link $table_name} 
	* Retorna true se a linha for atualizada com sucesso, caso contrário, false
	* @access public
	* @return bool
	*/
	public function update(){
		global $database;
		
		$attributes = $this->sanitized_attributes();
		$attributes_pairs = array();
		foreach($attributes as $key => $value){
			$attributes_pairs[] = "{$key}='{$value}'";
		}
		
		$sql  = "UPDATE ".static::$table_name." SET ";
		$sql .= join(", ", $attributes_pairs);
		$sql .= " WHERE id=".$database->escape_value($this->id);
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;
	}
	
	/**
	* Deleta uma linha da tabela cujo o id seja igual ao declarado
	* Retorna true se a linha for apagada e false caso a operação não possa ser realizada
	* @access public
	* @return bool
	*/
	public function delete(){
		global $database;
		
		$sql  = "DELETE FROM ".static::$table_name." ";
		$sql .= " WHERE id=". $database->escape_value($this->id);
		$sql .= " LIMIT 1";
		
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;
	}
	
	/**
	 * Verifica se nao ha a coluna possue um valor que seja unico.
	 * Caso existam valores semelhantes, a funcao retorna false.
	 * @access public
	 * @param string $column nome da coluna da tabela.
	 * @param string $value string contendo o valor a ser verificado.
	 * @return bool
	 */
	public function is_unique($column, $value){
		
		global $database;
		
		$result_array = self::find_by_sql("SELECT * FROM ".static::$table_name." WHERE {$column}='{$value}' LIMIT 1");
		
		return empty($result_array) ? true : false;
	}
	
	
	/**
	* Verifica se os o valores cadastrados no banco são iguais aos submetidos
	* @access public
	* @static
	* @param object $object
	* @param object $old_object
	* @return bool
	*/
	public static function is_same($object, $old_object){
		
		$is_same = true;
		
		foreach(static::$db_fields as $attribute=>$type){
			if($object->$attribute != $old_object->$attribute){
				# debug
				# echo $attribute."=>".$object->$attribute."!=".$old_object->$attribute."<br />"; 
				$is_same = false;
			}
		}
		return $is_same;
	}	
	
	/**
	* Exibe todos os dados importantes de uma objeto.
	* Mostra o arquivo onde se encontra, o nome da tabela que nanipula os atributes e os valores que eles possuem
	* @access public
	* @static
	* @return string
	*/
	public function __toString(){
		
		$obj_content = "<table border='1'>";
		
		$attrs = $this->get_attributes();
		
		foreach($attrs as $attr => $value){
			$obj_content .= "<tr>";
			$obj_content .= "<td>{$attr}</td><td>$value</td>"; 
			$obj_content .= "</tr>";
		}
		
		$obj_content .= "</table>";
		
		return $obj_content;
	}


	/**
	* Seta os valores passados através de uma array nas propriedades declaradas na classe
	* @access private
	* @static
	* @param array $record
	* @return object
	*/
	private static function instantiate($record){
		
		$class_name = get_called_class();
		$object = new $class_name;
		
		foreach($record as $attribute=>$value){
			if($object->has_attribute($attribute)){
				$object->$attribute = $value;
			}
		}
		return $object;
	}
	
	/**
	* Seta os valores passados através de uma array nas propriedades declaradas na classe
	* @access private
	* @static
	* @param string $attribute
	* @return bool
	*/
	private function has_attribute($attribute){
		
		$object_vars = get_object_vars($this);
		return array_key_exists($attribute, $object_vars);
		
	}
	
}