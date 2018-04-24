<?php
require_once __DIR__ . '/../engine.class.php';
require_once __DIR__ . '/../server-response.class.php';
require_once __DIR__ . '/../email.class.php';
require_once __DIR__ . '/../auth/JWT.class.php';
require_once __DIR__ . '/../auth/auth.config.php';
require_once __DIR__ . '/../auth/RSAKey.class.php';
require_once __DIR__ . '/user.class.php';

/**
 * parametri per gli accessi e l'account Utente
 */
define('URL_ACCOUNT_ACTIVATION', 'https://google.it/#/activation/');
define('EMAIL_TEMPLATE_ACCOUNT_ACTIVATION', __DIR__ . '/emails/email-account-activation-template.html');
define('URL_PASSWORD_RESTORE', 'https://google.it/#/account/access/restore-password/');
define('EMAIL_TEMPLATE_PASSWORD_RESTORE', __DIR__ . '/emails/email-account-password-restore-template.html');

	/*
	* classe per la gestione degli accessi e degli utenti
	* collegata ad una tabella del database che gestisce gli utenti
	* IDPcode dato dalla forma criptata di mail+timestamp
	*/
	class AccessManager extends Engine {

		function __construct() { parent::__construct(); }





		/**
		* ricerca la lista delle mail
		*/
		public function listUsers($type = "json"){
			$sql = "SELECT email from users";
			$list = parent::GetLists($sql);

			switch ($type) {
				case 'json':
					return json_encode($list);
					break;
				case 'array':
					return $list;
					break;
			}
		}








		/**
		*	ricerca nel database la corrispondenza tra email e password
		*	resitutisce TRUE se trova corrispondenze
		*/
		public function userExist($email) {
			$sql = "SELECT email from users WHERE email = '$email'";
			$list = array();
			$list = parent::GetLists($sql);
			$v = (count($list) == 0 || $list == false) ? false : true;
			return $v;
		}







		/**
		*	registra un nuovo utente
		*/
		public function register($email,  $password){

			$user = new User();
			$user->create($email,  $password);

			if( $this->userExist($user->email) ){
				//se l'utente esiste ritorna false
				$v = false;
				$m = "email già esistente";
			} else if(!$user->email){
				//se la mail non è corretta restituisce l'errore
				$v = false;
				$m = "Attenzione, controlla che la tua email sia corretta";
			} else{
				//inserisce nel database nella tabella users
				$result = parent::SetDataInDB($user->dbInsertQuery());
				if($result<=0){
					$v = false;
					$m = "errore con il server";
				}else{
					//manda mail per l'attivazione
					$delivery = $this->sendActivationEmail($user);
					$v = $delivery->val;
					$m = $delivery->val ? "La tua registrazione è avvenuta con successo. Prima di procedere con l'accesso devi attivare il tuo account. Segui le istruzioni della mail che ti abbiamo spedito. Bel colpo!" : $delivery->msg;
				}
			}
			return json_encode(new ServerResponse($v, $m));
		}






		/**
		 * invia la mail di attivazione dell'account
		 * @param User $user è un oggetto User contentente tutte le informazioni necessarie per l'invio dell'email
		 */
		private function sendActivationEmail($user){
			$activationLink = URL_ACCOUNT_ACTIVATION . $user->IDPcode . "/" . $user->activationKey;
			$body = file_get_contents(EMAIL_TEMPLATE_ACCOUNT_ACTIVATION);
			$search = array('%ACTIVATION_LINK%');
			$replace = array($activationLink);
			$body = str_replace($search, $replace, $body);

			$mail = new DagMail([$user->email], "Attivazione Account DAGTECH", $body);
			$delivery = $mail->send();
			return $delivery;
		}





		/**
		 * reinvia la mail di acttivazione partendo solo da email;
		 */
		public function resendActivationLink($email){
			if(!$email){
				//se la mail non è corretta restituisce l'errore
				$v = false;
				$m = "Attenzione, controlla che la tua email sia corretta";
			}else if( !$this->userExist($email) ){
				//se l'utente non  esiste ritorna false
				$v = false;
				$m = "Email non registrata. Procedi prima alla registrazione";
			} else {
				$res = $this->GetOneRowInfo("SELECT email, active,  IDPcode from users WHERE email = '$email'");
				if($res->active == 1){
					// se l'utente è già attivo ritorna false
					$v = false;
					$m = "Utente già attivo";
				} else {
					$u = new User();
					$u->setFromDB($res);

					//inserisce nel database la nuova activationKey
					$result = parent::SetDataInDB( $u->dbSetActivationKeyQuery() );
					if($result<=0){
						$v = false;
						$m = "errore con il server";
					}else{
						//manda mail per l'attivazione
						$delivery = $this->sendActivationEmail($u);
						$v = $delivery->val;
						$m = $delivery->val ? "Ti abbiamo spedito una nuova email. Segui le istruzioni per attivare il tuo account" : $delivery->msg;
					}
				}
			}

			return json_encode(new ServerResponse($v, $m));
		}




		/**
		* attiva l'account dopo la registrazione
		*/
		public function activateAccount($IDPcode, $activationKey){
			//se i dati dell'indirizzo non sono conformi
			if(!$IDPcode || !$activationKey){
				$v = false;
				$m = "indirizzo non conforme - link errato";
			}else{
				//controlla se l'utente esiste, se è attivato,  se il codice di attivazione corrisponde
				$user = parent::GetOneRowInfo("SELECT email, active,  activationKey FROM users WHERE IDPcode = '$IDPcode'");
				if(!$user){
					$v = false;
					$m = "Utente inesistente,  ritenta la procedura di registrazione, oppure contatta il nostro staff tecnico.";
				}else{
					if($user->active != 0){
						$v = false;
						$m = "Utente già attivo, procedi con il login per usufruire del servizio";
					}else{
						if($user->activationKey != $activationKey){
							$v = false;
							$m = "attivazione non possibile,  Il link utilizzato è incorretto od è stato eliminato. Ritenta la procedura di registrazione oppure contatta il nostro staff tecnico.";
						}else{
							$sql = "UPDATE users SET active = 1,  activationKey = NULL WHERE IDPcode = '$IDPcode' AND activationKey = '$activationKey'";
							$data = parent::SetDataInDB($sql);
							if($data <= 0){
								$v = false;
								$m = "impossibile accedere al database, prova più tardi. Se il problema persiste, contatta il nostro staff tecnico.";
							}else{
								$v = true;
								$m = "Evviva! Ora puoi usufruire dei nostri servizi. Procedi con il login.";
							}
						}
					}
				}
			}
			return json_encode(new ServerResponse($v,  $m));
		}







		/**
		*	ricerca nel database la corrispondenza tra username e password
		*	resitutisce il JWT token
		*/
		public function login($email, $pw, $remember) {
			$sql = "SELECT IDPcode, active, password from users WHERE email = '$email'";
			$u = parent::GetOneRowInfo($sql);

			//gestisce l'errore se non esiste l'utente nel database
			if(!$u){
				$v = false;
				$m = "Utente non registrato. Procedi prima con la registrazione del tuo account.";
			}else{
				// if($u->active == 0){
				// 	$v = false;
				// 	$m = "L'utente non è ancora stato attivato. Procedere con l'attivazione dell'account ricevuta via mail. Se ci sono problemi contatta il supporto tecnico";
				// }else{}
				if(!password_verify($pw, $u->password)){
					$v = false;
					$m = "password non corretta per questo account.";
				}else{
					$privKey = (new RSAKey())->getPrivate(RSA_KEY_PASSPHRASE);

					$manifest = new JWTManifest(JWT_ISS, JWT_AUD, md5($u->IDPcode . microtime()));
					$manifest->uid = $u->IDPcode;
					$manifest->sub = $u->IDPcode;
					$manifest->duration = ACCOUNT_SESSION_DURATION;

					$claims = array('username' => $email );
					$jwt = (new JWT())->generate($privKey, RSA_KEY_PASSPHRASE,  $manifest, $claims);

					$sql = "INSERT INTO JWTs ( uid, token , jti) VALUES ('$u->IDPcode', '$jwt', '$manifest->jti')";
					$check = parent::SetDataInDB($sql);

					if($check<=0) {
						$v = false;
						$m = "Errore,  si sono verificati problemi con la connsessione al server, riprovare più tardi";
					}else{
						$v = true;
						$m = "accesso effettuato";
					}
				}

			}

			return json_encode( new ServerResponse($v, $m, ($v ? (string)$jwt : null)  )  ) ;
		}





		/** esegue il logout
		*/
		public function logout($uid)
		{
			//esce da tutti i dispositivi
			// $sql = "DELETE FROM JWTs WHERE uid = '$uid'";
			// $check = parent::SetDataInDB($sql);
			// $v = $check > 0 ? true : false;

			// $v = true;
			// setcookie("DTjwt", "", time() - 3600, "/");
			// return json_encode(new ServerResponse($v, 'logout'));
		}







		/*	imposta nel database il codice di ripristino e manda una mail per il recupero della password
		*/
		public function recoverPassword($email){
			$restoreKey =  $this->stringTool->GetRandomString(ACTIVATION_KEY_LENGTH);
			if(!$email){
				$v = false;
				$m = "Indirizzo email non corretto. Controlla L'indirizzo inserito.";
			}else{
				$sql = "UPDATE users SET restoreKey = '$restoreKey' WHERE email = '$email'";
				$res = parent::SetDataInDB($sql);
				if($res < 1 ){
					$v = false;
					$m = "L'indirizzo email che è stato inserito è inesistente. Registrati per accedere al servizio";
				}else{
					$sql = "SELECT IDPcode FROM users WHERE email = '$email' ";
					$u = parent::GetOneRowInfo($sql);
					$restoreLink = URL_PASSWORD_RESTORE . $u->IDPcode . "/" . $restoreKey ;

					$body = file_get_contents(EMAIL_TEMPLATE_PASSWORD_RESTORE);
					$search = array('%RESTORE_LINK%');
					$replace = array($restoreLink);
					$body = str_replace($search, $replace, $body);

					$mail = new DagMail([$email], "Ripristina la password", $body);
					$delivery = $mail->send();//del tipo ServerResponse
					$v = $delivery->val;
					$m = $delivery->val ? "è stata inviata un e-mail all'indirizzo indicato. Segui le istruzioni per ripristinare la password." : $delivery->msg;
				}
			}

 			return json_encode(new ServerResponse($v, $m));
		}







		/* inizializza i controlli per l'inserimento della nuova password
		*/
		public function restorePasswordInit($IDPcode, $restoreKey)
		{
			//se i dati dell'indirizzo non sono conformi
			if(!$IDPcode || !$restoreKey){
				$v = false;
				$m = "indirizzo non conforme";
			}else{
				//controlla se l'utente esiste, se è attivato,  se il codice di attivazione corrisponde
				$sql = "SELECT active, restoreKey FROM users WHERE IDPcode = '$IDPcode'";
				$user = parent::GetOneRowInfo($sql);
				if(!$user){
					$v = false;
					$m = "utente inesistente, procedi alla registrazione o contatta il nostro staff tecnico";
				}else{
					if($user->restoreKey != $restoreKey){
						$v = false;
						$m = "recupero non possibile,  il link che hai usato è scaduto o non è corretto. Tenta di nuovo la procedura di recupero";
					}else{
						$v = true;
						$m = "Inserisci la nuova password per il tuo account";
					}
				}
			}
			return json_encode(new ServerResponse($v, $m));
		}









		/*	reimposta la password
		*/
		public function restorePassword($IDPcode, $newPassword){
			$pw = password_hash($newPassword, PASSWORD_DEFAULT);

			if (!$IDPcode) {
					$v = false;
					$m = "Errore,  codice non conforme. Ripetere la procedura di ripristino.";
			} else {
					$sql = "UPDATE users SET password = '$pw' ,  restoreKey = null WHERE IDPcode = '$IDPcode'";
					$res = parent::SetDataInDB($sql);
					if ($res < 1) {
						$v = false;
						$m = "il server non è in grado di eseguire la richiesta ERR_USER_NOT_EXISTS. contatta il supporto tecnico.";
					} else {
						$v = true;
						$m = "Password reimpostata con successo. Prosegui con il login.";
					}
			}
			return json_encode(new ServerResponse($v, $m));
		}



	}//chiude la classe
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
 ?>
