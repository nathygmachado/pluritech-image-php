<?php
namespace ImagePhp\Exception;

use \Exception;

/**
 * Define uma classe de exceção
 */
class ImageException extends Exception{
    private $status;
    // Redefine a exceção de forma que a mensagem não seja opcional
    public function __construct($message, $status, $code = 0, Exception $previous = null) {
        // código
        $this->status = $status;
        // garante que tudo está corretamente inicializado
        parent::__construct($message, $code, $previous);
    }

    // personaliza a apresentação do objeto como string
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

    public function getStatus() {
        return $this->status;
    }

}
