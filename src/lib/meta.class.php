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
        '%MAIN_IMAGE%',
        '%URL%',
        '%KEYWORDS%'
    );

    private $config

    function __construct($post, $description = null) {
        $this->config  = array(
             $post->title,
             $description,
             IMAGE_BASEURL . $post->code .'.jpg',
             $post->url,
             $this->tags($post->tags)
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
        foreach ($tags as $key => $value) { $y .= $key . ', '; }
        return $t;
    }

}


 ?>
