<?php

class Thumbnail{

    private $_original_name; // ainda n~ao =P

    private $_original_path; // a informacao que a class recebe de onde a imagem esta

    private $_original_image; // o sistema busca imagem real para pegar as dimensoes

    private $_original_extension; // a extensao que os thumbnails terao

    private $_original_image_width; // a informacao que a class recebe de onde a imagem esta

    private $_original_image_height; // o sistema busca imagem real para pegar as dimensoes

    private $_thumbnail_sufix; // sufixo determinado para o nome do thumbnail

    private $_thumbnail_name; // nome gerado com o nome origial mais o sufixo
 
    private $_t_width; // largura max do thumbnail

    private $_t_height; // altura max do thumbnail

    private $final_x;

    private $final_y;

    private $img_final;


    public function __construct($path, $thumbnail_sufix = "_thumb", $t_width = 120, $t_height = 120){

        $this->_original_path = $path;
        $this->_thumbnail_sufix = $thumbnail_sufix;
        $this->_t_width = $t_width;
        $this->_t_height = $t_height;
        $this->get_exetension();
        $this->create_thumb_name();
        $this->get_info_real_image();
        $this->resize();
        $this->create_canvas();
        $this->copy_image_into_the_canvas();
        $this->save_image();
    }

    
    public function get_thumb_path(){
        return $this->_thumbnail_name;
    }

    public function get_thumb_name(){

        $amount = 0;
        $array_name = array();

        $array_name = explode('/', $this->_thumbnail_name);
        $amount = count($array_name);
        return $array_name[$amount - 1];
    }

    /**
     * Cria o nome da nova imagem que será gerada.
     * @access private
     * @return void
     */
    private function create_thumb_name(){
        $array_name = explode('.', $this->_original_path);
        $this->_thumbnail_name = $array_name[0].$this->_thumbnail_sufix.$this->_original_extension;
    }

    /**
     * Pega as informações da imagem real. 
     * Largura e altura para que os calculos de redimensionamento seja feitos
     * @access private
     * @return void
     */
    private function get_info_real_image(){

        // lendo a imagem original

        if($this->_original_extension == '.jpge' || $this->_original_extension == '.jpg' )
            $this->_original_image = ImageCreateFromJPEG($this->_original_path);
        else if ($this->_original_extension == ".png")
            $this->_original_image = ImageCreateFromPng($this->_original_path);
        
        // pegando as dimensões
        $this->_original_image_width  = imagesx($this->_original_image); 
        $this->_original_image_height = imagesy($this->_original_image); 
    }

    /**
     * Fazendo calculo das dimenensões.
     * Calcula as dimensoes de acordo com a imagem original.
     * Os a largura ou/e altura máxima é fixada pela medida que for maior.
     * @access private
     * @return void
     */
    private function resize(){
        
        if($this->_original_image_width > $this->_original_image_height) {
            $this->final_x = $this->_t_width; 
            $this->final_y = floor($this->_t_width * $this->_original_image_height / $this->_original_image_width); 
        } else { 
            $this->final_x = floor($this->_t_height * $this->_original_image_width / $this->_original_image_height); 
            $this->final_y = $this->_t_height; 
        }
    }

    /**
     * Criando a estrutura que irá conter a imagem
     * @access private
     */
    private function create_canvas(){
        $this->img_final = imagecreatetruecolor($this->final_x,$this->final_y);
    }

    /**
     * Inserindo a imagem dentro da estrutura criada
     * @access private
     */
    private function copy_image_into_the_canvas(){

    ImageCopyResized($this->img_final, $this->_original_image, 0, 0, 0, 0, $this->final_x, $this->final_y, $this->_original_image_width, $this->_original_image_height);
    }

    /**
     * Salvando a imagem
     */
    private function save_image(){
    
        ImageJPEG($this->img_final, $this->_thumbnail_name);

        // liberando a memória.
        ImageDestroy($this->_original_image);
        ImageDestroy($this->img_final);
    }

    /**
     * Pegando a extensão do tipo do arquivo.
     * @return 
     */
    private function get_exetension(){
        $last_dot                  = strrpos($this->_original_path , '.');
        $this->_original_extension = substr( $this->_original_path, $last_dot );
    }
}