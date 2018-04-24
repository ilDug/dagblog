<?php
require_once __DIR__ . '/utility/date.utility.php';
require_once __DIR__ . '/utility/string.utility.php';
require_once __DIR__ . '/utility/http.utility.php';
require_once __DIR__ . '/utility/DB.engine.php';


class Engine extends DBEngine
{
	public $dateParser;
	public $stringTool;
	public $http;


	public function __construct(){
		$this->DbConnectAndSelect();
		$this->dateParser = new DateParser();
		$this->stringTool = new StringTool();
		$this->http = new HttpTool();
	}

   /**
   	* LE FUNZIONI DEL DATABASE
	* protected function 	DbConnectAndSelect(){
	* public function 		DbCloseConn(){$this->db->close();}
	* public function 		SetDataInDB($sql) {
	* public function 		GetOneRowInfo($sql, $type = "object") {
	* public function 		GetLists($sql, $type = "object") {
   */


}//chiude la classe
?>
