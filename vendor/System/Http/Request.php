<?php 

namespace System\Http;
class Request{

    private $url;

    private $baseUrl;

    private $method;

 
    
    public function server($key, $default = null){
        
        return array_container($_SERVER, $key, $default);
    }


    public function setUrl(){
       
         $appName = dirname($this->server('SCRIPT_NAME'));
       $rquestUrl =  $this->server('REQUEST_URI');
          if(strpos($rquestUrl,'?') !== false){
            list($rquestUrl, $queryString) = explode('?', $rquestUrl);
        }
        $this->url =  preg_replace('#^'.$appName.'#', '', $rquestUrl);
        $this->baseUrl = $this->server('REQUEST_SCHEME').'://'.$this->server('HTTP_HOST').$appName.'/';
       // echo $this->baseUrl;
    }

    public function url(){
        return $this->url;
    }

    public function baseUrl(){
        return $this->baseUrl;
    }

    public function get($key, $default = null){
        return array_container($_GET, $key, $default );
    }

    public function post($key, $default = null){
        return array_container($_POST, $key, $default );
    }

 
 

    public function method(){
        return $this->server('REQUEST_METHOD');
    }
  

 
}