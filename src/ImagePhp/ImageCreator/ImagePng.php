<?php
namespace ImagePhp\ImageCreator;

use \Exception;

/**
 * Define uma classe de exceção
 */
class ImagePng{


    public function __construct() {

    }

    public function createImageByPhoto($photo, $image_path){
    	imagepng($photo, $image_path);
    }

    public function createImageByPath($image_path){
    	return imagecreatefrompng($image_path);
    }

}
