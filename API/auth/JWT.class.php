<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/RSAKey.class.php';

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Signer\Keychain; // just to make our life simpler
use Lcobucci\JWT\Signer\Rsa\Sha256; // you can use Lcobucci\JWT\Signer\Ecdsa\Sha256 if you're using ECDSA keys
/**
 * 1) genera un nuovo JWT
 * 2) verifica JWT in input
 * 3) valida JWT in input
 * 4) parsa il JWT e restituisce l'object del contenuto
 */

 class JWT{

    private $token;
    public $header;
    public $payload;
    public $valid = null;
    public $verified = null;
    public $pristine = true;
    public $checked = false;


    function  __construct($jwt =  null){
        if(!is_null($jwt)){
            $this->parse($jwt);
        }
    }




    /**
     * crea un JWT
     */
    public function generate($privKey, $passphrase, $data , $claims = []){

        $data->duration = isset($data->duration) ? $data->duration : (60 * 60 * 12);

        $signer = new Sha256();
        $keychain = new Keychain();
        $privateKey = $keychain->getPrivateKey($privKey, $passphrase);

        $builder = (new Builder())->setIssuer($data->iss) // Configures the issuer (iss claim)
                                ->setAudience($data->aud) // Configures the audience (aud claim)
                                ->setId($data->jti, true) // Configures the id (jti claim), replicating as a header item
                                ->setIssuedAt(time()) // Configures the time that the token was issue (iat claim)
                                ->setNotBefore(time()) // Configures the time that the token can be used (nbf claim)
                                ->setExpiration(time() + $data->duration) // Configures the expiration time of the token (exp claim)
                                ->set('sub', $data->sub) // Configures a new claim, called "uid"
                                ->set('uid', $data->uid); // user id uguale a sub

        foreach ($claims as $key => $value) { $builder->set($key, $value); }

        $token = $builder->sign($signer,  $privateKey) // creates a signature using your private key
                        ->getToken(); // Retrieves the generated token

        //assegna alla proprietà di classe
        $this->token = $token;

        //compila anche le altre proprietà
        $this->parse($token);

        //eventualmente ritorna la stringa
        return $token;
    }



    /**
     * funzione principale che esegue la verifica e la validazione
     */
    public function check($pubKey, $manifest){
        $this->checked = true;
        $this->pristine = false;
        $this->verify($pubKey);
        $this->validate($manifest);

        return $this->valid && $this->verified;
    }


    /**
     * valida i claims JTI ,  ISS ,  AUD e le date  enunciate dal MANIFEST
     */
    private function validate(JWTManifest $manifest){
        $data = new ValidationData(); // It will use the current time to validate (iat, nbf and exp)
        $data->setIssuer($manifest->iss);
        $data->setAudience($manifest->aud);
        //$data->setId($manifest->jti);
        $this->valid = $this->token->validate($data);
    }


    /**
     * vrficia che la SIGNATURE sia corretta ( usa RSA public key)
     */
    private function verify($pubKey){
        $signer = new Sha256();
        $keychain = new Keychain();
        $this->verified = $this->token->verify($signer, $keychain->getPublicKey($pubKey));
    }


    /**
     * imposta jwt da stringa in ingresso
     */
    private function parse($jwt){
        $token = (new Parser())->parse((string)$jwt);
        $this->token = $token;
        $this->header = $token ? $token->getHeaders() : null;
        $this->payload = $token ? $token->getClaims() : null;
    }

 }//chiude classe




 /**
  * MANIFEST per la validazione del token
  */
 class JWTManifest {
     public $iss;
     public $aud;
     public $jti;
     public $sub;
     public $uid;
     public $duration;

     function __construct($iss, $aud, $jti = null)
     {
         $this->iss = $iss ? $iss : null;
         $this->aud = $aud ? $aud : null;
         $this->jti = $jti ? $jti : null;
     }
 }

?>
