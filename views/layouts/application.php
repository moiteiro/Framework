<?php

// prevent the direct access
defined('_PREVENT-DIRECT-ACCESS') or die ("Access restrict");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    
    	
        <title>Framework</title>
        
        <meta name="author" content="Bruno Moiteiro">
        <meta http-equiv="content-language" content="pt-br">
        
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
        <meta name="description" content="Free Web tutorials on HTML, CSS, XML" /> 
        <meta name="keywords" content="HTML, CSS, XML" /> 
        
        <!--Com essa tag nada será indexado-->
        <meta name="robots" content="noindex,nofollow">
        
        <!--Styles-->
        <link href="/design/stylesheets/style.css" rel="stylesheet" type="text/css" />
        
        
        <!--Scripts-->
		<script type='text/javascript' src='../../scripts/jquery.js'></script>
        
        
    </head>
    
    <body>
    
		<?php include(VIEW_PATH.DS.'layouts'.DS.'messages.php') ?>
        
        <?php 
		
		if(file_exists(VIEW_PATH.DS.$route->controller.DS.$route->view.".php"))
			include(VIEW_PATH.DS.$route->controller.DS.$route->view.".php");
		?>
        
    </body>
    
</html>