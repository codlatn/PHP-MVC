<?php 

namespace System;

 
class Application{


 public static $instance = null;   
 
 private Array $container = [];

 private function __construct($file = null)
{
        //self::$instance = $this;

        $this->share('files', $file); 

        $this->setClasses();

        $this->loadFunctions();
}

public static function getInstance($file = null){
    if(is_null(self::$instance)){
        self::$instance = new static($file);
    }

    return self::$instance;
}

public function run(){

    $this->session->start();

    $this->files->getFiles('App/Routes/web.php');

    $this->files->getFiles('App/Routes/api.php');

    $this->request->setUrl();

    list($controller, $method, $args) = $this->route->getProperRoute(); 
    
    $output =   $this->load->action($controller, $method, $args);
 
    $this->response->setOutput($output);
    
    return $this->response->send();
}

//Magic to getGet 

public function __get($key)
{
     return $this->get($key);
}

private function setClasses(){

    spl_autoload_register([$this, 'loadClass']);

}


public function loadClass($name){
    
    // echo "<pre>";
    //  pr($name);

        if(strpos($name, 'App') === 0){
          $setFile =    $name . '.php';
        }else{
           $setFile =   'vendor/' . $name . '.php';
        }

        if($this->files->isFileExistes($setFile)){
           $this->files->getFiles($setFile);
        }

 
        
        
}


public function isSharing($key){
    return isset($this->container[$key]);
}

public function get($key){

//    print_r( $this->container );
   
    if(!$this->isSharing($key)){
        if($this->isCoreClass($key)){
             $this->share($key, $this->runObj($key)) ;
        }else{
            die($key . 'Class Not found');
        }
    }
    return  $this->container[$key];
   // return isset($this->container[$key]) ? $this->container[$key] : NULL;
}

private function share($key, $value){
    return  $this->container[$key] = $value;
}

public function getConteiner($key){
    return $this->container[$key];
}


protected function loadFunctions(){
    $this->files->getFiles('vendor/functions.php');
}


public function setCoreClasses(){
    return [
        'request' => 'System\\Http\\Request',
        'response' => 'System\\Http\\Response',
        'cookie' => 'System\\Cookie\\Cookie',
        'session' => 'System\\Session\\Session',
        'route' => 'System\\Route',
        'html' => 'System\\Html',
        'db' => 'System\\Database',
         'load' => 'System\\Loader',
        'view' => 'System\\View\viewFactory',
        'url' => 'System\\Url',
        'twigLoder' => 'System\\View\Template\\Twig\\Loader\\FilesystemLoader',
        // 'twigEnv' => 'System\\View\Template\\Twig\\Environment',
        'twig' => 'System\\View\Template\\Twig',
        'validation' => 'System\\Validation',
        //'model' => 'System\\Model',
    ];
}

public function isCoreClass($key){
    $cclass = $this->setCoreClasses();
    return isset($cclass[$key]);
}

public function runObj($key){
    $className = $this->setCoreClasses();
    $obj = $className[$key];
    return new $obj($this);

}

}