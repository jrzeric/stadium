<?php

/**
* Employee class
*/

require_once('mysqlconnection.php');
require_once('user.php');
require_once('exceptions/invaliduserexception.php');

class Employee
{
	
	private $control;
	private $nombre;
	private $apPaterno;
	private $apMaterno;
	private $fechaContratacion;
	private $user;

	public function getControl() { return $this->control; }
	public function setContol($value) { $this->control = $value; }

	public function getNombre() { return $this->nombre; }
	public function setNombre($value) { $this->nombre = $value; }

	public function getApPaterno() { return $this->apPaterno; }
	public function setApPaterno($value) { $this->apPaterno = $value; }

	public function getApMaterno() { return $this->apMaterno; }
	public function setApMaterno($value) { $this->apMaterno = $value; }

	public function getFechaContratacion() { return $this->fechaContratacion; }
	public function setFechaContratacion($value) { $this->fechaContratacion = $value; }

	public function getUser() { return $this->user; }
	public function setUser($value) { $this->user = $value; }

	function __construct()
	{
		//empty object
		if (func_num_args() == 0) 
		{
			$this->control = '';
			$this->nombre = '';
			$this->apPaterno = '';
			$this->apMaterno = '';
			$this->fechaContratacion = '';
			$this->user = new User(); 
		}
		//object with data from database
		if (func_num_args() == 1) 
		{
			//get arguments
			$arguments = func_get_args();
			$control = $arguments[0];
			//get connection
			$connection = MySqlConnection::getConnection();
			//query
			$query = 'select control, apPaterno, apMaterno, nombre, fechaContratacion
					from admin.empleados
					where control = ?';
			$params = array($control);
			$command = sqlsrv_query($connection, $query, $params);
			$found = sqlsrv_has_rows($command);
			if ($found) 
			{
				 while($employee = sqlsrv_fetch_array($command))
            	{
                	$this->control = $employee['control'];
					$this->nombre = $employee['nombre'];
					$this->apPaterno = $employee['apPaterno'];
					$this->apMaterno = $employee['apMaterno'];
					$this->fechaContratacion = $employee['fechaContratacion'];
					$this->user = new User($employee['control']);
            	} /*While*/
			}

			else throw new InvalidUserException($control);//throw exception if record not found
            sqlsrv_free_stmt($command);
            sqlsrv_close($connection);
		}

		//object with data from arguments
		if (func_num_args() == 6) 
		{
			//get arguments
			$arguments = func_get_args();
			//pass arguments to attributes
			$this->control = $arguments[0];
			$this->nombre = $arguments[1];
			$this->apPaterno = $arguments[2];
			$this->apMaterno = $arguments[3];
			$this->fechaContratacion = $arguments[4];
			$this->user = new User($arguments[5]);
		}
	}//constructor

	public function toJson()
	{
		return json_encode(array(
			'control' => $this->control,
			'nombre' => $this->nombre,
			'apPaterno' => $this->apPaterno,
			'apMaterno' => $this->apMaterno,
			'fechaContratacion' => $this->fechaContratacion,
			'user' => json_decode($this->user->toJson())
		));
	}//toJSON


	public function add()
	{
		//get connection
		$connection = MySqlConnection::getConnection();
		//query
		$query = '	declare @respuesta varchar(250)
					exec usp_iUsuarios ?, ?, ?, ?, ?, ?, @respuesta output
					select respuesta = @respuesta';
		$params = array($this->user->getName(), $this->user->getPassword(), $this->apMaterno, $this->apPaterno, $this->nombre, $this->user->getRole()->getId());
		$command = sqlsrv_query($connection, $query, $params);
		$respuesta = sqlsrv_fetch_array($command);
		sqlsrv_free_stmt($command);
        sqlsrv_close($connection);
        
		if ($respuesta['respuesta'] == 'Registro exitoso') return true;

		else return false;
	}


		public static function getAll()
		{
			$list = array();
			//get connection
			$connection = MySqlConnection::getConnection();
			//query
			$query = 'select control, apPaterno, apMaterno, nombre, fechaContratacion from admin.empleados';
			$command = sqlsrv_query($connection, $query);
			while($employee = sqlsrv_fetch_array($command))
            {
				array_push($list, new Employee($employee['control'], $employee['nombre'], $employee['apPaterno'],
												$employee['apMaterno'], $employee['fechaContratacion'], $employee['control']));
            } /*While*/
            sqlsrv_free_stmt($command);
            sqlsrv_close($connection);
			//list
			return $list;
		}//getAll

		public static function getAllJson()
		{
			//list
			$list = array();
			//encode to json
			foreach (self::getAll() as $item) 
			{
				array_push($list, json_decode($item->toJson()));
			}//foreach
			return json_encode(array('employees' => $list));
		}


}

?>