<?php

/**
 * classe generale per gli script
 */
class ScriptJS
{
    public $template;
    public $templatePath;

    function __construct() { }

    public function place(){
        echo $this->template;
    }
}

 ?>
