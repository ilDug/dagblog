<?php
/*-------------------------------------------------------------------------*/
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true ");
header("Access-Control-Allow-Headers: Origin, Authorization, Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control, X-Auth-Token");
header("Access-Control-Allow-Methods: GET,HEAD,PUT,PATCH,POST,DELETE");
/*-------------------------------------------------------------------------*/
header('Content-Type: application/json');
require_once 'analytics.class.php';

// instanzia il manager
$pba  = new PBAnalytics();

if( isset($_POST['url']) ){
    $pba->setPageview($_POST['url']);
}


// se è settato il parametro pbcode lo registra
if( isset($_POST['pbcode']) ){
    $pba->setPosterView($_POST['pbcode']);
}


$pba->DbCloseConn();
 ?>
