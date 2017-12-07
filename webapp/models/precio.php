<?php

require_once('sqlsrvconnection.php');
require_once('exceptions/recordnotfoundexception.php');
require_once('evento.php');
require_once('seccion.php');

  class Precio {
    // attributes
    private $evento;
    private $seccion;
    private $precio;

    // getters and setters
    public function getEvento() { return $this->evento; }
    public function setEvento($value) { $this->evento = $value; }

    public function getSeccion() { return $this->seccion; }
    public function setSeccion($value) { $this->seccion = $value; }

    public function getPrecio() { return $this->precio; }
    public function setPrecio($value) { $this->precio = $value; }

    // contructor
    function __construct() {
      // empty object
      if (func_num_args() == 0) {
        $this->evento = new Evento();
        $this->seccion = new Seccion();
        $this->precio = 0.00;
      }
      // object with data from database
      if (func_num_args() == 2) {
        $evento = func_get_arg(0);
        $seccion = func_get_arg(1);

        $connection = SqlSrvConnection::getConnection();
        $query = 'select evento, seccion, precio from [admin].[precios]
                  where evento = ? and seccion = ?';

        $parameters = array($evento, $seccion);
        $found = sqlsrv_query($connection, $query, $parameters);

        if ($found) {
          while ($row = sqlsrv_fetch_array($found)) {
            $this->evento = new Evento($row['evento']);
            $this->seccion = new Seccion($row['seccion']);
            $this->precio = $row['precio'];
          }
        } else new RecordNotFoundException();
      }
    }

    // methods
    public function toJson() {
      return json_encode(array(
        'evento' => json_decode($this->evento->toJson()),
        'seccion' => json_decode($this->seccion->toJson()),
        'precio' => $this->precio
      ));
    }
  }
?>
