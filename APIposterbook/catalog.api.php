<?php
    header('Content-Type: application/json');
    require_once 'PosterBookManager.class.php';

    // instanzia il manager
    $pbManager  = new PosterBookManager();

    //scrive il json
    echo json_encode($pbManager->posterBooks);

    $pbManager->DbCloseConn();
 ?>
