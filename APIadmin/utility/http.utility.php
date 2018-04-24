<?php

 /**
  * classe per la manipolazione delle stringhe
  */
class HttpTool
{

    function __construct()
    {
        # code...
    }



    /**
    * controlla se la connessione al server avvine da un indirizzo IP autorizzato
	*/
	public function checkSecurityAddress($safeClientIP, $action = 'unauthorize', $redirectTo = 'http://www.google.it') {
	    $check = FALSE;
	    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR', 'REMOTE_HOST') as $key){
	        if (array_key_exists($key, $_SERVER) === true){
	            foreach (explode(',', $_SERVER[$key]) as $ip){
	                $ip = trim($ip); // just to be safe

	                if (filter_var($ip, FILTER_VALIDATE_IP) !== false){
	                  	$check =  $ip;
	                }
	            }
	        }
	    }
		//$safeClientIP = '79.34.124.29';
		if ($check != $safeClientIP){
            if($action == 'redirect') { header ("Location:". $redirectTo . ""); }
            if($action == 'unauthorize') { header('HTTP/1.0 401 Unauthorized'); }
        }

	}



    /**
    * controlla che la richiesta avvenga via javasciprt , asincona
    */
    public function IsXHR() {
        $IsXHR = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
        if(!$IsXHR) {
            $user_error = 'Access denied - not an XHR request...';
            trigger_error($user_error, E_USER_ERROR);
        }
        return $IsXHR;
    }






}//chiude la classe
 ?>
