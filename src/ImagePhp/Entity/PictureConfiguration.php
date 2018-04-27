<?php

namespace ImagePhp\Entity;

use ImagePhp\Entity;
use \Exception;

class PictureConfiguration 
{


    private $width;
    private $height;
    private $thumb;
    private $thumb_width;
    private $thumb_height;
    private $water_mark;
    private $transparency;
    private $square;
    private $square_width;
    private $square_height;
    private $url;
    private $dir;


    /**
     * Construct
     */
    public function __construct($conf_picture){

   
        $this->setWidth($conf_picture['width']);      
        $this->setHeight($conf_picture['height']);      
        $this->setThumb($conf_picture['thumb']);      
        $this->setThumbWidth($conf_picture['thumb_width']);      
        $this->setThumbHeight($conf_picture['thumb_height']);      
        $this->setWaterMark($conf_picture['water_mark']);      
        $this->setTransparency($conf_picture['transparency']);      
        $this->setSquare($conf_picture['square']);      
        $this->setSquareWidth($conf_picture['square_width']);      
        $this->setSquareHeight($conf_picture['square_height']); 
        $this->setUrl($conf_picture['url']);  
        $this->setDir($conf_picture['dir']); 
    }

    
    /**
     * Set width configuration
     */
    public function setWidth($width){
        $this->width = $width;
    }
    
    /**
     * Set height configuration
     */
    public function setHeight($height){
        $this->height = $height;
    }
    
    /**
     * Set thumb configuration
     */
    public function setThumb($thumb){
        $this->thumb = $thumb;
    }
    
    /**
     * Set thumb_width configuration
     */
    public function setThumbWidth($thumb_width){
        $this->thumb_width = $thumb_width;
    }
    
    /**
     * Set thumb_height configuration
     */
    public function setThumbHeight($thumb_height){
        $this->thumb_height = $thumb_height;
    }
    
    /**
     * Set water_mark configuration
     */
    public function setWaterMark($water_mark){
        $this->water_mark = $water_mark;
    }
    
    /**
     * Set transparency configuration
     */
    public function setTransparency($transparency){
        $this->transparency = $transparency;
    }
    
    /**
     * Set square configuration
     */
    public function setSquare($square){
        $this->square = $square;
    }
    
    /**
     * Set square_width configuration
     */
    public function setSquareWidth($square_width){
        $this->square_width = $square_width;
    }
    
    /**
     * Set square_height configuration
     */
    public function setSquareHeight($square_height){
        $this->square_height = $square_height;
    }
    
    /**
     * Set url configuration
     */
    public function setUrl($url){
        $this->url = $url;
    }
    
    /**
     * Set dir configuration
     */
    public function setDir($dir){
        $this->dir = $dir;
    }

    /**
     * Get width configuration
     */
    public function getWidth(){
        return $this->width;
    }
    
    /**
     * Get height configuration
     */
    public function getHeight(){
        return $this->height;
    }
    
    /**
     * Get thumb configuration
     */
    public function getThumb(){
        return $this->thumb;
    }
    
    /**
     * Get thumb_width configuration
     */
    public function getThumbWidth(){
        return $this->thumb_width;
    }
    
    /**
     * Get thumb_height configuration
     */
    public function getThumbHeight(){
        return $this->thumb_height;
    }
    
    /**
     * Get water_mark configuration
     */
    public function getWaterMark(){
        return $this->water_mark;
    }
    
    /**
     * Get transparency configuration
     */
    public function getTransparency(){
        return $this->transparency;
    }
    
    /**
     * Get square configuration
     */
    public function getSquare(){
        return $this->square;
    }
    
    /**
     * Get square_width configuration
     */
    public function getSquareWidth(){
        return $this->square_width;
    }
    
    /**
     * Get square_height configuration
     */
    public function getSquareHeight(){
        return $this->square_height;
    }
    
    /**
     * Get url configuration
     */
    public function getUrl(){
        return $this->url;
    }
    
    /**
     * Get url configuration
     */
    public function getDir(){
        return $this->dir;
    }

}