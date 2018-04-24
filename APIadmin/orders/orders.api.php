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
$IDPCode = $auth->isAuthenticated ? $auth->claims['uid'] : null;
/*-------------------------------------------------------------------------*/

require_once 'order-manager.class.php';

$data = json_decode(file_get_contents('php://input'));//object
$om = new OrderManager();

switch ($data->action) {
    case 'list':
        $since = $om->db->real_escape_string($data->since);
        echo json_encode( $om->getOrders((int)$since) ) ;
        break;


    case 'listActive':
        echo json_encode( $om->activeOrders($since) ) ;
        break;



    case 'setOrder':
        $order = isset($data->order) ? $data->order : null;
        echo json_encode( $om->setOrder($order) );
        break;


    case 'sendShipConfirmation':
        if(isset($data->orderCode)) { $orderCode = $data->orderCode; } else {echo '{"error": "no code provided"}';}
        $trackingCode = $om->db->real_escape_string($data->trackingCode);
        $trackingLink = $om->db->real_escape_string($data->trackingLink);
        echo json_encode( $om->sendShipConfirmation($data->orderCode, $trackingCode, $trackingLink) );
        break;


    default:
        echo '{"error": "no action set  "}';
        break;
}

$om->DbCloseConn();

 ?>
