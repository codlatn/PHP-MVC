<?php

namespace System;

class Url
{


    //store app obj
    protected  $app;


    public function __construct(Application $app)
    {
        $this->app = $app;
    }


    public function link($path)
    {
        return $this->app->request->baseUrl() . trim($path, '/');
    }

    public function redirectTo($link)
    {
        header('Location:' . $this->link($link));
        exit;
    }

    public function away($link)
    {
        header('Location:' . $link);
        exit;
    }
}
