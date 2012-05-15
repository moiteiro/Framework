<?php
// *****************//
// Controller Config
// *****************//

// Object Name
// ************
$object = $objects = "default";
// Class Name
// ************
$Class = "Default";


// esse código será rodado quando for chamado por ajax!
if(!isset($route->view)){
	
	$route['view'] = $_GET['view'];
	require_once("../includes/config.php");

	$route['controller'] = get_filename(__FILE__);	
}

// inclua todas as classes necessárias
#require_once(MODEL_PATH.DS."file.php");

switch($route->view){
	
	case "index":
	case "list":
	
		$$objects = $Class::find_all();
		
	break;
	
	case "show":
		
		$$object = $Class::find_by_id($params['id']);
		
	break;
	
	case "new":
		
		// caso essa variável sejá igual a 1, os dados que estiverem em $params serão inseridos no form
		// essa variável será usada em caso de erro de cadastro para que o usuário não precise preencher novamente
		$repopulate = 0;
		
		// caso tenha havido algum erro no cadastro, essa variável irá preencher novamente o formulário
		if (isset($_SESSION['params'])){
			$repopulate = 1; // nos forms, essa variável será checada para poder inserir os dados nos campos
			$params = $_SESSION['params'];
			
		}
		
	break;
	
	case "create":
		
		// Guardando informção caso seja necessário redirecionar
		// *****************************************************
		$_SESSION['params'] = $params;
		
		// Todos as mensagens de erro serão concatenadas nessa variável
		$error_message = "";
		
		// Se tudo estiver ok o cadastro será inserido
		$its_fine = true;
		
		// *****************//
		// Tratando as datas
		// *****************//

		
		// *****************//
		// Validar os Dados
		// *****************//
		
		$$object = new $$Class();
		// pegando todos os campos da tabela de usuários e seus respentivos tipos
		$db_fields = $$object->get_attributes_type();
		
		// campos da tabela que não serão avalidados
		$not_evaluate = array("id");
		$validation->avoid_fields($not_evaluate);
		
		// validando os dados submetidos
		$validation->validate_fields($params, $db_fields);
		
		// ver o resultado das validações
		// echo $validation->get_validation_result();
		
		// se a quantidade de erros for maior do que zero, o usuário terá que informar novamente os dados
		if($validation->get_errors() != 0) {
			
			$_SESSION['params'] = $params;
			
			
			flash_tip("DEBUG: <br />Atencao, esse error foi gerado na validacao dos dados <br /> Retire essa função e implemente validacao via JS");
			
			// redirecionado para a pagina de cadastro
			redirect_to($route->controller.DS."new");
		}
		
		
		// ************************//
		// Verificando Duplicidade
		// ************************//
		
		#if(!$$object->is_unique("collunm_name",$params['form_field'])) {
		#}
		
		
		// ****************//
		// Cadastrar Dados
		// ****************//
		
		// setando os dados nos atributos
		$$object->set_attributes($params);
			
		// inserindo no banco
		$result = $$object->create();
		
		// *******************//
		// Confirmar Cadastro
		// *******************//
		
		if($result){
			flash_notice("O cadastro foi realizado com sucesso!");
			unset($_SESSION['params']);
		} else {
			flash_warning("O cadastro n&aacute;o p&ocirc;de ser realizado. Talvez o sistema esteja inst&aacute;vel.<br />
							Entre em contato com o Suporte");
		}
		
		redirect_to($route->controller);
		
	break;
	
	case "edit":
		
		// Cadastro no Banco
		$$object = $Class::find_by_id($params['id']);
		
		// caso essa variável sejá igual a 1, os dados que estiverem em $params serão inseridos no form
		// essa variável será usada em caso de erro de cadastro para que o usuário não precise preencher novamente
		
		$repopulate = 1;
		
		// caso tenha avido algum erro no cadastro, essa variável irá preencher novamente o formulário
		if (isset($_SESSION['params'])){
			 // nos forms essa variavel será checada para poder inserir os dados nos campos
			$params = $_SESSION['params'];
		} else {
			
			// Um usuário temporário é criado apenas para pegar os campos do banco de dados
			$object_tmp = new $Class();
			$db_fields = $object_tmp->get_attributes_type();
			
			// Liberando memória
			unset($object_tmp);
			
			foreach($db_fields as $attribute=>$type){
				$params[$attribute] = $$object->$attribute;
			}
		}
			
	break;
	
	case "alter":
		
		$_SESSION['params'] = $params;

		// Todos as mensagens de erro serão concatenadas nessa variável
		$error_message = "";
		
		// Se tudo estiver ok o cadastro será inserido
		$its_fine = true;
		
		// *****************//
		// Tratando as Dados
		// *****************//
	
		// *****************//
		// Validar os Dados
		// *****************//
		
		$$object = new $Class();
		// pegando todos os campos da tabela de usuários e seus respentivos tipos
		$db_fields = $$object->get_attributes_type();
		
		// campos da tabela que não serão avalidados
		$not_evaluate = array("id");
		$validation->avoid_fields($not_evaluate);
		
		// validando os dados submetidos
		$validation->validate_fields($params, $db_fields);
		
		// ver o resultado das validações
		// echo $validation->get_validation_result();
		
		// se a quantidade de erros for maior do que zero, o usuário terá que informar novamente os dados
		if($validation->get_errors() != 0) {
			
			$_SESSION['params'] = $params;
			
			
			flash_tip("DEBUG: <br />Atencao, esse error foi gerado na validacao dos dados <br /> Retire essa função e implemente validacao via JS");
			
			// redirecionado para a pagina de cadastro
			redirect_to($route->controller.DS.$params['id'].DS."edit");
		}
		
		
		
		// Pegando o antigo cadastro no banco para fazer as comparações
		$old_record = $Class::find_by_id($params['id']);
		
		// ************************//
		// Verificando Duplicidade
		// ************************//
		
		// Primeiro verificasse se o valor verificado no banco de dados eh diferente
		// do novo valor submetido. Caso seja diferente, verificasse se o novo valor não existe
		// no banco de dados.

		#if($old_record->form_field != $params['form_field'])
		#	if(!$$object->is_unique("collumn",$params['form_field'])) {
		#}
		
		
		// ****************//
		// Alterar Dados
		// ****************//
		
		// setando os dados nos atributos
		$$object->set_attributes($params);
			
		
		// *******************//
		// Confirmar Alteração
		// *******************//
		
		
		// Caso os dados antigos sejam iguais aos submetidos, o update não será realizado mas uma mensagem de confirmação será exibida
		if($Class::is_same($$object, $old_record))
			$result = true;
		else {
			// inserindo no banco
			$result = $$object->update();
		}
		
		if($result){
			flash_notice("O cadastro foi alterado com sucesso!");
			unset($_SESSION['params']);
		} else {
			flash_warning("O cadastro n&aacute;o p&ocirc;de ser alterado. Talvez o sistema esteja inst&aacute;vel.<br />
							Entre em contato com o Suporte");
		}
		
		redirect_to($route->controller);
		
	break;
	
	case "delete":
		
		$$object = new $Class();
		$$object->id = $params['id'];
		
		if($$object->delete()){
			flash_notice("O cadastro foi removido com sucesso!");
		} else {
			flash_warning("O cadastro n&aacute;o p&ocirc;de ser alterado. Talvez o sistema esteja inst&aacute;vel.<br />
							Entre em contato com o Suporte");	
		}
		
		redirect_to($route->controller);
		
	break;
	
}
?>