<?php
require_once __DIR__ . '/script.class.php';

/**
 *
 */
class GoogleAdsenseScript extends ScriptJS {

    function __construct() {
         $this->templatePath = '/google.adsense.template.html';
         $this->template = file_get_contents(__DIR__ . $this->templatePath);
    }
}


 ?>
