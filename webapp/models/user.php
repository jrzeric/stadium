<?php

/**
* User class
*/
require_once('role.php');
require_once('exceptions/invaliduserexception.php');
require_once('mysqlconnection.php');

class User
{
	
	private $name;
	private $password;
	private $role;
	private $status;


	public function getName() { return $this->name; }
	public function setName($value) { $this->name = $value; }

	public function getPassword() { return $this->password; }
	public function setPassword($value) { $this->password = $value; }

	public function getRole() { return $this->role; }
	public function setRole($value) { $this->role = $value; }

	public function getStatus() { return $this->status; }
	public function setStatus($value) { $this->status = $value; }

	function __construct()
	{
		//empty object
		if (func_num_args() == 0) 
		{
			$this->name = '';
			$this->password = ''; 
			$this->role = new Role();
			$this->status = '';
		}
		//object with data from database
		if (func_num_args() == 1) 
		{
			$arguments = func_get_args();
			$control = $arguments[0];
			//get connection
			$connection = MySqlConnection::getConnection();
			//query
			$query = 'select perfil, nombre, status
					from admin.usuarios 
					where empleado = ?';
			//command
			$params = array($control);
			$command = sqlsrv_query($connection, $query, $params);
			$found = sqlsrv_has_rows($command);
			if ($found) 
			{
				 while($user = sqlsrv_fetch_array($command))
            	{
					$this->name = $user['nombre'];
					$this->status = $user['nombre'];
					$this->role = new Role($user['perfil']);
					$this->password = '';
            	} /*While*/
			}

			else throw new InvalidUserException($control);//throw exception if record not found
            sqlsrv_free_stmt($command);
            sqlsrv_close($connection);
		}
		//object with data from arguments
		if (func_num_args() == 3) 
		{
			//get arguments
			$arguments = func_get_args();
			//pass arguments to attributes
			$this->nombre = $arguments[0];
			$this->password = $arguments[1];
			$this->role = $arguments[2];
		}
	}//Constructor

	public function toJson()
	{
		return json_encode(array(
			'nombre' => $this->name,
			'contrasena' => $this->password,
			'status' => $this->status,
			'role' => json_decode($this->role->toJson())
		));
	}//toJSON
}

?>