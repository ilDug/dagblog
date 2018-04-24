<?php
require_once(__DIR__ . '/../Engine.class.php');
require_once(__DIR__ . '/../ServerResponse.class.php');


class PosterBookManager extends Engine{

	public function __construct() {
		parent::__construct();
	}
//*****************************************************************************************************

	/**
	 * restituisce la lista dei titoli dei libri dal  database
	 */
	 public function list_(){

$sql = <<<SQL
		SELECT object
	 	FROM posterbook
		ORDER BY title ASC
SQL;
		 $list = parent::GetLists($sql);
		 $library = array();
		 foreach ($list as $book) {
				$library[] = json_decode($book->object);
		 }
		 return $library;
	 }



	 public function update($ID, $posterbook){
$sql = <<<SQL
		UPDATE posterbook
	 	SET object = '$posterbook'
		WHERE ID = $ID
SQL;
		$res = $this->SetDataInDB($sql);
		if($res >= 0){
			$v = true;
			$m = "modifiche eseguite";
		}else{
			$v = false;
			$m = "errori nel data base";
		}

		return new ServerResponse($v, $m, $sql);
	 }



//*****************************************************************************************************
}//chiude la classe
?>
