<?php 

namespace System;

abstract class Controller {


    //store app obj
    protected  $app;

    protected $errors = [];
    public function __construct(Application $app)
    {
        $this->app = $app;
    } 


    //call shared object dynmcily 

    public function __get($key)
    {
        return $this->app->get($key);
    }

}