<?php 

namespace System;
use System\Application;
  class Route{

    private $app;
    private  $routes = [];
    private $notFound;

    public function __construct(Application $app)
    {
     $this->app = $app;       
    }

    //Not Found
    public function notFoundUrl($url){
        $this->notFound = $url;
    }


   

    public function add($url, $action, $requestMethod = 'GET'){

        $gaving = [
            'url' => $url,
            'pattren' => $this->gPattren($url) ,
            'action' => $this->getAction($action) ,
            'method' => $requestMethod 
        ];
        
         $this->routes[] = $gaving;
            return $this->routes;
        //pr($this->routes);
    }


    public function gPattren($url){
        $pattren = '#^';
        $pattren .=  str_replace(['{slug}', '{id}'], ['([a-zA-Z0-9-]+)','(\d+)'], $url);
        $pattren .= '$#';

        return $pattren;
    }

    public function getAction($action){

        $action = str_replace('/', '\\', $action);

        return strpos($action, '@') !== false ? $action : $action.'@index';

    }
    
 //getPrperRoute

 public function getProperRoute()
 {
    
    // echo "<pre>";
    // print_r($this->routes);
     foreach($this->routes as $route){
         if($this->isMatching($route['pattren'])){
            // echo  $route['pattren'];
            $args = $this->getArgsFrom($route['pattren']);
            list($controller, $method) = explode('@', $route['action']);
            //  pr($controller);
              return [$controller, $method, $args];
         
         } 
     }

     return $this->app->url->redirectTo($this->notFound);
    
 }

 public function isMatching($pattren){
     return preg_match($pattren, $this->app->request->url());
 }

 public function getRoutesArray(){
    return $this->routes;
 }

 public function getArgsFrom($pattren){
    preg_match($pattren, $this->app->request->url(),$matches);
    array_shift($matches);
    return $matches;
 }
 //Add New Route 
}