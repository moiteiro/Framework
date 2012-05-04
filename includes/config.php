<?php

require('/libs/core_functions.php');
// Definindo funcoes customizadas para serem exibidas caso haja uma Exception, Notice ou Warning.
set_exception_handler('dflt_exception_handler');
set_error_handler('dflt_error_handler');

$routes = array(
				
				//home
				
				array('url'=>'/^\/$/','controller'=>'application','view'=>'home'),
				
				//session
				
				array('url'=>'/^\/session\/login\/?$/','controller'=>'session','access'=>'login'),
				array('url'=>'/^\/session\/logout\/?$/','controller'=>'session','access'=>'logout'),
				
				//users
				
				//array('url'=>'/^\/users\/list\/(?P<page>\d+)\/?$/','controller'=>'users','view'=>'index'),
				//array('url'=>'/^\/users\/create\/?$/','controller'=>'users','view'=>'create'),
				//array('url'=>'/^\/users\/(?P<id>\d+)$/','controller'=>'users','view'=>'show'),
				//array('url'=>'/^\/users\/(?P<id>\d+)\/edit\/?$/','controller'=>'users','view'=>'edit'),
				//array('url'=>'/^\/users\/alter\/?$/','controller'=>'users','view'=>'alter'),
				//array('url'=>'/^\/users\/(?P<id>\d+)\/delete\/?$/','controller'=>'users','view'=>'delete'),
				
				);

$common_routes = array("list","new","create","edit","alter","delete");


// verificando se o servidor eh local

$local 		= $_SERVER['SERVER_ADDR'] == "127.0.0.1" ? true : false ;

//									-------LOCAL-------	: -------SERVER-------		
$host		= $local ? "localhost" 						: "mysql.brunomoiteiro.com";
$db			= $local ? "projetos_gerenciador_de_salas"	: "projetos_gerenciador_de_salas";
$user 		= $local ? "moiteiro"						: "moiteiro";
$pass 		= $local ? "br201087"						: "br201087";
$website 	= $local ? "http://framework"				: "http://framework.brunomoiteiro.com";

	
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
