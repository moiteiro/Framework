<?php 

session_start();

require_once('routes.php');
require_once('core_functions.php');
require_once('/includes/routes.php');
require_once('/includes/config.php');
// Definindo funcoes customizadas para serem exibidas caso haja uma Exception, Notice ou Warning.
set_exception_handler('dflt_exception_handler');
set_error_handler('dflt_error_handler');


$route = new System\Route($routes);