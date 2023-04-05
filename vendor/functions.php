<?php 
use System\Application;

//Functions (Helpers);

if(! function_exists('pr')){
    function pr($data){
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
}


if(! function_exists('array_container')){
    function array_container($array, $key, $default = null){

       return isset($array[$key]) && isset($array) ? $array[$key] : $default;
       
    }
}


if(! function_exists('_e')){
    function _e($values){
       return htmlspecialchars($values);
    }
}

if(! function_exists('assets')){
    function assets($path){
        $app = Application::getInstance();
        return $app->url->link('public/'.trim($path, '/'));
        
    }
}

if(! function_exists('url')){
    function url($path){
        $app = Application::getInstance();
        return $app->url->link($path);
        
    }
}
