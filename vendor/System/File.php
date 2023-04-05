<?php 
namespace System;

class File{


    private String $root;
    const DS = DIRECTORY_SEPARATOR;

    public function __construct($root)
    {
        $this->root = $root;

        // echo $this->getRoot();
    }

    public function getRoot(){
        return $this->root;
    }

    public function isFileExistes($fileName){
        return file_exists($this->to($fileName));
    }

    public function getFiles($file){
        require $this->to( $file );
    }

    public function toVendor($path){
        return $this->to('vendor/'.$path);
    }
    public function toApp($path){
  
        return $this->to('App/'.$path);
    }

    public function to($path){
      

        return  $this->root . static::DS . str_replace(['/','\\'],static::DS,  $path) ; 
    }

    
}