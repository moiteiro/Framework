<?php

/** 
* Class de Conexao com o banco de dados 
* A conexao eh estabalecida no momento da instaciacao
* 
* @author Bruno Moiteiro <bruno.moiteiro@gmail.com>
* @version 1.1
* @copyright Copyright (c) 2011, Bruno Moiteiro
*/
 
class MySQLDatabase{
	
	/**
	* Armazena a conexão com o banco de dados 
	* @var resource
	* @access private
	*/
	private $connection;
	
	/**
	* Armazena a última query solicitada ao banco
	* Serve para depuração de erros
	* @var string
	* @access protected
	*/
	protected $last_query;
	
	/** 
	* Abre a conexão com o banco de dados
	* A conexão é estabelecida no momento da instanciaçào
	* @return void
	*/
	public function __construct(){
		$this->open_connection();
	}
	
	/** 
	* Fecha a conexão com o banco de dados
	* No momento em que a variável for destruida ele fechará a conexão
	* @return void
	*/
	
	public function __destruct(){
		$this->close_connection();	
	}

	/** 
	* Inicia a conexão com o banco de dados MySQL.
	* Os dados utilizados para fazer a conexão estão armazenados em constantes.
	* Essas constantes estão definidas no arquivo de config.php
	* A conexão é guardada na variável {@link $connection}
	* @access protected
	* @return void
	*/
	protected function open_connection(){
		$this->connection = mysql_connect(HOST, USERNAME,PASSWORD);
		if (!$this->connection){
			echo "Database connection failed :". mysql_error();	
		} else {
			$selected = mysql_select_db(DATABASE, $this->connection);
			if (!$selected){
				echo "Database selection failed: ". mysql_error();
			}
		}
	}

	/** 
	* Termina a conexao do banco de dados
	* a função termina a conexão com a função mysql_close e limpa a variável {@link $connection}
	* @return void
	*/ 

	protected function close_connection(){
		if($this->connection){
			mysql_close($this->connection);
			unset($this->connection);
		}
	}

	/**
	* Executa query's no banco de dados.
	* Essa função armazena a query passada por parâmetro na variável {@link $last_query}.
	* Executa a função mysql_query
	* Confirma o resultado com {@link confirm_query()} 
	* @param string $sql
	* @return resource
	*/

	public function query($sql){
		$this->last_query = $sql;
		$result = mysql_query ($sql);
		$this->confirm_query($result);
		return $result;
	}
	
	/**
	* Transforma o resultado o resource gerado por {@link query()} em array
	* @param resource $result
	* @return array
	*/
	
	public function fetch_array($result){
		$result_set = mysql_fetch_array($result);
		return $result_set;
	}
	
	/**
	* Escapa os caracteres especiais numa string para usar em uma instrução SQL
	* @param string $string
	* @return string
	*/
	
	public function escape_string($string){
		return mysql_real_escape_string($string);	
	}
	
	/**
	* Verifica a quantidade de linhas no banco de dados que de acordo com o resource gerado por {@link query()} 
	* @param resource $result
	* @return int
	*/
	
	public function num_rows($result){
		$amount = mysql_num_rows($result);
		return $amount;
	}
	
	/**
	* Verifica a qual foi o último id
	* Através da ultima inserção no banco de dados, essa função retorna a última linha inserida no banco que contenha id
	* @return int
	*/
	
	public function last_id(){
		return mysql_insert_id($this->connection);	
	}
	
	/**
	* Verifica a quantidade de linhas que foram afetadas com a última query gerada por {@link query()} 
	* @return int
	*/
	
	public function affected_rows(){
		return mysql_affected_rows($this->connection);	
	}
	
	/**
	* Transforma o Resource gerado por {@link query()} em um array onde cada posição representa uma linha do banco
	* @param resource $resource
	* @return array
	*/
	
	public function result_to_array($resource){
		$result_array = array();
		for ($i=0; $row = $this->fetch_array($resource); $i++){
			$result_array[$i] = $row;
		}
		return $result_array;
	}
	
	/**
	* Verifica se o resultado de uma query ao banco do dados foi realizado com sucesso.
	* Caso algum problema tenha ocorrido, uma mensagem será exibida na tela.
	* @return void
	*/
	
	protected function confirm_query($result){
		if (!$result){
			echo "Database query failed: ". mysql_error() . "<br /><br />";
			echo "Last SQL query: ". $this->last_query;
		}
	}
	
}

$database = new MySQLDatabase();
?>