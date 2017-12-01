<?php

	class Evento {

		// attribures
		private $id;
		private $nombre;
		private $fecha;
		private $descripcion;
		private $imagen;

		// getters and setters
		public function getId() { return $this->id; }
		public function setId($value) { $this->id = $value;}

		public function getNombre() { return $this->nombre; }
		public function setNombre($value) { $this->nombre = $value; }

		public function getFecha() { return $this->fecha; }
		public function setFecha($value) { $this->fecha = $value; }

		public function getDescripcion() { return $this->descripcion; }
		public function setDescripcion($value) { $this->descripcion = $value; }

		public function getImagen() { return $this->imagen; }
		public function setImagen($value) { $this->imagen = $value; }

		// constructors
		function __construct() {
			// empty object
			if (func_num_args() == 0) {
				$this->id = 0;
				$this->nombre = "";
				$this->fecha = "";
				$this->descripcion = "";
				$this->imagen = "";
			}
			// object with data from database
			if (func_num_args() == 1) {
				$id = func_get_arg(0);

				$connection = SqlSrvConnection::getConnection();
		    $query = 'select id, nombre, fecha, descripcion, imagen from [admin].[eventos] where id = ?';

				$parameters = array($id);
				$found = sqlsrv_query($connection, $query, $parameters);

				if ($found) {
					while ($row = sqlsrv_fetch_array($found)) {
	          $this->id = $row['id'];
	          $this->nombre = $row['nombre'];
	          $this->fecha = $row['fecha'];
	          $this->descripcion = $row['descripcion'];
	          $this->imagen = $row['imagen'];
					}
				}
			}
			// object with data from arguments
			if (func_num_args() == 5) {
				$arguments = func_get_args();

				$this->id = $arguments[0];
				$this->nombre = $arguments[1];
				$this->fecha = $arguments[2];
				$this->descripcion = $arguments[3];
				$this->imagen = $arguments[4];
			}
		}

		// methods
		public function toJson() {
			return json_encode(array(
				'id' => $this->id,
				'nombre' => $this->nombre,
				'fecha' => $this->fecha,
				'descripcion' => $this->descripcion,
				'imagen' => $this->imagen
			));
		}
	}

?>
