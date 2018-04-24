<?php
/*-------------------------------------------------------------------------*/
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true ");
header("Access-Control-Allow-Headers: Origin, Authorization, Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control, X-Auth-Token");
header("Access-Control-Allow-Methods: GET,HEAD,PUT,PATCH,POST,DELETE");
/*-------------------------------------------------------------------------*/

    header('Content-Type: application/json');
    require_once 'PosterBookManager.class.php';

    // instanzia il manager
    $pbManager  = new PosterBookManager();



    /* suddivide il codice nelle sue componenti */
    function splitCode($code){
        $code = explode('.', $code);
        if(count($code) != 4 ) { die(); }
        // if(count($code) != 3 ) { throw new Exception('posterbook code incoerence'); }

        $parts = ['prefix', 'titleCode', 'subCode', 'revision'];
        $code =  array_combine ( $parts ,  $code );
        return (object)$code;
    }


    /**
     * filtra l'array degli items fino a che non trova quello che corrisponde al codice passato per url
     */
    function filterActivePBItem($items, $subCode){
        foreach ($items as $pbItem) {
            if($pbItem->subCode == $subCode){
                return array($pbItem);
                break;
            }
        }
    }


    //ottiene il parametro del posterbook
    $code = isset($_GET['pbcode']) ? $_GET['pbcode'] : null;

    if($code){
        $code = splitCode($code);


        foreach ($pbManager->posterBooks as $pb) {

            // primo filtro per posterbook
            if($pb->titleCode == ($code->prefix . '.' .$code->titleCode)){

                // filtra il posterbook per eliminare eventuali items non selezionati
                $items = filterActivePBItem($pb->items, $code->subCode);
                $pb->items =  isset($items) ? $items : [];

                echo json_encode($pb);
                die();
            }
        }
    }


    $pbManager->DbCloseConn();

 ?>
