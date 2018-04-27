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
        <title>
            <?php echo $post->title; ?>
        </title>

        <script defer src="/plugins/fontawesome-pro-5.0.10/svg-with-js/js/fontawesome-all.min.js"></script>

        <link rel="stylesheet" href="/styles/override-bootstrap.css">
        <link rel="stylesheet" href="/styles/style.css">

    </head>

    <body>
        <header class="mb-3">
            <div class="container ">

                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="navbar-brand" href="#">DagTech <strong>BLOG</strong></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <!-- <span class="navbar-toggler-icon"></span> -->
                        <span><i class="fal fa-bars"></i></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Link</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Dropdown </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>

            </div>
        </header>

        <section class="container">
            <div class="row">
                <div class="col-md-9 col-sm-12">
                    <div class="post">
                        <?php echo $article; ?>
                    </div>
                </div>
            </div>
        </section>




            <script type="text/javascript" src="bundle.js">
            </script>
    </body>

    </html>
