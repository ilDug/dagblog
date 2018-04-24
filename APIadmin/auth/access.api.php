<?php
/******************************************************/
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true ");
header("Access-Control-Allow-Headers: Origin, Authorization, Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control, X-Auth-Token");
header("Access-Control-Allow-Methods: GET,HEAD,PUT,PATCH,POST,DELETE");
header('Content-Type: application/json');
/******************************************************/

require __DIR__ . '/access.manager.php';
require __DIR__ . '/auth.class.php';

$u = new AccessManager();

$data = json_decode(file_get_contents('php://input'));//object
switch ($data->action) {

	case 'login':
		$email = (!isset($data->email) || $data->email === null ) 			? 	die('ERR_DATA_EMPTY_EMAIL') : $data->email;
		$password = (!isset($data->password) || $data->password === null ) 	? 	die('ERR_DATA_EMPTY_PASSWORD') : $data->password;
		$remember = (!isset($data->remember) || $data->remember === null ) 	? 	false : $data->remember;
		echo $u->login($email, $password, $remember);
		break;

	case 'encodepw':
		echo $u->encondePassword($data->password);
		break;

	default:
			echo json_encode("DAG ERROR - no action available");
		break;

} //chiude switch

//$u->DbCloseConn();
?>
