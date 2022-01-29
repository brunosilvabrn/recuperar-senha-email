<?php 

namespace App\model;

use PDO;

class BaseModel {

	public $host;
	public $user;
	public $password;
	public $dbname;

	function __construct() {
		$this->host = HOST;
		$this->user = USER;
		$this->password = PASSWORD;
		$this->dbname = DB_NAME;
	}

	public function connect() {
		try {
			$pdo = new PDO("mysql:dbname=".$this->dbname."; host=".$this->host, $this->user, $this->password);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $pdo;
		}catch(PDOException $e) {
			$error =  "ERROR: ".$e->getMessage();
			return $error;
		}
	}
}