<?php
require_once __DIR__ . '/script.class.php';

/**
 *
 */
class GoogleAnalyticsScript extends ScriptJS {

    function __construct() {
         $this->templatePath = '/google.analytics.template.html';
         $this->template = file_get_contents(__DIR__ . $this->templatePath);
    }
}


 ?>
