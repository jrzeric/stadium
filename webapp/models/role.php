<?php
	/**
	*  Role Class
	*/
	require_once('exceptions/recordnotfoundexception.php');
	require_once('mysqlconnection.php');
	class Role
	{
		
		private $id;
		private $name;

		//getters & setters id
		public function getId() { return $this->id; }
		public function setId($value) { $this->id = $value; }

		//getters & setters name
		public function getName() { return $this->name; }
		public function setName($value) { $this->name = $value; }

		function __construct()
		{
						//empty object
			if(func_num_args() == 0)
			{
				$this->id = 0;
				$this->name = "";
			}//if

			//object with data from database
			if (func_num_args() == 1)
			{
				$arguments = func_get_args();
				$id = $arguments[0];
				//get connection
				$connection = MySqlConnection::getConnection();
				//query
				$query = 'select clave, nombre from admin.perfiles_ctg where clave = ?';
				//command
				$params = array($id);
				$command = sqlsrv_query($connection, $query, $params);
				$found = sqlsrv_has_rows($command);
				if ($found) 
				{
					 while($role = sqlsrv_fetch_array($command))
	            	{
						$this->id = $role['nombre'];
						$this->name = $role['clave'];
	            	} /*While*/
				}

				else throw new RecordNotFoundException();//throw exception if record not found
	            sqlsrv_free_stmt($command);
	            sqlsrv_close($connection);
			}

			if(func_num_args() == 2)
			{
				//get arguments
				$arguments = func_get_args();
				//pass values to the atributes from the array
				$this->id = $arguments[0];
				$this->name = $arguments[1];
			}//if	
		}//constructor

		public function toJson()
		{
			return json_encode(array(
				'id' => $this->id,
				'name' => $this->name));
		}//toJSON

	}
?>