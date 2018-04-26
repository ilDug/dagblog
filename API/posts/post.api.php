<?php
// Require composer autoloader
require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/post-archive-manager.class.php';


// Create a Router
 $router = new \Bramus\Router\Router();

// acquisizione del post
 $router->get('/content/(\d+)(/[a-z0-9_-]+)?', function ($code, $title=null) {
        //crea il manager e gli passa il post
        $pam = new PostArchiveManager($code);



 });


 //inizia
 $router->run();
 ?>
