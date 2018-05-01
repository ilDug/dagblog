<?php
require_once(__DIR__ . '/../app-config.php');


class DBEngine
{
	public $db;//oggetto MYSQLI


	public function __construct(){
        $this->DbConnectAndSelect();
	}


	/**
	 * metodo di connessione al database
	 */
	protected function DbConnectAndSelect(){
		$this->db = new mysqli(HOST, USER, DBPASS, DB);
		if ($this->db->connect_error) {die("DAG_CONNECTION_ERR connection error  - Database non disponibile <br> " . $this->db->connect_error);}
	}



	/**
	* chiude la connessione al server
	*/
	public function DbCloseConn(){$this->db->close();}//metodo di chiusura della connessione al database




	/**
	* query di tipo UPDATE o DELETE di righe nel database
    * @param la query mysql
	* @return il numero di righe elaborate dal database. -1 indica errori
	*/
	public function SetDataInDB($sql) {
		$result = $this->db->query($sql);
		return $this->db->affected_rows;
	}




	/**
	* restituisce un array generico  o un oggetto su richiesta di un query di tipo SELECT
    * @param la query mysql
    * @return un singolo risultato di database
	*/
	public function GetOneRowInfo($sql, $type = "object") {
		$data = $this->db->query($sql);
		if(!$data) return false;

		switch ($type) {
			case 'array':
				$row = $data->fetch_assoc();
				break;
			case 'object':
				$row = $data->fetch_object();
				break;
		}
		return $row;
	}




	/**
	* restituisce un array LISTA con i dati richiesti nella query passata come argomento
	* utilizzato in altri metodi interni di questa classe o classi figlie
    * @param la query mysql
    * @return un array di obggetto (o array multidimensionale)
	*/
	public function GetLists($sql, $type = "object") {
		$data = $this->db->query($sql);
		if(!$data) return false;

		switch ($type) {
			case 'array':
				while($row = $data->fetch_assoc()) { $result[] = $row; };
				break;
			case 'object':
				while($row = $data->fetch_object()) { $result[] = $row; }
				break;
		}

		if($result){return $result;}
		else return false;
	}



}//chiude la classe
?>
