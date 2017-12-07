<?php
	class SqlSrvConnection {
		//returns a MySQL connection object
		public static function getConnection() {
			//open configuration file
			$configPath = $_SERVER['DOCUMENT_ROOT'].'/stadium/webapp/config/sqlsrvconnection.json';
			$configData = json_decode(file_get_contents($configPath),true);
			//check parameters
			if (isset($configData['server']))
				$server = $configData['server'];
			else {
				echo 'Configuration error, server name not found'; die;
			}
			if (isset($configData['database']))
				$database = $configData['database'];
			else {
				echo 'Configuration error, database name not found'; die;
			}
			if (isset($configData['user']))
				$user = $configData['user'];
			else {
				echo 'Configuration error, username not found'; die;
			}
			if (isset($configData['password']))
				$password = $configData['password'];
			else {
				echo 'Configuration error, password not found'; die;
			}
			//create connection
			$connectionInfo = array("Database"=>$database, "UID"=>$user, "PWD"=>$password);
			$connection = sqlsrv_connect($server, $connectionInfo);
			//character set
			//$connection->set_charset('utf8');
			//check connection
			if (!$connection) { echo 'Could not connect to SqlSrv'; die; }
			//return connection
			return $connection;

		}

		public static function getConnectionVendedor() {
			//open configuration file
			$configPath = $_SERVER['DOCUMENT_ROOT'].'/stadium/webapp/config/seller.json';
			$configData = json_decode(file_get_contents($configPath),true);
			//check parameters
			if (isset($configData['server']))
			else {
				$server = $configData['server'];
				echo 'Configuration error, server name not found'; die;
			}
			if (isset($configData['database']))
				$database = $configData['database'];
			else {
				echo 'Configuration error, database name not found'; die;
			}
			if (isset($configData['user']))
				$user = $configData['user'];
			else {
				echo 'Configuration error, username not found'; die;
			}
			if (isset($configData['password']))
				$password = $configData['password'];
			else {
				echo 'Configuration error, password not found'; die;
			}
			//create connection
			$connectionInfo = array("Database"=>$database, "UID"=>$user, "PWD"=>$password);
			$connection = sqlsrv_connect($server, $connectionInfo);
			//character set
			//$connection->set_charset('utf8');
			//check connection
			if (!$connection) { echo 'Could not connect to SqlSrv'; die; }
			//return connection
			return $connection;

		}

		public static function getConnectionAdministrador()
		{
			//open configuration file
			$configPath = $_SERVER['DOCUMENT_ROOT'].'/stadium/webapp/config/admin.json';
			$configData = json_decode(file_get_contents($configPath),true);
			//check parameters
			if (isset($configData['server']))
				$server = $configData['server'];
			else {
				echo 'Configuration error, server name not found'; die;
			}
			if (isset($configData['database']))
				$database = $configData['database'];
			else {
				echo 'Configuration error, database name not found'; die;
			}
			if (isset($configData['user']))
				$user = $configData['user'];
			else {
				echo 'Configuration error, username not found'; die;
			}
			if (isset($configData['password']))
				$password = $configData['password'];
			else {
				echo 'Configuration error, password not found'; die;
			}
			//create connection
			$connectionInfo = array("Database"=>$database, "UID"=>$user, "PWD"=>$password);
			$connection = sqlsrv_connect($server, $connectionInfo);
			//character set
			//$connection->set_charset('utf8');
			//check connection
			if (!$connection) { echo 'Could not connect to SqlSrv'; die; }
			//return connection
			return $connection;
		}


	}
?>
