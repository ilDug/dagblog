<?php
require_once(__DIR__ . '/Engine.class.php');


class PosterBookManager extends Engine{

	public $posterBooks = array();


	public function __construct() {
		parent::__construct();
		$this->bookList();
	}
//*****************************************************************************************************

	/**
	 * restituisce la lista dei titoli dei libri dal  database
	 */
	 private function bookList(){

$sql = <<<SQL
		SELECT *
	 	FROM posterbook
		WHERE hidden = 0
		ORDER BY title ASC
SQL;
		 $list = parent::GetLists($sql);
		 $books = array();
		 foreach ($list as $b) {
			if($b->hidden == 0){
					//$books[] = utf8_decode( json_decode( utf8_encode($b->object) ) );
					$books[] =  json_decode($b->object) ;
			}
		 }



		 //valuta il rank
		 $row1 = $this->rankingSums();
		 $sSum = max((int)$row1->sums[0], 0.1);
		 $iSum = max((int)$row1->sums[1], 0.1);
		 foreach ($books as  $b) {
			 foreach ($b->items as $pbi) {
			 	$pbi->rank = $this->rank($pbi, $iSum,  $sSum);
			 }
		 }




		 /** * comparatore per ordinamento rank */
		 function ranksort($a, $b){
			 $maxA = array();
			 foreach ($a->items as $pbi) { $maxA[] = $pbi->rank;}
			 $maxB = array();
			 foreach ($b->items as $pbi) { $maxB[] = $pbi->rank;}

			 return  max($maxA) >= max($maxB) ? -1 : 1;
		 }
		 usort($books, "ranksort");




		 //	assegna l'array
		 $this->posterBooks = $books;
	 }





	 /**
	  * calcola il  rank
	  */
	public function rank($pbi, $iSum, $sSum){
		$code = $pbi->titleCode. '.' . $pbi->subCode;
		$p = isset($pbi->promoFactor) ? $pbi->promoFactor : 0;

		//definizione di i
$sql = <<<SQL
		SELECT
    	COUNT( VALUE ) AS impressions
		FROM analytics
		WHERE SUBSTRING_INDEX( value , '.', 3 ) = '$code'
SQL;
		$i = $this->GetOneRowInfo($sql);
		$i = max((int)$i->impressions, 1);
		//definizione di s
$sql = <<<SQL
		SELECT
    	COUNT( ID ) AS sells
		FROM orders
		WHERE SUBSTRING_INDEX( pbCode , '.', 3 ) = '$code'
SQL;
		$s = $this->GetOneRowInfo($sql);
		$s = max((int)$s->sells, 0.1);

		$rank = (($s*$iSum)+($i*$sSum)) / (2*$iSum*$sSum) * (1+$p) * sqrt($s/$i);
		return $rank;
	}




	/**
	 * ritorna le ststistiche delle sommatorie di ventdite e impressioni
	 */
	private function rankingSums(){
$sql = <<<SQL
		SELECT
		count(analytics.value) as sums
		FROM analytics
		WHERE analytics.type = 'product_view'

		UNION

		SELECT
		count(orders.pbCode)
		FROM orders
SQL;
		 $row = $this->GetOneRowInfo($sql);
		 return $row;
	}





//*****************************************************************************************************
}//chiude la classe
?>
