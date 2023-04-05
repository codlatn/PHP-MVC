<?php 

namespace App\Controllers;

use System\Controller;

 class NotFoundController extends Controller{


    public function index()
    {

 
          
           $this->view->render('404');
  
     }

 
 
}
