<?php

require_once __DIR__ . '/../utility/string.utility.php';
require_once __DIR__ . '/../app-config.php';

/**
 * definizione dell'utente TIPO
 */
class User
{

    public $password;
    public $IDPcode;
    public $email;
    public $username;
    public $activationKey;

    function __construct() { }



    /**
     * crea un nuovo user pronto da inserire nel database
     */
    public function create($email,  $password){
        $this->username = trim(htmlspecialchars(strtolower($username), ENT_QUOTES));
        //$this->username = $this->db->real_escape_string($username);

        $email = strtolower(trim($email));
        $this->email = filter_var($email, FILTER_VALIDATE_EMAIL);

        $this->password = password_hash($password, PASSWORD_DEFAULT);

        $this->IDPcode = md5($email . microtime()); //la lunghezza deve essere max 32 o se no cambiare le impostazioni di controllo lunghezza
        $this->activationKey = StringTool::GetRandomString(ACTIVATION_KEY_LENGTH);

    }






    /**
     * crea la query
     */
     public function dbInsertQuery(){
$sql = <<<SQL
        INSERT INTO users SET
        email = '$this->email',
        password = '$this->password',
        active = 0,
        activationKey = '$this->activationKey',
        IDPcode = '$this->IDPcode'
SQL;
        return $sql;
     }




     /**
      * crea l'utente dai dati recuperati dal database
      */
     public function setFromDB($u){
         $this->email = $u->email;
         $this->IDPcode = $u->IDPcode;
         $this->activationKey = StringTool::GetRandomString(ACTIVATION_KEY_LENGTH);

     }




     /**
      * crea la quesri per la sostituzione dell'$activationKey
      */
     public function dbSetActivationKeyQuery(){
         return "UPDATE users SET activationKey = '$this->activationKey' WHERE IDPcode = '$this->IDPcode'";
     }





}

?>
