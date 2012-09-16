<?php 

//require_once(MODEL_PATH.DS.'session.php');

// incluindo gerador do menu
require_once(LIBS_PATH.DS.'menu.php');


// gerando o menu da aplicacao.
$application_menu = new System\Menu(INCLUDES_PATH.DS.'menu.xml');
$menu = $application_menu->menu_generator();

?>