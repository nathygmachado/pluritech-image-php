<?php

namespace ImagePhp;


use \Exception;
use ImagePhp\Entity\PictureConfiguration as PictureConfiguration;
use ImagePhp\Entity\Picture as Picture;
use ImagePhp\Exception\FormatNotAccepted as FormatNotAccepted;
use ImagePhp\Exception\ImageNotGenerate as ImageNotGenerate;
use ImagePhp\Exception\MinimalResolutionPictureNotAchieved as MinimalResolutionPictureNotAchieved;
use ImagePhp\ImageCreator\ImageCreator as ImageCreator;

class GeneratorImageSDK{

    private $water_mark = null;   
    private $conf_picture = null;
    private $picture = null;
    private $accept_type = array(
        'image/png'  => 'png',
        'image/jpeg' => 'jpg',
        'image/gif'  => 'gif'

    );

    /**
     * Construct
     */
    public function __construct($conf_picture, $water_mark_path = false ){

        if($water_mark_path){
            $this->water_mark = $water_mark_path;//caminho onde se encontra a marca d'agua dentro de uploads
        }        
        $this->setPictureConfiguration($conf_picture);
    }


    /**
     * Cria uma photo para adicionar as configurações pré-definidas.
     */    
    public function generatePhoto($base64){
              
        $image_name = null;
        $photo      = null;
        $image_data = base64_decode($base64);
        $f          = finfo_open();
        $mime_type  = finfo_buffer($f, $image_data, FILEINFO_MIME_TYPE);

        if(!array_key_exists($mime_type, $this->accept_type)){

            throw new FormatNotAccepted();
        }else{
            $photo = imagecreatefromstring($image_data);                                    
        }
    
        return array(
            'picture'   => $photo,
            'mime_type' => $mime_type,
        );

    }

    public function automaticResize($width_destino = false, $height_destino = false){
 
        if(empty($this->getPicture()->getPhoto())){

            throw new ImageNotGenerate();;
        }
        $width_origem    = $this->getPicture()->getWidth();
        $height_origem   = $this->getPicture()->getHeight();
        
        if(!$width_destino){
            $width_destino   =  $this->getPictureConfiguration()->getWidth();

        }

        if(!$height_destino){
            $height_destino  = $width_destino   =  $this->getPictureConfiguration()->getHeight();
        }
        $prop_origem     = $width_origem / $height_origem;
        $prop_destino    = $width_destino / $height_destino;        

        //Validação básica
        if ($height_destino > $height_origem && $width_destino > $width_origem) {

            throw new MinimalResolutionPictureNotAchieved($width_destino, $height_destino);
        }
        else if($height_destino == $height_origem && $width_destino == $width_origem){
            $picture = $this->getPicture()->getPhoto();
        } else{
            if ($height_origem >= $height_destino && $width_origem < $width_destino) { // redimensionar imagem origem para altura destino (mantendo proporção de origem)
                $picture = $this->resize_by_height($width_destino, $height_destino);
            }
            else if ($height_origem < $height_destino && $width_origem >= $width_destino) { // redimensionar imagem origem para largura destino (mantendo proporção de origem)
                $picture = $this->resize_by_width($width_destino, $height_destino);
            }
            else {
                if ($prop_origem > $prop_destino) { // redimensionar imagem origem para altura destino (mantendo proporção de origem) 
                    $picture = $this->resize_by_height($width_destino, $height_destino);
                } else { // redimensionar imagem origem para largura destino (mantendo proporção de origem)
                    $picture = $this->resize_by_width($width_destino, $height_destino);
                }
            }
        }

        return array(
            'picture'   => $picture,
            'mime_type' => $this->getPicture()->getMimeType(),          
        );  
    }

    private function resize_by_height($width_destino, $height_destino){

        
        if(empty($this->getPicture()->getPhoto())){

            throw new ImageNotGenerate();;
        }

        $altura_calculada  = $height_destino; // iguala altura da origem pro destino
        $largura_calculada = intval(($this->getPicture()->getWidth() * $altura_calculada) / $this->getPicture()->getHeight());

        if ($height_destino === $this->getPicture()->getHeight()) {
            $new_proportional_photo = $this->getPicture()->getPhoto();
        } else {
            $new_proportional_photo = imagecreatetruecolor($largura_calculada, $altura_calculada); // imagem diminuida de forma proporcional

            if(!empty($this->getPictureConfiguration()->getTransparency())){
                $this->setTransparency($new_proportional_photo);
            } else{
                $this->setDefaultBackgroundColor($new_proportional_photo);
            }

            imagecopyresampled($new_proportional_photo, $this->getPicture()->getPhoto(), 0, 0, 0, 0, $largura_calculada, $altura_calculada, $this->getPicture()->getWidth(), $this->getPicture()->getheight());
        }
        
        $dif = $largura_calculada - $width_destino;
        if ($dif > 0) {
            //Cortada a imagem
            $foto_final = imagecreatetruecolor($width_destino, $height_destino);

            if(!empty($this->getPictureConfiguration()->getTransparency())){
                $this->setTransparency($foto_final);
            } else{
                $this->setDefaultBackgroundColor($foto_final);
            }
            imagecopyresampled($foto_final, $new_proportional_photo, 0, 0, ($dif/2), 0, $width_destino, $height_destino, $width_destino, $height_destino);
        } else {
            $x = round($dif / 2) * -1; // coeficiente de centralização
            $foto_final = imagecreatetruecolor($width_destino, $height_destino);

            if(!empty($this->getPictureConfiguration()->getTransparency())){
                $this->setTransparency($foto_final);
            } else{
                $this->setDefaultBackgroundColor($foto_final);
            }
            imagecopyresampled($foto_final, $new_proportional_photo, $x, 0, 0, 0, $largura_calculada, $altura_calculada, $largura_calculada, $altura_calculada); 
        }

        return $foto_final;
    }

