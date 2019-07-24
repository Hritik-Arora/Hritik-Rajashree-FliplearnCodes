<?php

require_once "dbConn.php";

class DBInteractionNew
{
	public function getDBConnection($database = 'school_api') {
		global $serverArr;
		$servername = $serverArr[$database]['hostname'];
		$username = $serverArr[$database]['username'];
		$password = $serverArr[$database]['password'];
		try {
			$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch(PDOException $e) {
			$e->getMessage();
		}
		return $conn;
	}


}
