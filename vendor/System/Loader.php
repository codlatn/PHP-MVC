<?php 
namespace System;

use stdClass;
use System\Application;
class Loader{



    private $app;

    private  $controllers = [];

    private  $models = [];


    public function __construct(Application $app)
    {
        $this->app = $app;
    }


    public function action($controller, $method, array $args){
        $obj = $this->controller($controller);
        return call_user_func([$obj, $method], $args);
    }


    public function controller($controller)
    {
        $controller = $this->getControllerName($controller);
        //echo $controller;
        if(!$this->hasController($controller)){
            $this->addController($controller);
        }

        return $this->getController($controller);
    }

    //return boolean
    private function hasController($controller) : bool 
    {
        return array_key_exists($controller, $this->controllers);
    }

    //craete new obj and store in controllers container
    public function addController($controller)
    {
      //  echo $controller .' This From Loader';
       $obj = new $controller($this->app);
       $this->controllers[$controller] = $obj;
    }

    //return OBJ
    public function getController($controller) : object
    {
      return $this->controllers[$controller];
    }

    //return string
    private function getControllerName($controller) : string
    {
       $controller .= 'Controller';
        $controller = 'App\\Controllers\\'. $controller;

        return str_replace('/','\\',  $controller);
    }






    //Models Methods: 

    public function model($model) : object
    {
        $model = $this->getModelName($model);
        //echo $controller;
        if(!$this->hasModel($model)){
            $this->addModel($model);
        }

        return $this->getModel($model);
    }

     private function hasModel($model) : bool
    {
        return array_key_exists($model, $this->models);
    }

     public function addModel($model) : void
    {
        $obj = new $model($this->app);
        $this->models[$model] = $obj;
    }

    //return OBJ
    public function getModel($model) : object
    {
        return $this->models[$model];
    }

     //return string
     private function getModelName($model) : string
     {
        $model .= 'Model';
         $model = 'App\\Models\\'. $model;
 
         return str_replace('/','\\',  $model);
     }


}