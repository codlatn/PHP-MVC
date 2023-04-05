<?php 

namespace App\Controllers;

use System\Controller;

class FooterController extends Controller{
    public function index()
    {
        
       $this->view->twig('inc/footer');
    }
}
