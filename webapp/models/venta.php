<?php

require_once('exceptions/recordnotfoundexception.php');
require_once('sqlsrvconnection.php');
require_once('evento.php');
require_once('employee.php');

class Venta {
  // attributes
  private $numero;
  private $evento;
  private $fechaHora;
  private $vendedor;

  // getters and setters
  public function getNumero() { return $this->numero; }
  public function setNumero($value) { $this->numero = $value; }

  public function getEvento() { return $this->evento; }
  public function setEvento($value) { $this->evento = $value; }

  public function getFechaHora() { return $this->fechaHora; }
  public function setFechaHora($value) { $this->fechaHora = $value; }

  public function getVendedor() { return $this->vendedor; }
  public function setVendedor($value) { $this->vendedor = $value; }

  // constructors
  function __construct() {
    // empty object
    if (func_num_args() == 0) {
      $this->numero = "";
      $this->evento = new Evento();
      $this->fechaHora = "";
      $this->vendedor = new Employee();
    }
    // object with data from database
    if (func_num_args() == 1) {
      $numero = func_get_arg(0);
      echo $numero;
      $connection = SqlSrvConnection::getConnection();
      $query = 'select numero, evento, fechaHora, vendedor from [ventas].[ventas] where numero = ?';

      $parameters = array($numero);
      $found = sqlsrv_query($connection, $query, $parameters);

      if ($found) {
        while ($row = sqlsrv_fetch_array($found)) {
          $this->numero = $row['numero'];
          $this->evento = new Evento($row['evento']);
          $this->fechaHora = $row['fechaHora'];
          $this->vendedor = new Employee($row['vendedor']);
        }
      }
    }
    // object with data from arguments
    if (func_num_args() == 4) {
      $arguments = func_get_args();

      $this->numero = $arguments[0];
      $this->evento = new Evento($arguments[1]);
      $this->fechaHora = $arguments[2];
      $this->vendedor = new Employee($arguments[3]);
    }
  }

  // methods
  public function toJson() {
    return json_encode(array(
      'numero' => $this->numero,
      'evento' => json_decode($this->evento->toJson()),
      'fechaHora' => $this->fechaHora,
      'vendedor' => json_decode($this->vendedor->toJson())
    ));
  }

}

?>
