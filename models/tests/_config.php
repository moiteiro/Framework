<?php

// change this document to set the path of these folders

$path = __FILE__;

$path_level = 3;

for($i=0; $i < $path_level; $i++){
	$pos = strrpos($path,'\\');
	$path = substr($path, 0, $pos);
}

define("MODEL_PATH", $path."\\models\\");
define("LIBS_PATH", $path."\\lib\\");

define('DATABASE','grokitc_gerenciador-de-salas');
define('HOST','localhost');
define('USERNAME','grokitc_moiteiro');
define('PASSWORD','=Lu^5@gPP,+I');

?>