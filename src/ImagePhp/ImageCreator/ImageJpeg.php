<?php
namespace ImagePhp\ImageCreator;

use \Exception;

/**
 * Define uma classe de exceção
 */
class ImageJpeg{


    public function __construct() {

    }

    public function createImageByPhoto($photo, $image_path){
    	imagejpeg($photo, $image_path, 100);
    }

    public function createImageByPath($image_path){
    	return imagecreatefromjpeg($image_path);
    }

}
