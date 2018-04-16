<?php
namespace ImagePhp\Exception;

use \Exception;
use ImagePhp\Exception\ImageException;
/**
 * Define uma classe de exceção

 classe incompleta
 */
class MinimalResolutionPictureNotAchieved extends ImageException{

    // Redefine a exceção de forma que a mensagem não seja opcional
    public function __construct($width_destino, $height_destino) {
        
        // garante que tudo está corretamente inicializado
        parent::__construct("Resolução mínima não atingida. Resolução indicada: ".$width_destino." x ".$height_destino.".", 'MinimalResolutionPictureNotAchieved',02);
    }

    // personaliza a apresentação do objeto como string
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

}