<?php

namespace System\Http;

use System\Application;

class Response
{

    protected $app;

    private $headers = [];

    private $content;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    //void 
    public function setHeaders($header, $value)
    {
        $this->headers[$header] = $value;
    }

    public function setOutput($content)
    {
        $this->content = $content;
    }

    private function sendHeaders()
    {
        foreach ($this->headers as $key => $value) {
            header($key . ':' . $value);
        }
    }

    //void 
    public function send()
    {
        $this->sendHeaders();
        $this->sendOutput();
    }
 
    private function sendOutput()
    {
        echo $this->content;
    }

    public function json(array $data)
    {
       // $this->sendHeaders('Content-Type: application/json; charset=utf-8');
        return json_encode($data, true);
    }
}
