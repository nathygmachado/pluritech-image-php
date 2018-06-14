<?php
namespace ImagePhp\Exception;

use \Exception;

/**
 * Define uma classe de exceção
 */
class ImageException extends Exception{
    private $status;
    private $observation;
    // Redefine a exceção de forma que a mensagem não seja opcional
    public function __construct($message, $status, $code = 0, $observation = array(), Exception $previous = null) {
        // código
        $this->status      = $status;
        $this->observation = $observation;
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

    public function getException(){
        $exception = array( 'status'   => $this->status,
                            'message'  => $this->message,
                            'code'     => 'F'.sprintf("%02d", $this->code)
            );

        return array_merge($exception, $this->observation);
    }

}