    private function resize_by_width($width_destino, $height_destino){

        
        if(empty($this->getPicture()->getPhoto())){

            throw new ImageNotGenerate();;
        }
        $largura_calculada = $width_destino; // iguala altura da origem pro destino
        $altura_calculada  = intval(($this->getPicture()->getHeight() * $largura_calculada) / $this->getPicture()->getWidth());

        if ($width_destino === $this->getPicture()->getWidth()) { 
            $new_proportional_photo = $this->getPicture()->getPhoto();
        } else {
            $new_proportional_photo = imagecreatetruecolor($largura_calculada, $altura_calculada);

            if(!empty($this->getPictureConfiguration()->getTransparency())){
                $this->setTransparency($new_proportional_photo);
            } else{
                $this->setDefaultBackgroundColor($new_proportional_photo);
            }

            imagecopyresampled($new_proportional_photo, $this->getPicture()->getPhoto(), 0, 0, 0, 0, $largura_calculada, $altura_calculada, $this->getPicture()->getWidth(), $this->getPicture()->getHeight());
        }
        
        $dif = $altura_calculada - $height_destino;
        if ($dif > 0) { 
            //Corta a imagem
            $foto_final = imagecreatetruecolor($width_destino, $height_destino);

            if(!empty($this->getPictureConfiguration()->getTransparency())){
                $this->setTransparency($foto_final);
            } else{
                $this->setDefaultBackgroundColor($foto_final);
            }

            imagecopyresampled($foto_final, $new_proportional_photo, 0, 0, 0, ($dif/2), $width_destino, $height_destino, $width_destino, $height_destino);
        } else {
            $y = round($dif / 2) * -1; // coeficiente de centralização
            $foto_final = imagecreatetruecolor($width_destino, $height_destino);

            if(!empty($this->getPictureConfiguration()->getTransparency())){
                $this->setTransparency($foto_final);
            } else{
                $this->setDefaultBackgroundColor($foto_final);
            }

            imagecopyresampled($foto_final, $new_proportional_photo, 0, $y, 0, 0, $largura_calculada, $altura_calculada, $largura_calculada, $altura_calculada); 
        }

        return $foto_final;

 
    }
 
    /**
     * Cria uma imagem a partir das configurações pre-selecionadas.
     */ 
    public function createImages(){
        
        $image_name = null;
        
        if(empty($this->getPicture()->getPhoto())){

            throw new ImageNotGenerate();
        }

        $mime_type = $this->getPicture()->getMimeType();
        $photo = $this->getPicture()->getPhoto();            
        
        $image_name = $this->generateUniqueName($mime_type);
   
        $this->savePicture($mime_type, $photo, $image_name);

        if(!empty($this->getPictureConfiguration()->getThumb())){
            $this->createThumb($image_name, $mime_type);
        }

        if(!empty($this->getPictureConfiguration()->getSquare())){
            $this->createSquare($image_name, $mime_type);
        }            
    
        return array(
            'picture_name' => $image_name
        );

    } 
    /**
     * realiza o upload das fotos
     */ 
    public function savePicture($mime_type, $photo, $image_name){
        
        if(empty($photo)){

            throw new ImageNotGenerate();
        }
        
        
        $this->createDirectory();        

        //Verifica se usa marca d'agua 
        if(!empty($this->getPictureConfiguration()->getWaterMark())){
            $photo = $this->putWaterMark($mime_type, $photo);
        }

        $image_creator = new ImageCreator($mime_type);
        $image_creator->createImageByPhoto($photo, $this->getPictureConfiguration()->getDir().$image_name);

    }



