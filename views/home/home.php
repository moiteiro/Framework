<?php

// prevent the direct access
defined('_PREVENT-DIRECT-ACCESS') or die ("Access restrict");

?>

<div class="jquery_tab">

    <div class="content_block">
        <h2 class="jquery_tab_title">Painel de Controle</h2>
        
        <a class="dashboard_button button3" href="<?php echo WEBSITE.DS.'users'.DS.'list'.DS.'1' ?>">
            <span class="dashboard_button_heading">Usu&aacute;rios</span>
            <span>Edite Todos os usu&aacute;rios</span>
        </a><!--end dashboard_button-->

		<a class="dashboard_button button1" href="<?php echo WEBSITE.DS.'classrooms'.DS.'list'.DS.'1' ?>">
            <span class="dashboard_button_heading">Salas</span>
            <span>Edite Todos as salas</span>
        </a><!--end dashboard_button-->
        
        <a class="dashboard_button button14" href="<?php echo WEBSITE.DS.'config' ?>">
            <span class="dashboard_button_heading">Configura&ccedil;&otilde;es</span>
            <span>Editar configura&ccedil;&otilde;es e op&ccedil;&otilde;es b&aacute;sicas do sistema</span>
        </a><!--end dashboard_button-->

        <h2>Informa&ccedil;&otilde;es e configura&ccedil;&otilde;es</h2>
        <div class="content-box box-grey">
            <h4>Lorem ipsum</h4>
            <p>Dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>	
            <h4>Commodo consequat</h4>
            <p>Dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>
        
        <div class="content-box box2">
            <h4>Consectetur adipisicing</h4>
            <p>Elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
        </div>
        
    </div><!--end content_block-->
    
</div><!-- end jquery_tab -->