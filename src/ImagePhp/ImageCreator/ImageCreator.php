<?php
namespace ImagePhp\ImageCreator;

use \Exception;
use ImagePhp\ImageCreator\ImageGif as ImageGif;
use ImagePhp\ImageCreator\ImageJpeg as ImageJpeg;
use ImagePhp\ImageCreator\ImagePng as ImagePng;
use ImagePhp\Exception\FormatNotAccepted as FormatNotAccepted;

/**
 * Define uma classe de exceção
 */
class ImageCreator{
    private $image;
    private $accept_type = array(
        'image/png'  => 'png',
        'image/jpeg' => 'jpg',
        'image/gif'  => 'gif',
    );
    // Redefine a exceção de forma que a mensagem não seja opcional
    public function __construct($mime_type) {
        // código


    	switch ($this->accept_type[$mime_type]) {
		    case "jpg":
		        $this->image = new ImageJpeg();
		        break;
		    case "png":
		        $this->image = new ImagePng();
		        break;
		    case "gif":
		        $this->image = new ImageGif();
        		break;
        	default:
        		throw new FormatNotAccepted();
        		
		}
    }

    public function createImageByPhoto($photo, $image_path){
    	$this->image->createImageByPhoto($photo, $image_path);
    }

    public function createImageByPath($image_path){
    	return $this->image->createImageByPath($image_path);
    }

}
