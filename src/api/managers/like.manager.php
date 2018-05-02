<?php
require_once __DIR__ . '/../engine.class.php';


class LikeManager extends Engine {

    function __construct() { parent::__construct(); }

    /**
     * ottiene il numero di like di un post
     */
    public function likes($code){
        $res = $this->GetOneRowInfo("SELECT counter FROM likes WHERE code  = $code");
        return $res->counter;
    }



    /**
     * aggiunge una like e restituisce il numero di like aggiornato
     */
    public function like($code){
        //verifca se esiste il record per questo post oppure è nuovo
        $check = $this->GetOneRowInfo("SELECT COUNT(code) AS exist FROM likes WHERE code = $code");

        //aggiunge o incrementa
        if($check->exist <= 0 ){
            $res = $this->SetDataInDB("INSERT INTO likes (code, counter) VALUES ($code, 1)");
        }else{
            $res = $this->SetDataInDB("UPDATE likes SET counter = counter + 1 WHERE code = $code");
        }

        //restituisce i likes aggiornati
        return $this->likes($code);
    }



    /**
     * rimuove una like e restituisce il numero di like aggiornato
     */
    public function dislike($code){
        //decrementa
        $this->SetDataInDB("UPDATE likes SET counter = counter - 1 WHERE code = $code");

        //restituisce i likes aggiornati
        return $this->likes($code);
    }
}

 ?>
