<?php 

//echo $_SERVER['REQUEST_URI'];

require __DIR__ . '/vendor/System/Application.php';
require __DIR__ . '/vendor/System/File.php';

use System\Application;
use System\File;
 
 

 //Depndcy Injection  class a constrcut pram class b classA(new ClassB);
$app =  Application::getInstance(new File(__DIR__));

 $app->run();
 $app->route->add('/', 'Main/Home');
$app->route->add('/blog/{slug}/{id}', 'Posts@Post');
$app->route->add('/404', 'Error@notFound');
$app->route->notFoundUrl('/404');

$app->route->add('/', 'Error@notFound');
 

echo $app->request->setUrl();
//$app->request->server();
//$app->request->server();


 