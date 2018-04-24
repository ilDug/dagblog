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
require_once('posterbook.manager.php');

$data = json_decode(file_get_contents('php://input'));//object
$pbm = new PosterBookManager();

switch ($data->action) {
	case 'list':
		echo json_encode($pbm->list_());
		break;

	case 'update':
		$posterbook = $pbm->db->real_escape_string(json_encode($data->posterbook)) ? json_encode($data->posterbook) :  die('invalid posterbook scafolding');
		$ID = is_numeric($data->ID) ? $data->ID : die('invalid ID');
		echo json_encode( $pbm->update($ID, $posterbook) );
		break;



	default:
			echo json_encode(new ServerResponse( false ,  "DAG ERROR - no action available"));
		break;
} //chiude switch



/**
 * chiude la connessione
 */
$pbm->DbCloseConn();


?>
