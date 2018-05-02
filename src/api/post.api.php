<?php
// Require composer autoloader
require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/../posts/post-archive-manager.php';
require_once __DIR__ . '/managers/views.manager.php';
require_once __DIR__ . '/managers/like.manager.php';
require_once __DIR__ . '/managers/posts.manager.php';


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
         try {
             $pam = new PostArchiveManager($code);
         } catch (Exception $e) { }
        echo json_encode($pam->data);
 });


// acquisizione elenco posts
 $router->get('posts/popular/(\d+)', function ($limit) {
         try {
             $pm = new PostsManager();
         } catch (Exception $e) { }


        echo json_encode($pm->popular($limit));
 });






// acquisizione dati del post
$router->get('views/(\d+)', function ($code) {
    $vm = new ViewsManager();
    echo $vm->views($code);
});

$router->post('views/', function () {
    //$data = json_decode(file_get_contents('php://input'), true); //array
    $data = json_decode(file_get_contents('php://input'));//object
    $data = !$data ? (object)$_POST : $data;

    if(!$data->code) return;

    $vm = new ViewsManager();
    echo $vm->add($data->code);
});







$router->post('likes/', function () {
    //$data = json_decode(file_get_contents('php://input'), true); //array
    $data = json_decode(file_get_contents('php://input'));//object
    $data = !$data ? (object)$_POST : $data;

    if(!$data->code) return ('error');
    if(!$data->like) return ('error like not set');

    $lm = new LikeManager();
    if($data->like == "like") { echo $lm->like($data->code); }
    elseif($data->like == "dislike") {echo  $lm->dislike($data->code); }
});



$router->get('likes/(\d+)', function ($code) {
    $lm = new LikeManager();
    echo $lm->likes($code);
});



 //inizia
 $router->run();
 ?>
