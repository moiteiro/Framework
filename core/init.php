<?php 

session_start();


/* ================================
	Including Abstract Classes 
===================================*/
require_once('classes/file.php');

/* ===============================
	Including core funcitions
==================================*/
require_once('routes.php');
require_once('dictionary.php');
require_once('core_functions.php');

/* ==========================
	System Definitions
============================*/
set_exception_handler('dflt_exception_handler');
set_error_handler('dflt_error_handler');

/* ============
	Configs
===============*/
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
require_once(INCLUDES_PATH.DS.'routes.php');



/* ================================================
================================================ */
$route_app = new System\Route();
$route_app->set_file_path(ROUTES_PATH);


/* ===================================
	System Operation Mode 
	(Development|Production)
======================================*/
if(OPERATIONAL_MODE == 'production'){
	
} else {

	$route_app->generate($route_apps);
	$route_app->generate_xml();
	$route_app->export_as_menu();
}


// carregando o dicionário.
$dictionary = new System\Dictionary(DICTIONARY_PATH);