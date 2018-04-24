<?php
/******************************************************/
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true ");
header("Access-Control-Allow-Headers: Origin, Authorization, Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control, X-Auth-Token");
header("Access-Control-Allow-Methods: GET,HEAD,PUT,PATCH,POST,DELETE");
header('Content-Type: application/json');
/******************************************************/

require_once __DIR__ . '/access.manager.php';
require_once __DIR__ . '/../auth/auth.class.php';
require_once __DIR__ . '/../server-response.class.php';

$u = new AccessManager();


$data = json_decode(file_get_contents('php://input'));//object


switch ($data->action) {

	case 'register':
		$email = (!isset($data->email) || $data->email === null )	? 	false : $data->email;
		$email = strtolower(trim($email));
		$email = $u->db->real_escape_string($email);
		$email = filter_var($email, FILTER_VALIDATE_EMAIL);

		if(!$email)  { die('ERR_DATA_ESCAPED_EMAIL'); }

		$password = (!isset($data->password) || $data->password === null ) 	? 	die('ERR_DATA_EMPTY_PASSWORD') : $data->password;
		$password =  $u->db->real_escape_string($password);
		if(!$password)  { die('ERR_DATA_ESCAPED_PASSWORD'); }

		echo $u->register($email,  $password);
		break;


	case 'userExist':
		$email = (!isset($data->email) || $data->email === null ) ? false : $data->email;
		$email = strtolower(trim($email));
		$email = $u->db->real_escape_string($email);
		$email = filter_var($email, FILTER_VALIDATE_EMAIL);

		echo json_encode(new ServerResponse($u->userExist($email)));
		break;


	case 'activateAccount':
		$IDPcode 	= (!isset($data->IDPcode)) 	? 	false 	: $data->IDPcode;
		$IDPcode = $u->db->real_escape_string($IDPcode);
		$IDPcode =  (strlen($IDPcode) == USERIDP_CODE_LENGTH)? $IDPcode : false;

		$activationKey   = (!isset($data->activationKey)) 	? 	false 	: $data->activationKey;
		$activationKey =  $u->db->real_escape_string($activationKey);
		$activationKey =  (strlen($activationKey) == ACTIVATION_KEY_LENGTH)? $activationKey : false;

		echo $u->activateAccount($IDPcode, $activationKey);
		break;


	case 'login':
		$email = (!isset($data->email) || $data->email === null ) ? false : $data->email;
		$email = strtolower(trim($email));
		$email =  $u->db->real_escape_string($email);
		$email = filter_var($email, FILTER_VALIDATE_EMAIL);


		$password = (!isset($data->password) || $data->password === null ) 	? 	die('ERR_DATA_EMPTY_PASSWORD') : $data->password;
		$remember = (!isset($data->remember) || $data->remember === null ) 	? 	false : $data->remember;

		echo $u->login($email, $password, $remember);
		break;


	case 'logout':
		// $requestHeaders = apache_request_headers();
		// $userIDP = (new Auth($requestHeaders, false))->claims['uid'] or null;
		// echo $u->logout($userIDP);
		break;


	case 'recoverPassword':
		$email = (!isset($data->email) || $data->email === null ) ? false : $data->email;
		$email = strtolower(trim($email));
		$email =  $u->db->real_escape_string($email);
		$email = filter_var($email, FILTER_VALIDATE_EMAIL);
		echo $u->recoverPassword($email);
		break;


	case 'restorePasswordInit':
		$IDPcode 	= (!isset($data->IDPcode)) 	? 	false 	: $data->IDPcode;
		$IDPcode = $u->db->real_escape_string($IDPcode);
		$IDPcode =  (strlen($IDPcode) == USERIDP_CODE_LENGTH)? $IDPcode : false;

		$restoreKey   = (!isset($data->restoreKey)) 	? 	false 	: $data->restoreKey;
		$restoreKey =  $u->db->real_escape_string($restoreKey);
		$restoreKey =  (strlen($restoreKey) == ACTIVATION_KEY_LENGTH)? $restoreKey : false;

		echo $u->restorePasswordInit($IDPcode, $restoreKey);
		break;


	case 'restorePassword':
		$IDPcode 	= (!isset($data->IDPcode)) 	? 	false 	: $data->IDPcode;
		$IDPcode = $u->db->real_escape_string($IDPcode);
		$IDPcode =  (strlen($IDPcode) == USERIDP_CODE_LENGTH)? $IDPcode : false;

		$newPassword = (!isset($data->newPassword) || $data->newPassword === null ) ? 	die('ERR_DATA_EMPTY') : $data->newPassword;
		echo $u->restorePassword($IDPcode, $newPassword);
		break;


	case 'resendActivationEmail':
		$email = (!isset($data->email) || $data->email === null ) ? false : $data->email;
		$email = strtolower(trim($email));
		$email =  $u->db->real_escape_string($email);
		$email = filter_var($email, FILTER_VALIDATE_EMAIL);

		echo $u->resendActivationLink($email);
		break;




	default:
			echo json_encode(new ServerResponse(false, "DAG ERROR - no action available"));
		break;
} //chiude switch


//$u->DbCloseConn();
?>
