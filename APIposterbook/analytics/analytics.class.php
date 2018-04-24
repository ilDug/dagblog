<?php
require_once(__DIR__ . '/../Engine.class.php');
require_once(__DIR__ . '/../ServerResponse.class.php');


/**
 * classe per statistiche
 */
class PBAnalytics extends Engine
{

    function __construct(){ parent::__construct(); }



    /**
     * registra la visualizzazioen della pagina
     */
    public function setPageview($url){
        $sql = "INSERT INTO analytics (type, param, value) VALUES ('page_view', 'url', '$url')";
        $res = parent::SetDataInDB($sql);
        return new ServerResponse(($res > 0) , $res);
    }


    /**
     * registra la visualizzazioen della prodotto
     */
    public function setPosterView($pbcode){
        $sql = "INSERT INTO analytics (type, param, value) VALUES ('product_view', 'pbcode', '$pbcode')";
        $res = parent::SetDataInDB($sql);
        return new ServerResponse(($res > 0) , $res);
    }


}


 ?>
