<?php
require_once __DIR__ . '/script.class.php';

/**
 *
 */
class StructuredDataScript extends ScriptJS {

    private $placeholders = array(
        '%TITLE%',
        '%DESCRIPTION%',
        '%CODE%',
        '%URL%',
        '%HEADLINE%',
        '%DATE_CREATION%',
        '%DATE_UPDATE%'
    );

    function __construct($post) {
            $config  = array(
                 $post->title,
                 $post->description,
                 $post->code,
                 $post->url,
                 $post->description,
                 $post->date->creation,
                 $post->date->update
            );
            $this->templatePath = '/structured.data.template.html';
            $body = file_get_contents(__DIR__ . $this->templatePath);
            $this->template = str_replace($this->placeholders, $config, $body);
    }
}


 ?>
