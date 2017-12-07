<?php
	require_once('models/mysqlconnection.php');
	$connection = MySqlConnection::getConnection();
	echo $connection;
?>