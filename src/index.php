<?php
    require_once __DIR__ . '/posts/post-archive-manager.php';

    // url nella forma blog.dagtech.it/10001/titolo-del-post
    $code = (int)$_GET['code'];

    try {
        $pam = new PostArchiveManager($code);
    } catch (Exception $e) {
        header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
        header('Location: /404.php?err='.$e->getMessage() );
    }

    $article = $pam->post;
    $post = $pam->data;
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $post->title; ?></title>

        <link rel="stylesheet" href="/styles/style.css">
        <link rel="stylesheet" href="/styles/override-bootstrap.css">
    </head>
    <body>
        <?php echo $article; ?>
    </body>
</html>
