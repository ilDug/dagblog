<?php

define('META_TEMPLATE', __DIR__ . '/meta.template.html');
define('IMAGE_BASEURL', 'http://blog.dagtech.it/images/posts/');





/**
 * gestisce i meta delle pagine
 */
class Meta{
    private $placeholders = array(
        '%TITLE%',
        '%DESCRIPTION%',
        '%CODE%',
        '%URL%',
        '%KEYWORDS%',
        '%DATE_CREATION%',
        '%DATE_UPDATE%'
    );

    private $config;

    function __construct($post) {
        $this->config  = array(
             $post->title,
             $post->description,
             $post->code,
             $post->url,
             $this->tags($post->tags),
             $post->date->creation,
             $post->date->update
        );
    }


    /**
     * funzione che scrive i mssql_get_last_message
     */
    public function publish() {
        $body = file_get_contents(META_TEMPLATE);
        $meta = str_replace($this->placeholders, $this->config, $body);
        echo $meta;
    }



    /**
     * estre una stringa con tutte le keywords separate da virgola
     */
    protected function tags($tags){
        $t = 'dagtech, ';
        foreach ($tags as $tag => $value) { $t .= $tag . ', '; }
        return $t;
    }

}


 ?>
