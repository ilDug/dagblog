<?php
require_once __DIR__ . '/../lib/ParseDown.php';
define('POST_DIRECTORY', __DIR__. '/archive');



/**
 * classe che gestisce il caricamento del post
 */
class PostArchiveManager
{
    public $post; //il contenuto dell'articolo
    public $data;



    function __construct($code = null) {
        // ERRORE codice mancante
        if(!$code || is_null($code) ) throw new Exception("Error, empty code", 1);

        $lookup = $this->getPost($code);
        if (!$lookup->content) { throw new Exception("Error, no content file [DAG_ERR_NO_CONTENT]", 2); }
        if (!$lookup->data) { throw new Exception("Error, no data file [DAG_ERR_NO_DATA]", 3); }

        $Parsedown = new Parsedown();
        $this->post = $Parsedown->text($lookup->content);
        $this->data = $lookup->data;
    }




    /** handelr dei files */
    protected function getPost($code){
        $result = (object)array('data'=>null, 'content'=>null);

        //apre la directory
        $handle = opendir(POST_DIRECTORY);

        //itera gli elementi della cartella
        while (false !== ($item = readdir($handle))) {

            $file = POST_DIRECTORY.'/'.$item;
            if(is_file($file)) {

                //filtra per estensione
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                //ottine il codice dal nome del file
                $filename = pathinfo($file, PATHINFO_FILENAME);
                // ottiene il codie all'interno del nome de file
                $codefilename = (int)( explode('.', $filename)[0] );

                if($codefilename == $code){
                    //  DATA
                    if($ext == 'json') {
                        $result->data = json_decode( file_get_contents($file) );
                    }

                    // CONTENT
                    if($ext == 'md') {
                        $result->content = file_get_contents($file);
                    }
                }
            }
        }

        return $result;
    }


}

?>
