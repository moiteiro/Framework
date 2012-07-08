<?php 

namespace System;

/**
 * Class para a geração de menus da aplicação.
 * O menu é gerado a partir das rotas do sistema ou pode algum arquivo em xml.
 * @author Bruno Moiteiro <bruno.moiteiro@gmail.com>
 * @version 1.0
 * @copyright Copyright (c) 2012, Bruno Moiteiro
 */

class Menu{

	/**
	 * Variavel que conterá o caminho para o menu.xml
	 * @access private
	 * @var string
	 */
	private $_xml_menu_path;

	/**
	 * Variavel que conterá o arquivo xml do menu.
	 * @access private
	 * @var string
	 */
	private $_xml_menu;

	public function __construct($path = ""){
		$this->_xml_menu_path = $this->check_file($path);

	}

	/**
	 * Gera o menu da aplicacao a partir de um arquivo .xml.
	 * Apenas o menu eh gerado por essa funcao e é retornado em forma de array.
	 * @access public
	 * @return array
	 */
	public function menu_generator() {

		$xml = simplexml_load_file( $this->_xml_menu_path );

		$links = $xml->children();

		$menu = $this->expand_menu($links);

		return $menu;

	}

	public function submenu_generator() {}
	public function breadcrumbs_generator() {}


	/**
	 * Checa se o arquivo do menu existe.
	 * Se existir a funcao retorna o caminho do arquivo. Caso contrário, o sistema gera uma exceçao.
	 * @access private
	 * @param string $path
	 * @return void
	 */
	private function check_file($path){
		if(!file_exists($path)){
			throw new \Exception("Menu file doesnt exists on: $path", 1);
		}
		return $path;
	}


	/**
	 * Funcao recursiva que quebrar que percorre a estrutura xml e cria o menu.
	 * @access private
	 * @param array $links
	 * @return array
	 */
	private function expand_menu($links){

		$menu = array();

		$i = 0;

		foreach( $links as $link ) {

			$menu[$i]['title'] = (string)$link->title;
			$menu[$i]['url'] = (string)$link->url;

			if($link->attributes()){
				foreach($link->attributes() as $key => $value)
					$menu[$i]['attributes'][$key] = (string)$value;
			}

			if($link->links)
				$menu[$i]['submenu'] = $this->expand_menu($link->links->link);

			$i++;
		}
		return $menu;
	}
}

 ?>