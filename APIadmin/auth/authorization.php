<?php
/*-------------------------------------------------------------------------*/
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true ");
header("Access-Control-Allow-Headers: Origin, Authorization, Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control, X-Auth-Token");
header("Access-Control-Allow-Methods: GET,HEAD,PUT,PATCH,POST,DELETE");
/*-------------------------------------------------------------------------*/
header('Content-Type: application/json');
require_once '../auth/auth.class.php';
$requestHeaders =  apache_request_headers();
$auth = new Auth($requestHeaders['Authorization']);
/*-------------------------------------------------------------------------*/
echo json_encode($auth->claims["autorizations"]);
?>
