<?php

require_once __DIR__ . '/../utility/string.utility.php';
require_once __DIR__ . '/../AppConfig.php';

/**
 * definizione dell'utente TIPO
 */
class User
{

    public $password;
    public $IDPcode;

    function __construct() { }

    /**
     * crea un nuovo user
     */
    public function create($password){
        $this->username = trim(htmlspecialchars(strtolower($username), ENT_QUOTES));
        //$this->username = $this->db->real_escape_string($username);

        $email = strtolower(trim($email));
        $this->email = filter_var($email, FILTER_VALIDATE_EMAIL);

        $this->password = password_hash($password, PASSWORD_DEFAULT);

        $this->IDPcode = md5($email . microtime()); //la lunghezza deve essere max 32 o se no cambiare le impostazioni di controllo lunghezza    
    }

}

?>
