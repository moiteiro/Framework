<?php

/** 
* Class que manipula as rotas do sistema. As rotas devem ser definidas no arquivo /config/routes.php
* As rotas sao checadas de acordo com a url do navegador.
* A class ainda provê a funcionalidade de exporta as rotas para XML, assim como tratá-las diretamente.
* 
* @author Bruno Moiteiro <bruno.moiteiro@gmail.com>
* @version 1.0
* @copyright Copyright (c) 2012, Bruno Moiteiro
*/
class Route {

	/**
	 * Armazena o valor do controller.
	 * @access public
	 * @var string
	 */
	public $controller;

	/**
	 * Armazena o valor do view.
	 * @access public
	 * @var string
	 */
	public $view;

	/**
	 * Armazena as rotas criadas pelo sistema.
	 * @access private
	 * @var array
	 */
	private $_routes = array();

	/**
	 * Contem as rotas declaradas no sistema.
	 * @access private
	 * @var array
	 */
	private $_routes_container = array();

	/**
	 * Contem os padroes das rotas.
	 * @access private
	 * @var array
	 */
	private $_routes_pattern;

	/**
	 * Contem os padroes das rotas.
	 * @access private
	 * @var array
	 */
	private $_default_route_pattern = array("url"=>"/^\/__controller__\/__view__\/?$/" ,"controller"=>"__controller__","view"=>"__view__");

	/**
	 * Rotas iniciais para o funcionamento do sistema.
	 * Essas rotas são definidas aqui porque nao seguem o padrão do restante do sistema.
	 * @access private
	 * @var array
	 */
	private $_predefined_routes;

	public function __construct($routes){
		$this->_routes_container = $routes;
		$this->_routes_pattern = self::get_routes_pattern();
		$this->_predefined_routes = self::get_predefined_routes();
		$this->create_routes_list();
		$this->insert_predefined_routes();
	}


	/**
	 * Funcao que cria as rotas de acordo com os padroes do sistema.
	 * As rotas definidas pelo usuario serao modificadas dentro dos padores 
	 * @access private
	 */
	private function create_routes_list(){

		foreach($this->_routes_container as $key => $value){

			// essa variavel serve para que o valor original $_routes_pattern nao seja alterado
			$routes_pattern = $this->_routes_pattern;

			// pegando o valor correto do controller.
			if(!is_array($value)){
				$controller = $value;
			} else {
				$controller = $key;
				if(isset($value['remove'])){
					self::remove_routes_from_list($value['remove'], $routes_pattern);
				} 
				if(isset($value['add'])){
					self::add_routes_in_the_list($value['add'], $routes_pattern);
				}
				if(isset($value['add_by_reg_exp'])){
					// Implementar.
				}
			}

		$routes_pattern = self::replace_controller($controller, $routes_pattern);
		$this->_routes = array_merge($this->_routes, array_values($routes_pattern));
		}
	}

	/**
	 * Verifica se a url coencide com as rotas do sistema.
	 * A funcao insere em $matches o url que coencidiu com a expressao regular
	 * @access public 
	 * @param string $url
	 * @param mixed $matches
	 * @return bool
	 */
	public function check_url($url, &$matches){
		foreach($this->_routes as $route)
			if(preg_match($route['url'],$url,$matches)){
				$this->controller = $route['controller'];
				$this->view       = $route['view'];
				return true;
			}
		return false;
	}

	/**
	 * Exporta as rotas on formato XML.
	 * @access protected
	 * @return void
	 */
	protected function create_XML_routes(){
		//implementar
	}

	/**
	 * Seta os padroes das rotas na variavel @link{$_routes_pattern}
	 * @access private
	 * @return array
	 */
	static private function get_routes_pattern(){

		$pattern = array(
							"index" 	=> array('url'=>'/^\/__controller__\/?$/'						,'controller'=>'__controller__','view'=>'index'),
							"list" 		=> array('url'=>'/^\/__controller__\/list\/(?P<page>\d+)\/?$/'	,'controller'=>'__controller__','view'=>'index'),
							"new" 		=> array('url'=>'/^\/__controller__\/new\/?$/'					,'controller'=>'__controller__','view'=>'new'),
							"create" 	=> array('url'=>'/^\/__controller__\/create\/?$/'				,'controller'=>'__controller__','view'=>'create'),
							"show" 		=> array('url'=>'/^\/__controller__\/(?P<id>\d+)$/'				,'controller'=>'__controller__','view'=>'show'),
							"edit" 		=> array('url'=>'/^\/__controller__\/(?P<id>\d+)\/edit\/?$/'	,'controller'=>'__controller__','view'=>'edit'),
							"alter" 	=> array('url'=>'/^\/__controller__\/alter\/?$/'				,'controller'=>'__controller__','view'=>'alter'),
							"delete" 	=> array('url'=>'/^\/__controller__\/(?P<id>\d+)\/delete\/?$/'	,'controller'=>'__controller__','view'=>'delete'),
						);
		return $pattern;
	}

	/**
	 * Substitui o valor de $controller na rota.
	 * @access private
	 * @param string $controller
	 * @param string $route
	 */
	private function replace_controller($controller, $routes){
		foreach($routes as $key => &$route)
			$route = str_replace("__controller__", $controller, $route);
		return $routes;
	}

	/**
	 * Substitui o valor de $view na rota.
	 * @access private
	 * @param string $view
	 * @param string $route
	 * @return string
	 */
	private function replace_view($view, $route){

		return str_replace("__view__", $view, $route);
	}

	/**
	 * Remove as rotas da listagem.
	 * @param string $exception
	 * @param array $routes
	 * @return void
	 */
	private function remove_routes_from_list($remove, &$routes){

		if(!is_array($remove) && isset($routes[$remove])){
			unset($routes[$remove]);
		} else if(is_array($remove)) {

			foreach ($remove as $remove_route) {
				if(array_key_exists($remove_route, $routes))
					unset($routes[$remove_route]);
			}

		}
	}

	/**
	 * Adiciona novas rotas a um controller.
	 * As novas rotas segue o padrao encontrado em @link{$_routes_pattern}
	 * A funcao recebe a variavel por referencia e por isso nao ha retorno.
	 * @param string|array $add
	 * @param array $routes
	 * @return void
	 */
	private function add_routes_in_the_list($add, &$routes){

		if(!is_array($add)){
			$add = array($add);
		}
		foreach($add as $new_view){
			if(array_key_exists($new_view, $routes)){
				throw new Exception("This route ($add) cannot be added because is already set. ", 1);
			} else {
				$new_route = array("{$new_view}" => self::replace_view($new_view, $this->_default_route_pattern));
				$routes = array_merge($routes, $new_route);
			}
		}
	}

	/**
	 * Insere todas as rotas predefinidas na variavel @link{$_predifined_routes} para que seja tratada pelo sistema.
	 * @access private
	 * @return array
	 */
	private function get_predefined_routes(){
		$predefined = array(
							array("url"=>'/^\/?$/' ,"controller"=>"application","view"=>"index")
						);

		return $predefined;
	}

	/**
	 * Insere as rotas predifinidas do sistema na listagem das rotas.
	 * @access private
	 * @return void
	 */
	private function insert_predefined_routes(){
		$this->_routes = array_merge($this->_routes, $this->_predefined_routes);
	}
}