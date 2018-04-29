<?php
require_once __DIR__ . '/iubenda.script.php';
require_once __DIR__ . '/google.analytics.script.php';





/**
 * esegue
 */
class ScriptJSManager {


    private $scriptList ;




    function __construct() {

        $this->scriptList = array(
            'iubenda' => (new IubendaScript()),
            'analytics' => (new GoogleAnalyticsScript())
        );

    }





    public function writeScripts($list = []){
        // se non viene passato nessun parametro utilizza la lista inizializzata nel contructor
        if(count($list) == 0){ $list = $this->scriptList; }

        foreach ($list as $script) {
            $this->scriptList[$script]->place();
        }

    }




}


 ?>
