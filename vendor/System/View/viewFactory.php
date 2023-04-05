<?php 

namespace System\View;

use System\Application;

// use Twig\Environment;

// use Twig\Loader\FilesystemLoader;

 class viewFactory{
    

    private $app;

    private $twig = null;
    
    public function __construct(Application $app)
    {
        $this->app = $app;
    }



   // render php views;
    public  function render($viewPath, $data = []){
        echo new  View($this->app->files,$viewPath, $data);
    }

    //render with twig
    public  function twig($file, $data = []){
      
        if($this->twig === null){
           $this->app->files->getFiles('/vendor/library/Twig/vendor/autoload.php');
            $loader = new \Twig\Loader\FilesystemLoader('D:/xampp/htdocs/phpmvc/App/Views/');
            $twig = new \Twig\Environment($loader, [
                'cache' => 'D:/xampp/htdocs/phpmvc/cach/temp',
                'debug' => true
            ]);
        }
       
        echo $twig->render($file . '.twig', $data);
    }



}