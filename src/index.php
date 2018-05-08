<!DOCTYPE html>
<html>
    <head>
        <meta name="robots" content="index,follow" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta charset="utf-8">
        <meta name="language" content="it" />
        <meta http-equiv="content-language" content="it">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="scienza e tecnologia dal putno di vista DagTech">
        <meta name="keywords" content="dagtech, scienza, tecnologia">
        <meta name="author" content="DagTech">
        <meta name="copyright" content="DagTech">

        <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
        <title>DagTech BLOG</title>

        <script defer src="/plugins/fontawesome-pro-5.0.10/svg-with-js/js/fontawesome-all.min.js"></script>
        <link rel="stylesheet" href="/styles/override-bootstrap.css">
        <link rel="stylesheet" href="/styles/style.css">

        <?php
            require_once __DIR__ . '/lib/script-managment/script.manager.php';
            $sm = new ScriptJSManager(); $sm->writeScripts(['analytics']);
        ?>
    </head>

    <body>
        <?php include 'views/header.html'; ?>

        <?php
            require_once __DIR__ . '/posts/post-list-manager.php';
            $page =  $_GET['page'] ?  $_GET['page'] : 1;
            $plm = new PostListManager($page);
            $posts = $plm->list;

        ?>
        <main id="content">
            <div class="container" >
                <div class="row">
                    <section class="col-12">
                        <!-- post principale ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
                        <div class="row" id="index-card-main">
                            <div class="col-12">
                                <div class="article-card-index"><a href="<?php echo $posts[0]->url; ?>" class="card-box-link">
                                    <div class=" card shdw-h d-flex">
                                        <div class="box-image" style="background-image:url(http://blog.dagtech.it/images/posts/<?php echo $posts[0]->code; ?>.jpg);"> </div>
                                        <div class="box-content p-3">
                                            <h5><?php echo $posts[0]->title ?></h5>
                                            <p><small class="text-muted"><i class="fal fa-clock"></i> <?php echo date('d/m/Y', strtotime($posts[0]->date->update) ); ?></small> <br>
                                            <small class="text-muted"><i class="fal fa-tag"></i> <?php foreach ($posts[0]->tags as $tag => $value) { if($value->category) {echo strtoupper($tag);} }  ?></small></p>
                                        </div>
                                    </div>
                                </a></div>
                            </div>
                        </div>

                        <!-- gruppo boxes seconda linea ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
                        <div class="row" id="index-card-group-boxes">
                            <div class="col-md-4 <?php if(!$posts[1])echo 'd-none'; ?>">
                                <div class="article-card-index"><a href="<?php echo $posts[1]->url; ?>" class="card-box-link">
                                    <div class=" card shdw-h d-flex">
                                        <div class="box-image" style="background-image:url(http://blog.dagtech.it/images/posts/<?php echo $posts[1]->code; ?>.jpg);"> </div>
                                        <div class="box-content p-3">
                                            <h5><?php echo $posts[1]->title ?></h5>
                                            <p><small class="text-muted"><i class="fal fa-clock"></i> <?php echo date('d/m/Y', strtotime($posts[1]->date->update) ); ?></small> <br>
                                            <small class="text-muted"><i class="fal fa-tag"></i> <?php foreach ($posts[1]->tags as $tag => $value) { if($value->category) { echo strtoupper($tag);} } ?></small></p>
                                        </div>
                                    </div>
                                </a></div>
                            </div>

                            <div class="col-md-4 <?php if(!$posts[2])echo 'd-none'; ?>">
                                <div class="article-card-index"><a href="<?php echo $posts[2]->url; ?>" class="card-box-link">
                                    <div class=" card shdw-h d-flex">
                                        <div class="box-image" style="background-image:url(http://blog.dagtech.it/images/posts/<?php echo $posts[2]->code; ?>.jpg);"> </div>
                                        <div class="box-content p-3">
                                            <h5><?php echo $posts[2]->title ?></h5>
                                            <p><small class="text-muted"><i class="fal fa-clock"></i> <?php echo date('d/m/Y', strtotime($posts[2]->date->update) ); ?></small> <br>
                                            <small class="text-muted"><i class="fal fa-tag"></i> <?php foreach ($posts[2]->tags as $tag => $value) { if($value->category) { echo strtoupper($tag);} } ?></small></p>
                                        </div>
                                    </div>
                                </a></div>
                            </div>

                            <div class="col-md-4 <?php if(!$posts[3])echo 'd-none'; ?>">
                                <div class="article-card-index"><a href="<?php echo $posts[3]->url; ?>" class="card-box-link">
                                    <div class=" card shdw-h d-flex">
                                        <div class="box-image" style="background-image:url(http://blog.dagtech.it/images/posts/<?php echo $posts[3]->code; ?>.jpg);"> </div>
                                        <div class="box-content p-3">
                                            <h5><?php echo $posts[3]->title ?></h5>
                                            <p><small class="text-muted"><i class="fal fa-clock"></i> <?php echo date('d/m/Y', strtotime($posts[3]->date->update) ); ?></small> <br>
                                            <small class="text-muted"><i class="fal fa-tag"></i> <?php foreach ($posts[3]->tags as $tag => $value) { if($value->category) { echo strtoupper($tag);} } ?></small></p>
                                        </div>
                                    </div>
                                </a></div>
                            </div>

                        </div>

                        <!-- gruppo post in linea ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
                        <div class="row" id="index-card-group-lines">
                            <div class="col-12 ">
                                <div class="article-card-index  <?php if(!$posts[4])echo 'd-none'; ?>"><a href="<?php echo $posts[4]->url; ?>" class="card-box-link">
                                    <div class=" card shdw-h d-flex">
                                        <div class="box-image" style="background-image:url(http://blog.dagtech.it/images/posts/<?php echo $posts[4]->code; ?>.jpg);"> </div>
                                        <div class="box-content p-3">
                                            <h5><?php echo $posts[4]->title ?></h5>
                                            <p><small class="text-muted"><i class="fal fa-clock"></i> <?php echo date('d/m/Y', strtotime($posts[4]->date->update) ); ?></small> <br>
                                            <small class="text-muted"><i class="fal fa-tag"></i> <?php foreach ($posts[4]->tags as $tag => $value) { if($value->category) { echo strtoupper($tag);} } ?></small></p>
                                        </div>
                                    </div>
                                </a></div>


                                <div class="article-card-index <?php if(!$posts[5])echo 'd-none'; ?>"><a href="<?php echo $posts[5]->url; ?>" class="card-box-link">
                                    <div class=" card shdw-h d-flex">
                                        <div class="box-image" style="background-image:url(http://blog.dagtech.it/images/posts/<?php echo $posts[5]->code; ?>.jpg);"> </div>
                                        <div class="box-content p-3">
                                            <h5><?php echo $posts[5]->title ?></h5>
                                            <p><small class="text-muted"><i class="fal fa-clock"></i> <?php echo date('d/m/Y', strtotime($posts[5]->date->update) ); ?></small> <br>
                                            <small class="text-muted"><i class="fal fa-tag"></i> <?php foreach ($posts[5]->tags as $tag => $value) { if($value->category) { echo strtoupper($tag);} } ?></small></p>
                                        </div>
                                    </div>
                                </a></div>


                                <div class="article-card-index <?php if(!$posts[6])echo 'd-none'; ?>"><a href="<?php echo $posts[6]->url; ?>" class="card-box-link">
                                    <div class=" card shdw-h d-flex">
                                        <div class="box-image" style="background-image:url(http://blog.dagtech.it/images/posts/<?php echo $posts[6]->code; ?>.jpg);"> </div>
                                        <div class="box-content p-3">
                                            <h5><?php echo $posts[6]->title ?></h5>
                                            <p><small class="text-muted"><i class="fal fa-clock"></i> <?php echo date('d/m/Y', strtotime($posts[6]->date->update) ); ?></small> <br>
                                            <small class="text-muted"><i class="fal fa-tag"></i> <?php foreach ($posts[6]->tags as $tag => $value) { if($value->category) { echo strtoupper($tag);} } ?></small></p>
                                        </div>
                                    </div>
                                </a></div>
                            </div>
                        </div>

                    </section>
                </div>
            </div>
        </main>

        <?php include 'views/footer.html'; ?>
        <?php include 'views/search-overlay.html'; ?>
        <?php  $sm->writeScripts(['cookiesenabler']); ?>


        <!-- <script type="text/javascript" src="/bundle.js"> </script> -->
        <script type="text/javascript" src="/bundle.index.js"> </script>
        <script type="text/javascript" src="/bundle.vendors.js"> </script>
    </body>

    </html>
