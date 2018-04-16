<?php

namespace ImagePhp\Entity;

use ImagePhp\Entity;
use \Exception;

class Picture 
{

    private $photo;
    private $image_name;
    private $image_path;
    private $mime_type;
    /**
     * Construct
     */
    public function __construct($photo){

        $this->setPhoto($photo['picture']);         
        $this->setMimeType($photo['mime_type']);
    }

    /**
     * Set photo configuration
     */
    public function setPhoto($photo){
        $this->photo = $photo;
    }


    /**
     * Set mime_type configuration
     */
    public function setMimeType($mime_type){
        $this->mime_type = $mime_type;
    }

    /**
     * Get photo configuration
     */
    public function getPhoto(){
        return $this->photo;
    }
  
    /**
     * Get photo configuration
     */
    public function getMimeType(){
        return $this->mime_type;
    }
    
    /**
     * Get width configuration
     */
    public function getWidth(){
        return imagesx($this->getPhoto());
    }
    
    /**
     * Get height configuration
     */
    public function getHeight(){
        return imagesy($this->getPhoto());
    }
    
      /**
     * Set photo configuration
     */
    public function setImageName($image_name){
        $this->image_name = $image_name;
    }
  
  
    /**
     * Set image_path configuration
     */
    public function setImagePath($image_path){
        $this->image_path = $image_path;
    }


    /**
     * Get name configuration
     */
    public function getImageName(){
        return $this->image_name;
    }
    
    /**
     * Get name configuration
     */
    public function getImagePath(){
        return $this->image_path;
    }
}