<?php
    require_once __DIR__ . '/posts/post-archive-manager.php';

    // url nella forma blog.dagtech.it/10001/titolo-del-post
    $code = (int)$_GET['code'];

    try {
        $pam = new PostArchiveManager($code);
    } catch (Exception $e) {
        switch ($e->getCode()) {
            case 1: //codice mancante
                header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
                break;

            case 2: //file contenuto non trovato
                header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
                break;

            case 3: //file dati non trovato
                header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
                break;

            default:
                header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
                break;
        }
    }

    $article = $pam->post;
    $post = $pam->data;
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>

    </body>
</html>
