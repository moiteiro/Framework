<?php 

namespace System;

/**
 * Classe para auxiliar as funcoes core do sistema.<br />
 * Todas as funcoes que manipularem arquivos devem hedar as caracteristicas dessa classe.
 * @author Bruno Moiteiro <bruno.moiteiro@gmail.com>
 * @version 1.0
 * @copyright Copyright (c) 2012, Bruno Moiteiro
 */

abstract class File {

	/**
	 * Armazena o caminho do arquivo.
	 * @access protected
	 * @var string
	 */
	protected $_file_path;


	/**
	 * Verifica se o arquivo existe.
	 * @access public
	 * @param strint $file
	 * @return boolean
	 */
	public function check_file ( $file ) {
		return file_exists( $file );
	}

	/**
	 * Retorna o endereço do arquivo.
	 * @access public
	 * @return string
	 */
	public function get_file_path() {
		return $this->_file_path;
	}

	/**
	 * Determina o endereço do arquivo a ser manipulado pela classe.
	 * @access public
	 * @param string $path
	 */
	public function set_file_path( $path ) {
		$this->_file_path = $path;
	}

	/**
	 * Escreve dentro de um arquivo.
	 * @access public
	 * @param string $content
	 * @return void
	 */
	public function write_file ( $content ) {

	}

	/**
	 * Adiciona o conteúdo no final do arquivo.
	 * @access public
	 * @param string $content
	 * @return void
	 */
	public function append_file ( $content ) {

	}
}