<?php
namespace ImagePhp\Exception;

use \Exception;
use ImagePhp\Exception\ImageException;
/**
 * Define uma classe de exceção

 classe incompleta
 */
class FormatNotAccepted extends ImageException{
    // Redefine a exceção de forma que a mensagem não seja opcional
    public function __construct() {

        // garante que tudo está corretamente inicializado
    	$observation = array('accepted_types'  =>  array('.gif','.png','.jpg','.jpeg' ));
        parent::__construct('Format not accepted. Only accepted gif, png or jpg','FormatNotAccepted', 01, $observation);

    }

    // personaliza a apresentação do objeto como string
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

}