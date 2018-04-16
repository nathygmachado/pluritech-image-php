<?php
namespace ImagePhp\Exception;

use \Exception;
use ImagePhp\Exception\ImageException;
/**
 * Define uma classe de exceção

 classe incompleta
 */
class ImageNotGenerate extends ImageException{

    // Redefine a exceção de forma que a mensagem não seja opcional
    public function __construct() {
        
        // garante que tudo está corretamente inicializado
        parent::__construct('Original Picture not generate','OriginalPictureNotGenerate', 03);
    }

    // personaliza a apresentação do objeto como string
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

}