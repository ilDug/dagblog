<?php
require_once __DIR__ . '/script.class.php';

/**
 *
 */
class CookiesEnablerScript extends ScriptJS {

    function __construct() {
         $this->templatePath = '/cookies.enabler.template.html';
         $this->template = file_get_contents(__DIR__ . $this->templatePath);
    }
}


 ?>
