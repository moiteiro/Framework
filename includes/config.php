<?php

require('/libs/core_functions.php');
// Definindo funcoes customizadas para serem exibidas caso haja uma Exception, Notice ou Warning.
set_exception_handler('dflt_exception_handler');
set_error_handler('dflt_error_handler');


// verificando se o servidor eh local

$local 		= $_SERVER['SERVER_ADDR'] == "127.0.0.1" ? true : false ;

//									-------LOCAL-------	: -------SERVER-------		
$host		= $local ? "localhost" 						: "";
$db			= $local ? "test"							: "";
$user 		= $local ? "root"							: "";
$pass 		= $local ? ""								: "";
$website 	= $local ? "http://framework"				: "";

	
// Define uma camada de seguraça
// Previne o acesso direto aos arquivos no view
define('_PREVENT-DIRECT-ACCESS',1);


// Define directory structure
define('DS', DIRECTORY_SEPARATOR);


// Define host
define('WEBSITE',$website);


// Define serves root
define('SERVER_ROOT',$_SERVER['DOCUMENT_ROOT']);


// MVC
define('CONTROLLER_PATH',SERVER_ROOT.DS.'controllers');
define('MODEL_PATH',SERVER_ROOT.DS.'models');
define('VIEW_PATH',SERVER_ROOT.DS.'views');


// Database
define('DATABASE',$db);
define('HOST',	  $host);
define('USERNAME',$user);
define('PASSWORD',$pass);


//Pagination
define('PER_PAGE', 3);


// Includindo libs
require_once(SERVER_ROOT.DS.'libs'.DS.'database.php');
require_once(SERVER_ROOT.DS.'libs'.DS.'database_object.php');
require_once(SERVER_ROOT.DS.'libs'.DS.'functions.php');
require_once(SERVER_ROOT.DS.'libs'.DS.'validation.php');
require_once(SERVER_ROOT.DS.'libs'.DS.'security.php');


// Tipos
// Para validação de dados
define('STRING'		,'string');
define('STRING-VOID','string-void');
define('INT'		,'integer');
define('FLOAT'		,'float');
define('CPF'		,'cpf');
define('EMAIL'		,'email');

?>
