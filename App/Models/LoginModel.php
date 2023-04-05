<?php

namespace App\models;

use System\Model;

class LoginModel extends Model{


    protected $table = 'users';

    protected $userdata =[];

    public function isValidInBD($email,$password){

       
        $user =  $this->where('email = ?' , $email)->single($this->table);
  
        

       if(!$user){
        return false;
       } 

       $this->userdata = $user;
       return password_verify($password, $user->password);
   
     
       
       
    }


    public function user(){
        return $this->userdata;
    }


    public function isLogin(){
       if($this->cookie->has('login')){
        $code = $this->cookie->get('login');
       }elseif ($this->session->has('login')) {
        $code = $this->session->get('login');
       }else{
        $code = '';
       }

       $user = $this->where('code = ?' , $code )->single($this->table);

       if(!$user){
        return false;
       }else{
        $this->userdata = $user;

        return true;
       }


    }

    public function logout(){
         if($this->cookie->has('login')){
          $this->cookie->remove('login');
          $this->cookie->destroy('login');
       }else{
       $this->session->remove('login');
       $this->session->destroy();
       } 
        
       $this->userdata = [];
    
       return true;
       
    }

    



}