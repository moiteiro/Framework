<?php

// change this document to set the path of these folders

$path = __FILE__;

$path_level = 2;

for($i=0; $i < $path_level; $i++){
	$pos = strrpos($path,'\\');
	$path = substr($path, 0, $pos);
}

define("DS", "\\");
define("CORE_PATH", $path.DS."core".DS);
define("LIBS_PATH", $path.DS."lib".DS);
define("INCLUDES_PATH", $path.DS."includes".DS);
define("CLASSES_PATH", CORE_PATH.DS."classes".DS);

require_once(CLASSES_PATH."file.php");

?>