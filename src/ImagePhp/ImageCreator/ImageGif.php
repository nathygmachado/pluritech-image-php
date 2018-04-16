<?php
namespace ImagePhp\ImageCreator;

use \Exception;

/**
 * Define uma classe de exceção
 */
class ImageGif{


    public function __construct() {

    }

    public function createImageByPhoto($photo, $image_path){
    	imagegif($photo, $image_path, 100);
    }

    public function createImageByPath($image_path){
    	return imagecreatefromgif($image_path);
    }

}
