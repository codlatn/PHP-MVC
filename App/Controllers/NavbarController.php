<?php 

namespace App\Controllers;

use System\Controller;

 
class NavbarController extends Controller{


    public function index()
    {
       
        $this->view->twig('inc/navbar');
    }

}