<?php
require_once __DIR__ . '/../vendor/autoload.php' ;
require_once __DIR__ . '/JWT.class.php';
require_once __DIR__ . '/RSAKey.class.php';
require_once __DIR__ . '/AuthConfig.php';

/**
 * classe creata per i controlli di autorizzazione e autenticazione
 * si istanzia con gli header di del protoccollo http
 *          $requestHeaders =  apache_request_headers();
 * da ottenere all'inizio del file;
 * ogni operazione deve contenere
 *          $auth = new Auth($requestHeaders['Authorization']);
 *          $userIDP = $auth->isAuthenticated ? $auth->claims['uid'] : null;
 */

class Auth {

    public $isAuthenticated; //controlla che JWT sia verificato
    public $isAuthorized; //controlla che l'utente abbia i permessi
    public $claims = array(); //i dati contenuti nel token di autenticazione

    private $token;


    function __construct($headers, $autoAuth = true){
        //inizializza i valori
        $this->isAuthenticated = false;
        $this->isAuthorized = false;

        if($headers){
            $this->claims = $this->loadToken($headers);
            if($autoAuth){ $this->authentication(); }
        }else {
            //$this->unauthorize401();
        }
    }






    /**
     * carica i dati del token nella proprietà interna
     * @return payload no verified
     */
    private function loadToken($headers){
        //$authorizationHeader = $headers['Authorization'];
        $authorizationHeader = $headers;
        if(!$authorizationHeader) throw new Exception("header non contiene il valore  Authorization " . json_encode($headers));

        $rawToken = str_replace('Bearer ', '', $authorizationHeader);
        $this->token = new JWT($rawToken);

        if(!$this->token) throw new Exception("non è stato possibile istanziare un token corretto");

        return $this->token->payload;
    }




    /**
     * ritorna il payload se autenticato o null;
     * se impostato $http, ritorna header 401
     */
    private function authentication($http = true){
        if ($this->token == null) {
            if($http){$this->unauthorize401();}
            return false;
        }

        try {
            $key = new RSAKey(RSA_KEY_PASSPHRASE);
            $manifest = new JWTManifest(JWT_ISS , JWT_AUD);

            if($key->publicsCount ==0) return false;
            for ($i=0; $i < $key->publicsCount ; $i++) {
                $this->isAuthenticated = $this->token->check($key->publics[$i], $manifest);
                if($this->isAuthenticated){ return true ;}
            }
            //se non viene trovato un token valido e verificato ritorna null
            if($http){$this->unauthorize401();}
            return false;

        } catch (Exception $e) {
            if($http){$this->unauthorize401();}
            return false;
        }

    }


    /**
     * to do
     */
    private function authorization(){
        //to do
    }



    /**
     * imposta gli header 401
     */
    private function unauthorize401(){
        header('HTTP/1.0 401 Unauthorized');
        echo "Invalid token or key";
        exit();
    }

}//chiude la classe




 ?>
