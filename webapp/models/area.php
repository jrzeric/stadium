<?php

require_once('sqlsrvconnection.php');
require_once('exceptions/recordnotfoundexception.php');

	class Area {

		private $id;
		private $nombre;

		public function getId() { return $this->id; }
		public function setId($value) { $this->id = $value; }

		public function getNombre() { return $this->nombre; }
		public function setNombre($value) { $this->nombre = $value; }

		function __construct() {
			// empty object
			if (func_num_args() == 0) {
				$this->id = "";
				$this->nombre = "";
			}
			// object with data from database
			if (func_num_args() == 1) {
				$id = func_get_arg(0);

	      $connection = SqlSrvConnection::getConnection();
	      $query = 'select id, nombre from [catalogo].[areas_ctg] where id = ?';

	      $parameters = array($id);
	      $found = sqlsrv_query($connection, $query, $parameters);

	      if ($found) {
	        while ($row = sqlsrv_fetch_array($found)) {
	          $this->id = $row['id'];
	          $this->nombre = $row['nombre'];
	        }
	      } else new RecordNotFoundException();
			}
			// object with data from arguments
			if (func_num_args() == 2) {
				$arguments = func_get_args();

				$this->id = $arguments[0];
				$this->nombre = $arguments[1];
			}
		}

		// methods
		public function toJson() {
			return json_encode(array(
				'id' => $this->id,
				'nombre' => $this->nombre
			));
		}
	}

?>
