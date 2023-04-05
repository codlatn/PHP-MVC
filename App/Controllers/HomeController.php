<?php 

namespace App\Controllers;

use System\Controller;

use App\models\LoginModel;
class HomeController extends Controller{


    public function index()
    {

   
      $looginUser = $this->load->model('Login');

     
        $data['isLogin'] = $looginUser->isLogin();
       
         $data['userInfo'] =  json_decode(json_encode($looginUser->user()), true);
   
        $data['logout'] = $this->url->link('/logout');

          $this->url->link('/logout');
          
         $data['header'] = $this->load->controller('Header');

         
         $data['footer'] =  $this->load->controller('Footer');
          
          $data['navbar'] = $this->load->controller('Navbar');

 
         $this->view->twig('home', $data);

     }

     public function logout(){
      $looginUser = new LoginModel($this->app);
      $looginUser->logout();

      return $this->url->redirectTo('/');
   
     
     
     }
 
}
