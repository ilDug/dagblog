<?php
require_once(__DIR__ . '/Engine.class.php');
require_once(__DIR__ . '/AppConfig.php');
require_once(__DIR__ . '/Email.class.php');


/**
 * gestisce le richieste
 */
class RequestManager extends Engine
{

    function __construct() {
        parent::__construct();
    }


    private function checkInputs($email, $title, $token){
        $email = $this->db->real_escape_string($email);
        $email  = filter_var($email, FILTER_VALIDATE_EMAIL);

        $title = $this->db->real_escape_string($title);


        //verifica la sicurezza
        if(!password_verify($token, REQUEST_AUTH_TOKEN)){ return false; }
        else if(!$email) { return false; }
        else if(!$title) { return false; }
        else return true;
    }



    public function addRequest($email, $title, $token){
        if(!$this->checkInputs($email, $title, $token)) { return '{"msg":"Peccato!  c\'e stato un problema con la tua richiesta. Controlla i dati iseriti."}'; }

        $res = $this->SetDataInDB("INSERT INTO requests (email, request) VALUES ('$email', '$title')");
        if($res == 0) { return '{"msg":"Peccato!  c\'e stato un problema con il server più tardi."}'; }
        else{
            $this->noticeAdministratorAboutRequest($title, $email);
            return '{"msg":"Evviva!  la tua richiesta è stata inviata. Faremo il possibile per creare il titolo che ti piace. Appena sarà disponibile ti avviseremo all\'indirizzo che hai indicato. Grazie."}';
        }
    }




    /**
     * manda l'avviso a DAG che una richiesta è stata inserita
     */
    public function noticeAdministratorAboutRequest($title, $sender){
        $body = "è stata aggiunta una nuova richiesta per il titolo : ${title} da ${sender}";
        $subject =  "nuova richiesta PB";
        $mailer = new PBMail('dag@posterbook.it', $subject, $body, 'support');
        $mailer->send();
    }


}


 ?>
