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
        <?php
            require_once __DIR__ . '/lib/meta.class.php'; $meta = new Meta();
            $tags = array(
                $pb->data->title . ' - PosterBook',
                'Il tuo libro preferito su un unico Poster, idea regalo per gli amanti dei libri.' . $pb->data->items[0]->details,
                'https://posterbook.it/images/posterbook/' . $pb->data->items[0]->images[1],
                'https://posterbook.it/posterbook/' . $pb->data->author . '/' . $pb->data->title . '/' . $pb->code()
            );
            $meta->publish($tags);
         ?>

        <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
        <script defer src="/plugins/fontawesome-pro-5.0.10/svg-with-js/js/fontawesome-all.min.js"></script>
        <link rel="stylesheet" href="/styles/override-bootstrap.css">
        <link rel="stylesheet" href="/styles/style.css">


        <?php
            require_once __DIR__ . '/lib/script-managment/script.manager.php';
            $sm = new ScriptJSManager(); $sm->writeScripts(['iubenda', 'analytics']);
        ?>
    </head>

    <body>

        <?php include 'views/header.html'; ?>
        <main id="content">
            <div class="container" >
                <div class="row">
                    <section class="col-md-9 col-sm-12">
                        <article class="">
                            <div class="post-info">
                                <!-- like -->
                                <span class="mr-3 float-right">
                                <a class="mr-1" href="#"><i class="fal fa-heart fa-2x"></i></a>
                                <span id="heart-counter">1</span>
                                </span>

                                <!-- share -->
                                <span class="mr-3 float-right">
                                <a class="mr-1" href="#" data-toggle="modal" data-target="#socialDialog"><i class="fal fa-share-alt fa-2x"></i></a>
                                </span>




                                <!-- data -->
                                <span class="ml-3"> <i class="fal fa-clock mr-1"></i> <?php echo date('d/m/Y', strtotime($post->date->update) ); ?> </span>

                                <!-- categoria -->
                                <span class="ml-3" data-toggle="tooltip" title="categoria"><i class="fal fa-tag mr-1"></i>
                                <?php
                                    foreach ($post->tags as $tag => $value) {
                                        if($value->category) { echo strtoupper($tag);}
                                    }
                                ?>
                                </span>

                                <!-- views -->
                                <span class="ml-3" data-toggle="tooltip" title="visualizzazioni"><i class="fal fa-asterisk mr-1"></i> 123</span>
                            </div>


                            <div class="post">
                                <?php echo $article; ?>
                            </div>


                            <!-- tags -->
                            <hr>
                            <?php
                                foreach ($post->tags as $tag => $value) {
                                    if($value->label) { echo '<span class="ml-3 post-tag">'. $tag .'</span>';}
                                }
                            ?>
                            <hr>
                        </article>



                        <div class="related mt-3">
                            <div class="col-xs-12 mb-6">
                                <?php
                                    $i=0;
                                    $iterate = 3;
                                    foreach ($post->related as $r) {

                                        $rpm =  new PostArchiveManager($post->related[$i]);
                                        foreach ($post->tags as $tag => $value) {
                                            if($value->category) { $cat =  strtoupper($tag);}
                                        }
                                        if($iterate==$i) { break; } else { $i++;  }
                                        $template = '<div class="article-card">';
                                        $template .= '<a class="card-box-link" href="/'. $rpm->data->code .'/'. $rpm->data->url .'">';
                                        $template .= '<div class=" card shdw-h d-flex">';
                                        $template .= '<div class="box-image" style="background-image:url(http://lorempixel.com/300/200);"> </div>';
                                        $template .= '<div class="box-content p-3">';
                                        $template .= '<h5>'. $rpm->data->title . '</h5>';
                                        $template .= '<p><small class="text-muted">'. $rpm->data->date->update . '</small> <br>';
                                        $template .= '<small class="text-muted">'. $cat .'</small></p>';
                                        $template .= '</div>';
                                        $template .= '</div>';
                                        $template .= '</a>';
                                        $template .= '</div>';

                                        echo $template;
                                    }
                                ?>

                            </div>
                        </div>



                    </section>
                    <aside class="col-md-3 col-sm-12 my-5 d-sm-none d-md-block">
                        <?php include 'views/aside.php'; ?>
                    </aside>
                </div>
            </div>

        </main>


        <?php include 'views/footer.html'; ?>
        <?php include 'views/social-dialog.html'; ?>
        <?php include 'views/search-overlay.html'; ?>



        <script type="text/javascript" src="bundle.js">
        </script>
    </body>

    </html>
