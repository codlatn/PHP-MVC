<?php

namespace System\Cookie;

use System\Application;

class Cookie
{

    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function all()
    {
        return $_COOKIE;
    }
    public function set($key, $value, $hours = 1800)
    {
        setcookie($key, $value, time() + $hours * 3600, '/', '', false,  true);
    }

    public function get($key, $defualt = null)
    {
        return array_container($_COOKIE, $key, $defualt);
    }

    public function has($key)
    {
        return array_key_exists($key, $_COOKIE);
        //test 
       // return isset($_COOKIE[$key]);
    }

    public function remove($key)
    {
        setcookie($key, '', -1, '/');
        unset($_COOKIE[$key]);
    }

    public function destroy($key)
    {
        foreach (array_keys($key) as $key) {
            $this->remove($key);
        }
        unset($_COOKIE);
    }
}
