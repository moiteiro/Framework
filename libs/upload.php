<?php

class Upload {
	
	/**
	* Armazena o nome do arquivo original
	* @access protected
	* @var string
	*/
	protected $file_name;
	
	/**
	* Armazena o tipo do arquivo original (a extensão)
	* @access protected
	* @var string
	*/
	protected $file_type;
	
	/**
	* Armazena o tamanho do arquivo original em bytes
	* @access protected
	* @var string
	*/
	protected $file_size;
	
	/**
	* Armazena o caminho completo do arquivo, incluse o nome, na pasta temporária do servidor.
	* @access protected
	* @var string
	*/
	protected $file_tmp_name;
	
	/**
	* Armazena um erro do arquivo, caso exista.
	* @access protected
	* @var string
	*/
	protected $file_error;
	
	/**
	* O caminho completo, a partir da raiz, de onde o arquivo será armazendo.
	* @access protected
	* @var string
	*/
	protected $path;
	
	/**
	* Um array com todos os mimetypes permitidos a serem upados
	* @access protected
	* @var array
	*/
	protected $extensions;
	
	/**
	* Um array contendo todos os erros gerados pela class
	* @access protected
	* @var array
	*/
	protected $errors;

	/**
	 * Variável que contém a permissão de sobrescreve o arquivo.
	 * 
	 * Caso o seu valor seja true, o arquivo será sobreescrito.
	 * Caso contrário o arquivo será descartado.
	 * @access protected
	 * @var bool
	 */
	protected $replace;

	/**
	 * A lista de todos os erros ao fazer um upload de um arquivo.
	 * @access protected
	 * @var array
	 */
	 protected $list_of_errors;

	 /**
	  * Armazena o tamanho max que um arquivo pode ter.
	  * @access protected
	  * @var int
	  */
	  protected $max_upload_size;

	public function __construct($file, $path, $extensions = array() , $replace = false){
		
		$this->errors			= array();
		$this->path				= $path;
		$this->extensions		= $extensions;
		$this->replace			= $replace;
		#$this->max_upload_site	= $this->get_max_upload_size();
		#$this->list_of_errors 	= $this->create_list_of_errors();

		// seta os parametros (nome do arquivo, tamanho, ... nas respectivas propriedades)
		$this->set_file_attributes($file);
		
		// checando se não houve nenhum error na submissão do arquivo.
		if($this->check_errors()){

			// checando se a extensao do arquivo faz parte dos tipos permitidos.
			if($this->check_extensions()){

				// Verificando se o arquivo nao existe. Se ja existir, verificar se poder ser sobescrevido
				if( (!$this->file_exists()) || ($this->replace) ){
					
					// Se o arquivo não for armazenado, ele envia um erro para o array de errors
					if(!$this->store_file())
						$this->set_errors("O arquivo n&atilde;o p&ocirc;de ser armazenado");
				}
			}
		}
	}
	
	public function get_path(){
		return $this->path.DS.$this->file_name;	
	}
	
	public function get_errors(){
		return $this->errors;	
	}
		
	public function get_extension(){
		return $this->file_type;
	}

	/**
	* Organiza todos os atributos do arquivo, passando de um array para propriedades da propria class
	* @access protected
	* @param array $file
	*/
	protected function set_file_attributes($file){
		$this->file_name 		= $file['name'];
		$this->file_type 		= $file['type'];
		$this->file_size 		= $file['size'];
		$this->file_tmp_name 	= $file['tmp_name'];
		$this->file_error 		= $file['error'];
	}
	
	/**
	* Verifica se o arquivo é do tipo permitido para ser upado.
	* @access protected
	* @return bool
	*/
	protected function check_extensions(){

		// quando essa propriedade estiver vazia significa que todas as extensoes sao permitidas.
		if(!$this->extensions)
			return true;
		
		foreach($this->extensions as $key => $extension){
			
			if($extension == $this->file_type)
				return true;	
		}
		$this->set_errors("Formato de arquivo n&atilde;o permitido.");
		return false;
	}
	
	/**
	* Checa se houve algum error na submissão do arquivo
	* @access protected
	* @return bool
	*/
	protected function check_errors(){
		
		if ($this->file_error > 0) {
			$this->set_errors("Error code:" . $this->file_error);
			return false;
  		}
  		return true;
	}
	
	/**
	* Verifica se o arquivo já existe
	* @access protected
	* @return bool
	*/
	protected function file_exists(){
		
		if(file_exists($this->path .DS. $this->file_name ))
			return true;
      	return false;
	}
	
	/**
	* Armazena o arquivo na pasta explicitada na declarão da classe
	* @return bool
	*/
	protected function store_file(){
		
		return move_uploaded_file( $this->file_tmp_name, $this->path.DS.$this->file_name  );
	}
	/**
	 * Insere um error em um array de erros.
	 * 
	 * @access private
	 * @param string $error
	 * @return void
	 */
	private function set_errors($error){
		$this->errors[] = $error;
	}

	/**
	 * Retorna o tamanho max de que um arquivo poder ter para ser upado em MB.
	 * @access private
	 * @return int
	 */
	private function get_max_upload_size() {
		$max_upload		= (int)(ini_get('upload_max_filesize'));
		$max_post		= (int)(ini_get('post_max_size'));
		$memory_limit	= (int)(ini_get('memory_limit'));

		return min($max_upload, $max_post, $memory_limit);
	}


	private function create_list_of_errors(){
		// implementar
	}
}