<?php

namespace App\Controllers\Admin;

use JetBrains\PhpStorm\Internal\ReturnTypeContract;
use System\Controller;

use System\Validation;


class LoginController extends Controller
{

  private $inputErrors;

  private $dbErrors;

  private $userData;

  public function index()
  {
    $looginUser = $this->load->model('Login');

    if ($looginUser->isLogin()) {
      return $this->url->redirectTo('/admin');
    }

    $data['errors'] = $this->errors;
    $data['access'] = $this->url->link('/admin/login/submit');
    $this->view->twig('admin/login', $data);
   // $this->view->render('admin/login', $data);

  }

  public function login()
  {

 
    

    if (!$this->requestValid()) {

   
      //return $this->index();
   
      return $this->response->json(['errors' => $this->errors, 'status' => 401]);
     
      
    } else {

      $loginModel = $this->load->model('Login');

      $userLogin = $loginModel->user();

      if ($this->request->post('remmber')) {

        $this->cookie->set('login', $userLogin->code);
      } else {

        $this->session->set('login', $userLogin->code);
      }

      $jsonData = [
        'name' => $userLogin->first_name,
       'redirect' => $this->url->link('/admin') ,
        'status' => 200
      ];
      return $this->response->json($jsonData);

      //pr($_POST);
    // return $this->url->redirectTo('/admin');
    }
  }

  protected function requestValid()
  {
    $email = $this->request->post('email');
    $password = $this->request->post('password');
    // Chk Inputs
    $val = new Validation;
    $val->name('email')->value($email)->isEmail($email)->required();
    $val->name('password')->value($password)->customPattern('[A-Za-z0-9]{5,15}')->min(5)->max(15)->required();

    if (!$val->isSuccess()) {
      $this->errors[] = $val->displayErrors();
    }

    if (empty($this->errors)) {
      //Ckeck Data In BD
      $login = $this->load->model('Login');

      if (!$login->isValidInBD($email, $password)) {
        $this->errors[] = 'سجلاتنا تفيد بعدم تواجدكم فيها';
      }
    }


    return empty($this->errors);
  }

  
}
