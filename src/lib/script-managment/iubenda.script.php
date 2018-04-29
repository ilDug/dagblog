<?php
require_once __DIR__ . '/script.class.php';

/**
 *
 */
class IubendaScript extends ScriptJS {

    function __construct() {
         $this->templatePath = '/iubenda.template.html';
         $this->template = file_get_contents(__DIR__ . $this->templatePath);
    }
}


 ?>
