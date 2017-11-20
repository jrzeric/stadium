<?php
	//require_once('mysqlconnection.php');
	//$connection = MySQLConnection::getConnection();
	//echo $connection;
	require_once('employee.php');
	$e = new Employee(100);
	echo $e->getNombre();
?>