<?php

	/**
	* Area class
	*/
	class Area
	{
		
		private $id;
		private $nombre;
		private $color;

		public function getId() { return $this->id; }
		public function setId($value) { $this->id = $value; }

		public function getNombre() { return $this->nombre; }
		public function setNombre($value) { $this->nombre = $value; }

		public function getColor() { return $this->color; }
		public function setColor($value) { $this->color = $value; }


		function __construct()
		{
			
		}
	}

?>