<?php
require_once __DIR__ . '/../lib/ParseDown.php';
define('POST_DIRECTORY', __DIR__. '/archive');



/**
 * classe che gestisce il caricamento del post
 */
class PostListManager {
    public $posts = array(); //il contenuto dell'articolo
    public $list = array();



    function __construct($page = 1) {
        //carica i post dai files
        $this->posts = $this->getPosts();

        //imposta il limite in base alal dimensione dell'array
        $limit = count($this->posts) < 7 ? count($this->posts) : 7;

        $start = ($page-1)*$limit;
        $end = ($page*$limit)-1;
        //carica i post filtrati per pagina
        for ($i= $start; $i <= $end; $i++) {
            $this->list[] = $this->posts[$i] ? $this->posts[$i] : null;
        }
    }




    /** handelr dei files */
    protected function getPosts(){
        $list = array();
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
                //aggiunge solo i file json
                if($ext == 'json') {
                    $list[] = json_decode( file_get_contents($file) );
                }
            }
        }
        usort($list,  $this->sortPostByDate);
        return $list;

    }



    /**
     * ordine per data
     */
    private function sortPostByDate($a, $b){
        $date_a = $a->date->update ? strtotime($a->date->update) : 0;
        $date_b = $b->date->update ? strtotime($b->date->update) : 0;

        if ($date_a == $date_b) { return 0; }
        return ($date_a < $date_b) ? -1 : 1;
    }


}

?>
