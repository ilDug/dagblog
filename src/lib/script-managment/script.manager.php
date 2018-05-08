<?php
require_once __DIR__ . '/iubenda.script.php';
require_once __DIR__ . '/cookies.enabler.script.php';
require_once __DIR__ . '/structured.data.script.php';
require_once __DIR__ . '/google.analytics.script.php';
require_once __DIR__ . '/google.adsense.script.php';





/**
 * esegue
 */
class ScriptJSManager {


    private $scriptList ;




    function __construct($post = null) {

        $this->scriptList = array(
            'iubenda' => (new IubendaScript()),
            'analytics' => (new GoogleAnalyticsScript()),
            'cookiesenabler' => (new CookiesEnablerScript()),
            'structureddata' => (new StructuredDataScript($post)),
            'adsense' => (new GoogleAdsenseScript())
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
