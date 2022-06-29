<?php
class pre_system{
	
	public function action(){

		/*
		* SET DEFAULT TIMEZONE
		*/
		date_default_timezone_set(TIMEZONE);
		define("NOW", date("Y-m-d H:i:s"));

		/*
		* CREATE SESSION TABLE
		*/
		$this->create_table_session();
	}

	public function create_table_session(){
		$servername = DB_HOST;
		$username = DB_USER;
		$password = DB_PASS;
		$dbname = DB_NAME;

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}

		// sql to create table
		$sql = "CREATE TABLE IF NOT EXISTS `sp_sessions` (
		        `id` varchar(128) NOT NULL,
		        `ip_address` varchar(45) NOT NULL,
		        `timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
		        `data` blob NOT NULL,
		        KEY `ci_sessions_timestamp` (`timestamp`));";

		if ($conn->query($sql) === FALSE) {
		    echo "Error creating table: " . $conn->error;
		    exit(0);
		}

		$conn->close();
	}
}