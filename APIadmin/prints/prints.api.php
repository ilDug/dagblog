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
require_once('prints.manager.php');
require_once('print.class.php');

$data = json_decode(file_get_contents('php://input'));//object
$prm = new PrintManager();

switch ($data->action) {
	case 'list':
		echo json_encode($prm->list_());
		break;

	case 'group':
		echo json_encode($prm->group_());
		break;

	case 'add':
		$print = isset($data->print) ? new PBPrint() :  die('invalid print scafolding');
		$print->parseforDB($data->print);
		echo json_encode( $prm->add($print) );
		break;

	case 'update':
		$print = isset($data->print) ? new PBPrint() :  die('invalid print scafolding');
		$print->parseforDB($data->print);
		echo json_encode( $prm->update($print) );
		break;



	default:
			echo json_encode(new ServerResponse( false ,  "DAG ERROR - no action available"));
		break;
} //chiude switch



/**
 * chiude la connessione
 */
$prm->DbCloseConn();


?>
