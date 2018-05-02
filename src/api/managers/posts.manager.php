<?php
require_once __DIR__ . '/../engine.class.php';
define('POST_DIRECTORY', __DIR__. '/../../posts/archive');


class PostsManager extends Engine {

    function __construct() { parent::__construct(); }


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

                 if($ext == 'json') {
                     $list[$codefilename] = json_decode( file_get_contents($file) );
                 }
             }
         }

         return $list;
     }




     private function getViews($limit){
         $populars = $this->GetLists("SELECT code as post, COUNT(ID) as views from views GROUP BY code ORDER BY views DESC, date ASC LIMIT 0,$limit ");
         return $populars;
         //nella forma { views: "xxxxx", post: "yyyyyy" }
     }



     public function popular($limit){
         $posts = $this->getPosts();
         $populars = $this->getViews($limit);

         $list = array();

         foreach ($populars as $p) {
             $list[] = $posts[$p->post];
         }
         return $list;
     }





}

 ?>
