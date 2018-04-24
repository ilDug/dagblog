<?php
require_once __DIR__ . '/auth.config.php';
/**
 * WORKFLOW .:
 * - generare una chiave privata ogni tanto per una questione di rivambio di sicurezza.
 * - le vecchie chiavi vengono comunque mantenute.
 *   ricordarsi di eliminarle ogni tanto le più vecchie
 * - ottenere le chiavi pubbliche per la verifica della crittografia.
 *   si possono ottenere tutte quelle salvate in ordine cronologico a partire da quella più recente
 */


 class RSAKey{

     // array delle ciavi pubbliche
     public $publics = array();

     // numero di chiavi pubbliche/private contenute nell'istanza dell'oggetto
     public $publicsCount;



    function __construct($passPhrase = null){
        $this->initKeys($passPhrase);
    }





    /**
     * inizializza l'array di chiavi pubbliche e altre proprietà
     */
    private function initKeys($passPhrase){
        $keys = $this->listPrivate();
        if(count($keys) == 0 ) {$this->publicsCount = 0 ; return false;}

        //popola l'array delle chiavi pubbliche
        foreach ($keys as $k) {
            $this->publics[]  = $this->constructPublics($k, $passPhrase);
        }

        //imposta la quantità di chieavi disponibili nella proprietà dedicata
        $this->publicsCount = count($this->publics);

    }






    /**
    * genera una chiave privata RSA SHA512
    * e la salva su file
    * @param una passPhrase
    * @param [optional] il numero di bits della lunghezza della kyave privata generata
    * @return boolean per la creazione della chiave
    */
    public function generatePrivate($passPhrase ,  $bits = 2048){
        $config = array(
            "digest_alg" => "sha256",
            "private_key_bits" => $bits,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        );

        $path = RSA_KEY_DIR . '/pKey' . time(). '.pem';

        // Create the private key
        $key = openssl_pkey_new($config);

        $resExport = openssl_pkey_export_to_file($key, $path, $passPhrase);
        return $resExport;
    }






    /**
     * restituisce la chiave privata attiva
     */
    public function getPrivate($passPhrase){
        //ottiene l'ultimo file delle chiavi
        $keys = $this->listPrivate();
        $f = file_get_contents($keys[0]);

        //apre la chiave con passPhrase
        $pKey = openssl_pkey_get_private($f, $passPhrase);
        if(!$pKey) return false;

        // ottiene  la rappresentazone sottoforma di stringa della chiave e la restituisce
        $keyString = null;
        openssl_pkey_export($pKey, $keyString, $passPhrase);

        // $privKeyBox = new stdClass();
        //$privKeyBox = (object) array();
        //$privKeyBox->key = $keyString;
        //$privKeyBox->passphrase = $passPhrase;
        return $keyString;
    }







    /**
     * genera una chiave pubblica da quella privata
     * @param string il nome del file .pem che contiene la chiave privata
     */
    private function constructPublics($filename = false, $passPhrase = null){
        if(!$filename) return false;

        $f = file_get_contents($filename);
        $pKey = openssl_pkey_get_private($f, $passPhrase);
        if(!$pKey) return false;

        //costruisce la chiave pubblica e la ritorna;
        $details = openssl_pkey_get_details($pKey);
        if(!$details) return false;
        else return $details['key'];
    }







    /**
     * ottiene l'elenco delle chiavi salvate nella cartella corrente
     */
	private function listPrivate() {
		$ArrayEstensioni = array('.pem');
		$arrayFilesName=array();

		$handle = opendir(RSA_KEY_DIR);
		while (false !== ($file = readdir($handle)))
			{
				if(is_file(RSA_KEY_DIR .  $file))
					{
						$ext = strtolower(substr($file, strrpos($file, "."), strlen($file)-strrpos($file, ".")));//estrae l'estensione del file
						if(in_array($ext,$ArrayEstensioni))
							{
                                array_push($arrayFilesName,(RSA_KEY_DIR . $file));
							}
					}
			}

		$handle = closedir($handle);
		rsort($arrayFilesName);

		return $arrayFilesName;
	}


 }//chiude classe

?>
