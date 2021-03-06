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
        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="description" content="" /> 
        <meta name="keywords" content="Framework" /> 
        
        <!--Com essa tag nada ser� indexado-->
        <meta name="robots" content="noindex,nofollow">
        
        <!--Styles-->
        <link href="<?php echo WEBSITE ?>/design/stylesheets/style.css" rel="stylesheet" type="text/css" />
        
        
        <!--Scripts-->
		<script type='text/javascript' src='<?php echo WEBSITE ?>/scripts/jquery.js'></script>
        
        
    </head>
    
    <body>
    
		<?php include(VIEW_PATH.DS.'layouts'.DS.'messages.php') ?>
        
        <?php 
		
		if(file_exists(VIEW_PATH.DS.$route_app->controller.DS.$route_app->view.".php"))
			include(VIEW_PATH.DS.$route_app->controller.DS.$route_app->view.".php");
		?>
        
    </body>
    
</html>