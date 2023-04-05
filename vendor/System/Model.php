<?php 

namespace System;

abstract class Model {


    //store app obj
    protected  $app;

    protected $table;

    public function __construct(Application $app)
    {
        $this->app = $app;
    } 


    //call shared object dynmcily 

    public function all(){
        return $this->db->all($this->table);
    }

    public function get($id){
        return $this->where('id = ?', $id)->single($this->table);
    }

    public function __get($key)
    {
        return $this->app->get($key);
    }

    public function __call($method, $args)
    {
        return call_user_func_array([$this->app->db, $method], $args);
    }

   

}