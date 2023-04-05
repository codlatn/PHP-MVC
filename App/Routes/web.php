<?php 
 
 use System\Application;

 $app =  Application::getInstance();

//Admin Routes 


 
 






//Admin Login
$app->route->add('/admin/login', 'Admin/Login');
$app->route->add('/admin/login/submit', 'Admin/Login@login', 'POST');

//Admin DashBoard
$app->route->add('/admin', 'Admin/Dash');
$app->route->add('/admin/dash', 'Admin/Dash');
$app->route->add('/logout', 'Home@logout');

//




//FrontEnd Routes
$app->route->add('/', 'Home');

$app->route->add('/about', 'About');

$app->route->add('/call', 'Call');


//Not Found
$app->route->notFoundUrl('/404');

$app->route->add('/404', 'NotFound');

