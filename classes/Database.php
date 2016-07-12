<?php

class Database {
	
	private static $connection = null;
	private static $host = '192.186.234.5';  //'localhost';  
	private static $user = 'lorca_not_orca'; //'root'; 
	private static $pass = 'blarghy123';     //'root'; 
	private static $database = 'my_sakila';  //'sakila'; 

	public static function connect() {
		if (self::$connection) {
			return self::$connection;
		} else {
			self::$connection = new mysqli();
			self::$connection->connect(self::$host, self::$user, self::$pass, self::$database);
			if (self::$connection->connect_error)
				die('MySQLi error: '.self::$connection->connect_error);
			return self::$connection;
		}
	}

}

?>