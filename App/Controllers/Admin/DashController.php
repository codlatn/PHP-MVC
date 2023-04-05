<?php

namespace App\Controllers\Admin;

use JetBrains\PhpStorm\Internal\ReturnTypeContract;
use System\Controller;

use System\Validation;


class DashController extends Controller
{
 

  public function index(){
   
   
    $looginUser = $this->load->model('Login');
    // $sesstion = $this->session->get('login');
  
    // if($sesstion == $userData->user()->code){
    //   return $this->url->redirectTo('/admin');
     
    // } 

    if(!$looginUser->isLogin()){
      return $this->url->redirectTo('/admin/login');
    }else{
      if($looginUser->user()->user_group_id === 2){
        echo "Welcome {$looginUser->user()->first_name} ... !";
      }else{
        return $this->url->redirectTo('/');
      }
    }

    //pr($looginUser->user());
 


}

}