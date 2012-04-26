<?php
	
	/**
	* Inclui todas as classes que forem requisitadas e não forem incluídos diretamente.
	* @param string #class_name
	*/
	function __autoload($class_name) {
		require_once MODEL_PATH.DS.$class_name.'.php';
	}
	/**
	* Cria um aviso do tipo notificação
	* Esse aviso é acessível na variável $_SESSION['flash']['notice'];
	* @param string $message
	* @return void
	*/
	function flash_notice(string $message){
		
		if(isset($message))
			$_SESSION['flash']['notice'] = $message;
	}
	
	/**
	* Cria um aviso do tipo alerta
	* Esse aviso é acessível na variável $_SESSION['flash']['warning'];
	* @param string $message
	* @return void
	*/
	function flash_warning(string $message){
		
		if(isset($message))
			$_SESSION['flash']['warning'] = $message;
	}
	
	/**
	* Cria um aviso do tipo dica
	* Esse aviso é acessível na variável $_SESSION['flash']['tip'];
	* @param string $message
	* @return void
	*/
	function flash_tip(string $message){
		
		if(isset($message))
			$_SESSION['flash']['tip'] = $message;
	}
	
	/**
	* Armazena no $_SESSION['history'] o número que for passado como parâmetro
	* @param int $page
	* @return void
	*/
	function set_history($page){
	
		$_SESSION['history'] = $page;
		
	}
	
	/**
	* Retorna o valor armazenado em $_SESSION['history'].
	* Se a variável com esse  valor existir ele retornará o que está armazenado, caso contrário, retornará 1
	* @return int
	*/
	function get_history(){
		
		return (isset($_SESSION['history']) ? $_SESSION['history'] : 1 );
		
	}
	
	/**
	* Apaga o valor da variável $_SESSION['history']
	* A função verifica se a $_SESSION['history'] está inicializada, se sim, ela remove o valor da variável
	* @return void
	*/
	function reset_history(){
		
		if(isset($_SESSION['history']))
			unset($_SESSION['history']);	
		
	}
	
	/**
	* Redireciona para o endereço passado como parâmetro
	* @param string $to
	* @return void
	*/
	function redirect_to($to){
		
		header("location:".WEBSITE.DS.$to);
		exit();
		
	}
	
	/**
	* Quebra o formato timestamp (Database) e retorna a apenas a data
	* A data retornada será no formato YYYY-MM-DD
	* @param string $timestamp
	* @return string
	*/
	function timestamp_to_date($timestamp){
		$timestamp = explode(" ",$timestamp);
		return $timestamp[0];
	}
	
	/**
	* Quebra o formato timestamp (Database) e retorna a apenas a o horário
	* O horário retornado será no formato HH:MM:SS
	* @param string $timestamp
	* @return string
	*/
	function timestamp_to_time($timestamp){
		$timestamp = explode(" ",$timestamp);
		return $timestamp[1];
	}
	
	/**
	* Converte o formato timestamp (Database) YYYY-MM-DD para DD/MM/YYYY
	* @param string $date
	* @return string
	*/
	function date_format_DMY($date){
		$date = explode('-',$date);
		$date = array_reverse($date);
		return implode('/',$date);	
	}

	/**
	* Funcao que lida com todas as exceptions
	* Toda vez que uma exceção for lançanda no sistema, essa função ira ser acionada
	* @param Object $exc
	* @return void
	*/
	function dflt_handler(Exception $exc){
		print "Exception: \n";
		$code = $exc->getCode();
		
		if(!empty($code)){
			printf("Error code:\n", $code);
		}
		
		print $exc->getMessage(). "\n";
		print "File: " . $exc->getFile()."\n";
		print "Line: " . $exc->getLine()."\n";
		exit(-1);
	}
	
	/**
	* Corta o texto e retorna  o conteúdo de acordo com o tamanho explicitado.
	* @param string $text
	* @param integer $size
	* @return string
	*/
	function cut_text($text, $size){
		
		$total = strlen($text);
		
		if($total > $size){
			$tmp_string = $text;
			
			$tmp_string = substr($text,$size);
			$first_space = strpos($tmp_string, " ");
			
			// significa que não ha espaço até o final da string.
			// Ela terá que ser incluida totalmente.
			if($first_space != false){
				$text = substr($text,0 ,$size+$first_space);	
				$text .= " ...";
			}
			
		}
		
		return $text;
	}
	
	/**
	* Retorna o nome do arquivo
	* @param string $path
	* @return string
	*/
	function get_filename($path){
		return basename($path,'.php');
	}



?>