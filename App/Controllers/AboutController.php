<?php 

namespace App\Controllers;

use System\Controller;

class AboutController extends Controller{
    public function index()
    {
             $data['name'] = 'Fahad';
            
             $this->view->render('about', $data);

     }
}
