<?php
require_once(__DIR__ . '/../Engine.class.php');
require_once(__DIR__ . '/../ServerResponse.class.php');
require_once(__DIR__ . '/print.class.php');


class PrintManager extends Engine{

	public function __construct() {
		parent::__construct();
	}
//*****************************************************************************************************

	/**
	 * restituisce la lista dei titoli dei libri dal  database
	 */
	 public function list_(){

$sql = <<<SQL
		SELECT *
	 	FROM prints
		ORDER BY printDate DESC
SQL;
		 $list = parent::GetLists($sql);
		 $prints = array();
		 foreach ($list as $p) {
				$prints[] = new PBPrint($p);
		 }
		 return $prints;
	 }


	/**
	 * restituisce la lista dei titoli dei libri dal  database
	 */
	 public function group_(){

$sql = <<<SQL
		SELECT *
	 	FROM prints
		ORDER BY printcode ASC
SQL;
		 $list = parent::GetLists($sql);
		 $prints = array();
		 foreach ($list as $p) {
				$prints[$p->batch][] = new PBPrint($p);
		 }
		 return $prints;
	 }



	 public function add($print){
$sql = <<<SQL
		INSERT INTO prints SET
		printDate = $print->printDate ,
		printCode = $print->printCode ,
		orderCode = $print->orderCode ,
		pbCode = $print->pbCode ,
		title = $print->title ,
		dimensions = $print->dimensions ,
		material = $print->material ,
		stock = $print->stock ,
		sold = $print->sold ,
		saleDate = $print->saleDate ,
		recipient = $print->recipient
SQL;
		$res = $this->SetDataInDB($sql);
		if($res >= 0){
			$v = true;
			$m = "modifiche eseguite";
		}else{
			$v = false;
			$m = "errori nel data base";
		}

		return new ServerResponse($v, $m, $res);
	 }



	 public function update($print){
$sql = <<<SQL
		UPDATE prints SET
		printDate = $print->printDate ,
		printCode = $print->printCode ,
		orderCode = $print->orderCode ,
		pbCode = $print->pbCode ,
		title = $print->title ,
		dimensions = $print->dimensions ,
		material = $print->material ,
		stock = $print->stock ,
		sold = $print->sold ,
		saleDate = $print->saleDate ,
		recipient = $print->recipient
		WHERE ID = $print->ID
SQL;
		$res = $this->SetDataInDB($sql);
		if($res >= 0){
			$v = true;
			$m = "modifiche eseguite";
		}else{
			$v = false;
			$m = "errori nel data base";
		}


		return new ServerResponse($v, $m, $res);
	 }



//*****************************************************************************************************
}//chiude la classe
?>
