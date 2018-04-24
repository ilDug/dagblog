<?php
require_once __DIR__ . '/../Engine.class.php';
require_once __DIR__ . '/../ServerResponse.class.php';
require_once __DIR__ . '/../Email.class.php';
require_once __DIR__ . '/JWT.class.php';
require_once __DIR__ . '/auth.config.php';
require_once __DIR__ . '/RSAKey.class.php';
require_once __DIR__ . '/user.class.php';


	/*
	* classe per la gestione degli accessi e degli utenti
	* collegata ad una tabella del database che gestisce gli utenti
	* IDPcode dato dalla forma criptata di mail+timestamp
	*/
	class AccessManager extends Engine
	{

		function __construct() { parent::__construct(); }


		/**
		*	ricerca nel database la corrispondenza tra username e password
		*	resitutisce il token
		*/
		public function login($email, $pw, $remember)
		{
			$email = strtolower(trim($email));
			$email = filter_var($email, FILTER_VALIDATE_EMAIL);
			$email =  $this->db->real_escape_string($email);


			if($email != ADMIN_MAIL){
				$v = false;
				$m = "email dell'amministratore non corretta.";
			}else if (!password_verify($pw, ADMIN_PW)){
				$v = false;
				$m = "password non corretta per questo account." ;
			}else{
				$keyBox = (new RSAKey())->getPrivate(RSA_KEY_PASSPHRASE);
				$manifest = new JWTManifest(JWT_ISS, JWT_AUD, md5($u->IDPcode . microtime()));
				$manifest->uid = $u->IDPcode;
				$manifest->sub = $u->IDPcode;
				$manifest->duration = 60*60*24*1;
				$jwt = (new JWT())->generate($keyBox, $manifest);
				$v = true;
				$m = "accesso eseguito";
			}


			return json_encode( new ServerResponse($v, $m, ($v ? (string)$jwt : null)  )  ) ;
		}





		public function encondePassword($pw){
			return  password_hash($password, PASSWORD_DEFAULT);
		}



	}//chiude la classe
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
 ?>