    /**
     * Recupera uma imagem - Base url é unica para cada configuração
     */    
    public function getImage($image){

        return $this->getPictureConfiguration()->getUrl().$image;
    }
    /**
     * Cria um diretório se ele não existir
     */    
    public function createDirectory(){

       if(!file_exists($this->getPictureConfiguration()->getDir())){
            mkdir($this->getPictureConfiguration()->getDir(), 0777);
        }
    }

    /*
     * Insere a marca de àgua na imagem
     */
    private function putWaterMark($mime_type, $photo){

        $padding   = 10;
        $opacidade = 50;

        $mark = imagecreatefrompng($this->water_mark);
        imagealphablending($mark, FALSE);
        imagesavealpha($mark, TRUE);

        $imagem = $photo;

        $mark_size   = getimagesize($this->water_mark);
        $mark_width  = $mark_size[0];
        $mark_height = $mark_size[1];

        $dest_x  = imagesx($photo) - $mark_width - $padding;
        $dest_y  = $mark_height - $padding;

        imagecopy($imagem,$mark,$dest_x,$dest_y,0,0,$mark_width,$mark_height);
        
        return $imagem;
    }

    /*
     * Recupera a thumb de uma imagem
     */
    public function getThumb($image){

        $image_thumb  = str_replace(".", "_thumb.", $image);

        return $image_thumb;
    }

    /*
     * Recupera o formato quadrado de uma imagem
     */
    public function getSquare($image){

        $image_square  = str_replace(".", "_square.", $image);

        return $image_square;
    }

    /**
     * Delete image
     */
    public function deleteImages($image_name){

        if($this->getPictureConfiguration()->getThumb()){
            $image_thumb  = $this->getThumb($image_name);
            $this->deleteImage($image_thumb);
        }
        if($this->getPictureConfiguration()->getSquare()){
            $image_square  = $this->getSquare($image_name);
            $this->deleteImage($image_square);
        }
        $this->deleteImage($image_name);
    }

    /**
     * Delete image
     */
    public function deleteImage($image_name){


        $path_picture = $this->getPictureConfiguration()->getDir().$image_name;
        @unlink($path_picture);
    }

    /**
     * Gera um nome unico para a imagem.
     */
    private function generateUniqueName($mime_type){
        $temp_name = rand(1, 50).microtime();
        $name = date('Ymd')."_".md5($temp_name).".".$this->accept_type[$mime_type];
        return $name;
    }

    /**
     * Gera uma thumb para a imagem.
     */
    public function createThumb($image_name, $mime_type){


        if(empty($this->getPicture()->getPhoto())){

            throw new ImageNotGenerate();
        }

        $image_thumb_name = $this->getThumb($image_name);
;
        list($width, $height) = getimagesize($this->getPictureConfiguration()->getDir().$image_name);

        $image_p = imagecreatetruecolor($this->getPictureConfiguration()->getThumbWidth(), $this->getPictureConfiguration()->getThumbHeight());
        $this->setTransparency($image_p);


        $image_creator = new ImageCreator($mime_type);
        $image = $image_creator->createImageByPath($this->getPictureConfiguration()->getDir().$image_name);

        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $this->getPictureConfiguration()->getThumbWidth(), $this->getPictureConfiguration()->getThumbHeight(), $width, $height);

        $this->savePicture($mime_type, $image_p, $image_thumb_name);
    }

    /**
     * Gera uma imagem quadrada para a imagem.
     */
    public function createSquare($image_name, $mime_type){

        if(empty($this->getPicture()->getPhoto())){

            throw new ImageNotGenerate();
        }

        $image_square_name = $this->getSquare($image_name);
        $photo = $this->automaticResize($this->getPictureConfiguration()->getSquareWidth(), $this->getPictureConfiguration()->getSquareHeight());
        
        $this->savePicture($mime_type, $photo['picture'], $image_square_name);  
    }

    /**
     * Set transparency
     */
    private function setTransparency(&$photo){
        $color = imagecolorallocatealpha($photo, 0, 0, 0, 127);
        imagefill($photo, 0, 0, $color);
        imagesavealpha($photo, true);
    }

    /**
     * Set default background color
     * http://www.uff.br/cdme/matrix/matrix-html/matrix_color_cube/matrix_color_cube_br.html
     */
    private function setDefaultBackgroundColor(&$photo){
        $color = imagecolorallocate($photo, 0, 0, 0);
        imagefill($photo, 0, 0, $color);
    }

    public function setPictureConfiguration($conf_picture){
        $this->conf_picture = new PictureConfiguration($conf_picture); 
    }

    public function getPictureConfiguration(){
        return $this->conf_picture;
    }
    public function setAcceptedType($accept_type){
        $this->accept_type = $accept_type; 
    }

    public function getAcceptedType($accept_type){
        return $this->accept_type;
    }

    public function setPicture($photo){
        $this->picture = new Picture($photo);
    }

    public function getPicture(){
        return $this->picture;
    }
}