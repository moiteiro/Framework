<?php

	// Configurando o style do aviso.
    
    

	/**
	* Funcao que lida com todas as exceptions
	* Toda vez que uma exceção for lançanda no sistema, essa função ira ser acionada
	* @param Object $exc
	* @return void
	*/
	function dflt_exception_handler(Exception $exc){
		$code = $exc->getCode();
		
		$title_style = "style='border:1px solid #ccc;color:white;background:#252525;line-height:30px;padding:0px 10px' ";
		$data_style = "style='border:1px solid #ccc;padding:0px 10px' ";

		if(empty($code)){
			$code = "";
		}
		
		$message = $exc->getMessage();
		$file =  $exc->getFile();
		$line = $exc->getLine();
		
		echo "<table style='border-collapse:collapse; margin:10px;'><thead>";
		echo "<tr><td {$title_style} width='90px'><b>EXCEPTION</b></td><td {$title_style}>Error code: {$code}</td></tr>";
		echo "</thead><tbody>";
		echo "<tr><td {$data_style}>Message</td><td {$data_style}>{$message}</td></tr>";
		echo "<tr><td {$data_style}>Location</td><td {$data_style}>Exception on line $line in file $file</td></tr>";
		echo "<tr><td {$data_style}>System</td><td {$data_style}>PHP " . PHP_VERSION . " (" . PHP_OS . ")</td></tr>";
		echo "</tbody></table>";

		exit(1);
	}

	/**
	* Funcao que lida com todas as exceptions
	* Toda vez que uma exceção for lançanda no sistema, essa função ira ser acionada
	* @param integer $errno numero que representa o erro.
	* @param string $errstr a mensagem de erro.
	* @param string $errfile o nome do arquivo onde o erro foi gerado.
	* @param integer $errline linha onde o erro foi gerado.
	* @return void
	*/
	function dflt_error_handler($errno, $errstr, $errfile, $errline){

		if (error_reporting() == 0) {
			// Verifica se o codigo (numero) do erro existe
			// ou se o error foi suprimido com um @
			return;
	    }

	    $title_style = "style='border:1px solid #ccc;color:white;background:#252525;line-height:30px;padding:0px 10px' ";
		$data_style = "style='border:1px solid #ccc;padding:0px 10px' ";

		switch ($errno) {

		case E_NOTICE:
			echo "<table style='border-collapse:collapse;margin:10px;'><thead>";
			echo "<tr><td {$title_style} width='90px'><b>NOTICE</b></td><td {$title_style}>$errstr</td></tr>";
			echo "</thead><tbody>";
			echo "<tr><td {$data_style}>Location</td><td {$data_style}>Fatal error on line $errline in file $errfile</td></tr>";
			echo "<tr><td {$data_style}>System</td><td {$data_style}>PHP " . PHP_VERSION . " (" . PHP_OS . ")</td></tr>";
			echo "</tbody></table>";
			break;

	    case E_WARNING:
			echo "<table style='border-collapse:collapse;margin:10px;'><thead>";
			echo "<tr><td {$title_style} width='90px'><b>NOTICE</b></td><td {$title_style}>$errstr</td></tr>";
			echo "</thead><tbody>";
			echo "<tr><td {$data_style}>Location</td><td {$data_style}>Fatal error on line $errline in file $errfile</td></tr>";
			echo "<tr><td {$data_style}>System</td><td {$data_style}>PHP " . PHP_VERSION . " (" . PHP_OS . ")</td></tr>";
			echo "</tbody></table>";
			break;

		default:
			echo "Unknown error type: [$errno] $errstr<br />\n";
			break;
	    }
	}
	
	unset($data_style);
	unset($title_style);
?>