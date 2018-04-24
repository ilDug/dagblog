<?php
/*-------------------------------------------------------------------------*/
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true ");
header("Access-Control-Allow-Headers: Origin, Authorization, Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control, X-Auth-Token");
header("Access-Control-Allow-Methods: GET,HEAD,PUT,PATCH,POST,DELETE");
/*-------------------------------------------------------------------------*/
header('Content-Type: application/json');
require_once 'request-manager.php';

$email = $_POST['email'];
$title = $_POST['title'];
$token = $_POST['token'];

$rm = new RequestManager();

echo $rm->addRequest($email, $title, $token);


 ?>
