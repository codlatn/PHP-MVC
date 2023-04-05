<?php 

namespace App\Controllers;

use System\Controller;

use App\models\LoginModel;
class HeaderController extends Controller{


    public function index()
    {
        $data['appTitle'] = 'Codlatn - PHP freamwork';
        $data['rtlStyle'] = $this->url->link('public/themes/codlatn/frontend/css/ltr_app.css');
        $data['ltrStyle'] = $this->url->link('public/themes/codlatn/frontend/css/ltr_app.css');
        $data['lang'] = 'en';
        $this->view->twig('inc/header', $data);
    }

}