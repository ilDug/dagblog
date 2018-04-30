<?php
require_once __DIR__ . '/../engine.class.php';


class ViewsManager extends Engine {

    function __construct() { parent::__construct(); }

    /**
     * ottiene il numero di visite di un post
     */
    public function getViews($code){
        $res = $this->GetOneRowInfo("SELECT COUNT(ID) as views from views WHERE code = $code");
        echo $res->views;
    }



    /**
     * aggiunge una viista e restituisce il numero di visite aggiornato
     */
    public function addViews($code){
        $res = $this->GetOneRowInfo("INSERT INTO views SET code = $code");
        if($res > 0 ) $this->getViews($code);
    }
}

 ?>
