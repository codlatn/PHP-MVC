<?php 

namespace System\Session;
use System;

class Session{

    protected $app;

    public function __construct(System\Application $app)
    {
        $this->app = $app;
    }

    public function start(){
        ini_set('session.use_only_cookies', 1);
        if(!session_id()){
            session_start();
        }
    }
    public function all(){
        pr($_SESSION);
    }
    public function set($key,$val){
        if(!$this->has($key)){
            $_SESSION[$key] = $val;
        }

        
    }
    public function get($key,$defualt = null){
       return array_container($_SESSION, $key, $defualt);
    }

    public function has($key){
        return isset($_SESSION[$key]);
    }

    public function remove($key){
        unset($_SESSION[$key]);
    }
    public function destroy(){
       session_destroy();
       unset($_SESSION);
    }

    public function pull($key){
        $val = $this->get($key);
        $this->remove($key);
        return $val;
    }
}