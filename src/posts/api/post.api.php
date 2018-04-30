<?php
// Require composer autoloader
require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/../post-archive-manager.php';
require_once __DIR__ . '/managers/views.manager.php';


// Create a Router
 $router = new \Bramus\Router\Router();

// acquisizione del post
 // $router->get('/(\d+)(/[a-z0-9_-]+)?', function ($code, $title=null) {
 //        //crea il manager e gli passa il post
 //        $pam = new PostArchiveManager($code);
 //        echo json_encode($pam->data);
 //
 // });

// acquisizione dati del post
 $router->get('/(\d+)', function ($code) {
         try {
             $pam = new PostArchiveManager($code);
         } catch (Exception $e) { }
        echo json_encode($pam->data);
 });


 // acquisizione dati del post
  $router->get('views/(\d+)', function ($code) {
        $vm = new ViewsManager();
        echo $vm->getViews($code);
  });
  $router->post('views/(\d+)', function ($code) {
        $vm = new ViewsManager();
        echo $vm->addViews($code);
  });


  


 //inizia
 $router->run();
 ?>
