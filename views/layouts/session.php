<?php

// prevent the direct access
defined('_PREVENT-DIRECT-ACCESS') or die ("Access restrict");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
        <title>Gerenciador de Salas</title>
    
        <link href="/design/stylesheets/style.css" rel="stylesheet" type="text/css" />
                
    </head>
	<body>
        <div id="login">
        
            <div id="login-form">
            
                <form action="<?php echo WEBSITE.DS.'session'.DS.'login'?>" method="post">
                
                    <label for="username">Nome do Usu&aacute;rio: </label>
                    <input type="text" id="username" name="username" autocomplete="off" class="input-medium" />
                    
                    <label for="password">Senha: </label>
                    <input type="password" id="password" name="password" autocomplete="off" class="input-medium" />
                    
                    <p class="forgot_pw"><a href="javascript:void(0)">Esqueceu a senha? </a></p>
                    
                    <br /><br />
                    <input type="submit" id="logar" class="submit-small" value="Logar">
                    
                </form>
                
            </div>
            
        </div>
        
	</body>
</html>