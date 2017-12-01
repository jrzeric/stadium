<?php

require_once('exceptions/recordnotfoundexception.php');
require_once('sqlsrvconnection.php');
require_once('venta.php');
require_once('butaca.php');


class Boleto {
  // attributes
  private $folio;
  private $venta;
  private $butaca;

  // getters and setters
  public function getFolio() { return $this->folio; }
  public function setFolio($value) { $this->folio = $value; }

  public function getVenta() { return $this->venta; }
  public function setVenta($value) { $this->venta = $value; }

  public function getButaca() { return $this->butaca; }
  public function setButaca($value) { $this->butaca = $value; }

  // constructor
  function __construct() {
    // empty object
    if (func_num_args() == 0) {
      $this->folio = 0;
      $this->venta = new Venta();
      $this->butaca = new Butaca();
    }
    // object with data from database
    if (func_num_args() == 1) {
      $folio = func_get_args(0);

      $connection = SqlSrvConnection::getConnection();
      $query = 'select folio, venta, butaca from [ventas].[boletos] where folio = ?';

      $parameters = array($folio);
      $found = sqlsrv_query($connection, $query, $parameters);

      if ($found) {
        while ($row = sqlsrv_fetch_array($found)) {
          $this->folio = $row['folio'];
          $this->venta = new Venta($row['venta']);
          $this->butaca = new Butaca($row['butaca']);
        }
      }

    }
    // object with data from arguments
    if (func_num_args() == 3) {
      $arguments = func_get_args();

      $this->folio = $arguments[0];
      $this->venta = new Venta($arguments[1]);
      $this->butaca = new Butaca($arguemnts[2]);
    }
  }

  // methods
  public function toJson() {
    return json_encode(array(
      'folio' => $this->folio,
      'venta' => json_decode($this->venta->toJson()),
      'butaca' => json_decode($this->butaca->toJson())
    ));
  }

  public static function seatsBougth($evento, $butaca) {
    // devolver booleano por cada butacas
    // o devolver un arreglo de todos los/ vendidos.
    $connection = SqlSrvConnection::getConnection();
    $query = 'select b.folio, b.venta, b.butaca from [ventas].[boletos] b inner join [ventas].[ventas] v on b.venta = v.numero where v.evento = ? and b.butaca = ?';

    $parameters = array($evento, $butaca);
    $found = sqlsrv_query($connection, $query, $parameters);

    if ($found) {
      while ($row = sqlsrv_fetch_array($found)) {

        $array = array(
          'folio' => $row['folio'],
          'venta' => $row['venta'],
          'butaca' => $row['butaca']
        );
        /*$this->folio = $row['folio'];
        $this->venta = new Venta($row['venta']);
        $this->butaca = new Butaca($row['butaca']);*/
      }
    }

    return $array;
  }

  public static function seatsBougthJson($evento, $idButaca) {
    $array = self::seatsBougth($evento, $idButaca);

    return json_encode(array(
      'folio' => $array['folio'],
      'venta' => $array['venta'], //json_decode($this->venta->toJson()),
      'butaca' => $array['butaca'] //json_decode($this->butaca->toJson())
    ));
  }
}

?>
