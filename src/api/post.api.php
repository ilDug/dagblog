<?php
// Require composer autoloader
require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/../posts/post-archive-manager.php';
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
 $router->get('posts/(\d+)', function ($code) {
        //  try {
        //      $pam = new PostArchiveManager($code);
        //  } catch (Exception $e) { }
        // echo json_encode($pam->data);
        echo 'api/post/'.$code;
 });


// acquisizione dati del post
$router->get('views/(\d+)', function ($code) {
    // $vm = new ViewsManager();
    // echo $vm->getViews($code);
    echo 13;
});

$router->post('views/', function () {
    // $vm = new ViewsManager();
    // echo $vm->addViews($code);

    //$data = json_decode(file_get_contents('php://input'), true); //array
    $data = json_decode(file_get_contents('php://input'));//object
    $data = !$data ? $_POST : $data;

    echo true;
});

$router->post('likes/', function () {
    // $vm = new ViewsManager();
    // echo $vm->addViews($code);

    //$data = json_decode(file_get_contents('php://input'), true); //array
    $data = json_decode(file_get_contents('php://input'));//object
    $data = !$data ? $_POST : $data;

    echo json_encode($data);
});



$router->get('likes/(\d+)', function ($code) {
    // $vm = new ViewsManager();
    // echo $vm->getViews($code);
    echo 23;
});



 //inizia
 $router->run();
 ?>
