<?php
// remover ao implementar
session_start();

class Security {
	
	// code for SHA-512
	private $salt_SHA_512 = '$6$rounds=5000$<!--Bruno Moiteiro-->$';
	private $salt_SHA_256 = '$5$rounds=5000$<!--Bruno Moiteiro-->$';
	
	//
	public function safe_form(){
		//seta essa variavel para 
		$_SESSION['security']['form'] = true;
	}
	
	public function is_safe_form(){
		// verifica se o formulario veio de um local conhecido
		// se o formulario veio de um local nao seguro os dados nao serao cadastrados
		return (isset($_SESSION['security']['form'])) ? true : false;
	}
	
	public function remove_safe_form(){
		// destroy a variavel
		if(isset($_SESSION['security']['form']))
			unset($_SESSION['security']['form']);
	}
	
	public function encrypt_512($string){
		// essa funcao retorna uma string de 160 caracteres
		return  base64_encode(crypt($string,$this->salt_SHA_512));
	}
	
	public function encrypt_256($string){
		// essa funcao retorna uma string de 100 caracteres
		return  base64_encode(crypt($string,$this->salt_SHA_256));
	}
}


$security = new Security();
$security->safe_form();

if($security->is_safe_form()){
	echo "it's safe, you can record these datas. <br />";
}
$security->remove_safe_form();
if(!$security->is_safe_form()){
	echo "it's not safe anymore. What you trying to do?";
}

echo "<hr />";

echo md5 ('moiteiro');

echo "<hr />";

echo $security->encrypt_256("moiteiro");

?>