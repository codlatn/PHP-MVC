<?php
namespace System\View;

use System\Application;

 final class Twig {

	private $data = array();

    private $app;

public function __construct(Application $app)
{
    $this->app = $app;
    
}

public function getTwig(){
    $file =  $this->app->files->getFiles('/vendor/lib/Template/vendor/autoload.php');
    //require( $file);
//     $loader = new \Twig\Loader\FilesystemLoader('/path/to/templates');
// $twig = new \Twig\Environment($loader, [
//     'cache' => '/path/to/compilation_cache',
// ]);

$loader = new \Twig\Loader\FilesystemLoader($this->app->files->getFiles('/App/Views/home.php'));
$twig = new \Twig\Environment($loader, [
    'cache' => '/cach/temp/',
]);


 
return $twig;

   // echo 'u got twig autoload';
}



	// public function set($key, $value) {
	// 	$this->data[$key] = $value;
	// }
	
	// public function render($filename, $code = '') {
	// 	if (!$code) {
	// 		//$file = DIR_TEMPLATE . $filename . '.twig';
	// 		$file = modification( DIR_TEMPLATE . $filename . '.twig' );
	// 		if( class_exists('VQMod') ) {
	// 			$file = \VQMod::modCheck($file);
	// 		}
	// 		if (is_file($file)) {
	// 			$code = file_get_contents($file);
	// 		} else {
	// 			throw new \Exception('Error: Could not load template ' . $file . '!');
	// 			exit();
	// 		}
	// 	}

	// 	// initialize Twig environment
	// 	$config = array(
	// 		'autoescape'  => false,
	// 		'debug'       => false,
	// 		'auto_reload' => true,
	// 		'cache'       => DIR_CACHE . 'template/'
	// 	);

	// 	try {
	// 		$loader = new \Twig\Loader\ArrayLoader(array($filename . '.twig' => $code));

	// 		$twig = new \Twig\Environment($loader, $config);

	// 		return $twig->render($filename . '.twig', $this->data);
	// 	} catch (Exception $e) {
	// 		trigger_error('Error: Could not load template ' . $filename . '!');
	// 		exit();
	// 	}	
	// }	
}
