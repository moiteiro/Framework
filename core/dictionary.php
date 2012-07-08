<?php 

namespace System;

/**
 * Classe responsável por fazer a traduçao e conversao de todo o sistema.
 * @author Bruno Moiteiro <bruno.moiteiro@gmail.com>
 * @version 1.0
 * @copyright Copyright (c) 2012, Bruno Moiteiro
 */
class Dictionary extends File {

	/**
	 * Armazena um XML de palavras que devem ser tratadas como exceçao no sistema.
	 * @access private
	 * @var array
	 */
	private $_words_exception;


	public function __construct( $path ) {
		if(!$this->check_file( $path ) ) {
			throw new Exception("Erro ao carregar o dicionário.");
		}

		$this->set_file_path( $path );
		$this->_words_exception = simplexml_load_file( $path );
	}
	/**
	 * Retorna o singular de uma palavra.<br/>
	 * Caso a palavra nao esteja dentro das excecoes, o sistema irá remover o `s` do final da palavra.
	 * Caso a palavra nao esteja dentro das execeoes e nem possua um `s` como ultima letra, o palavra será retornada do mesmo jeito que foi passada pra funcao.
	 * @access public
	 * @param string $word
	 * @return string
	 */
	public function get_single( $word ) {
		$requested_word = $this->_words_exception->xpath( "//words/word[plural[text()='$word']]" );
		if( $requested_word )
			return (string)$requested_word[0]->single;

		$word_size = strlen( $word );
		return ( substr( $word, $word_size -1 ) == "s" ) ? substr( $word, 0, $word_size -1 ) : $word;
	}

	/**
	 * Retorna o plural de uma palavra.<br/>
	 * Caso a palavra nao esteja dentro das excecoes, o sistema irá adicionar o `s` do final da palavra.
	 * Caso a palavra nao esteja dentro das execeoes ou já possua um `s` como ultima letra, o palavra será retornada do mesmo jeito que foi passada pra funcao.
	 * @access public
	 * @param string $word
	 * @return string
	 */
	public function get_plural( $word ) {
		$requested_word = $this->_words_exception->xpath( "//words/word[single[text()='$word']]" );
		if( $requested_word )
			return (string)$requested_word[0]->plural;

		$word_size = strlen( $word );
		return ( substr( $word, $word_size -1 ) == "s" ) ? $word : $word."s" ;
	}

	private function parse_xml(){
		//implemenar
	}

}