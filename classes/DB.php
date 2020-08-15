<?php
class DB extends DBcore{
	
	public function verifyUser($username, $password){
		$hashed = md5($password);
		$query = "SELECT user_id, uid 
					FROM users 
					WHERE uid=:username 
						AND pwd=:password";
		$values = array('username'=>$username, 'password'=>$hashed);
//		$this->logQueryAndValues($query, $values, 'verifyUser');
		$rows = $this->select($query, $values);
		return (isset($rows[0]['user_id']) ? $rows[0]['user_id'] : false);
	}

	//////////////////////////////////////////////////////////////////////////////////

	public function genericSelect($query, $values=array(), $pdoFetch=PDO::FETCH_ASSOC){
//		$this->logQueryAndValues($query, $values, 'genericSelect');
		return $this->select($query, $values, $pdoFetch);
	}

	public function __construct(){
		parent::__construct(self::HOST, self::USER, self::PASS, self::DB_TABLES);
	}

	const DB_TABLES = array();
	const HOST = 'mysql:host=localhost;dbname=davpeter_dino';
	const USER = 'davpeter_dino';
	const PASS = 'jAm3sD3aN';
}