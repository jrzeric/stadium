<?php

require_once('sqlsrvconnection.php');
require_once('exceptions/recordnotfoundexception.php');
require_once('area.php');

class Seccion {
  // attributes
  private $id;
  private $area;
  private $nombre;
  private $color;

  // getters and setters
  public function getId() { return $this->id; }
  public function setId($value) { $this->id = $value; }

  public function getArea() { return $this->area; }
  public function setArea($value) { $this->area = $value; }

  public function getNombre() { return $this->nombre; }
  public function setNombre($value) { $this->nombre = $value; }

  public function getColor() { return $this->color; }
  public function setColor($value) { $this->color = $value; }

  // constructors
  function __construct() {
    // empty object
    if (func_get_args() == 0) {
      $this->id = 0;
      $this->area = new Area();
      $this->nombre = "";
      $this->color = "";
    }
    // object with data from database
    if (func_num_args() == 1)  {
      $id = func_get_arg(0);

      $connection = SqlSrvConnection::getConnection();
      $query = 'select id, area, nombre, color from [catalogo].[secciones_ctg] where id = ?';

      $parameters = array($id);
      $found = sqlsrv_query($connection, $query, $parameters);

      if ($found) {
        while ($row = sqlsrv_fetch_array($found)) {
          $this->id = $row['id'];
          $this->area = new Area($row['area']);
          $this->nombre = $row['nombre'];
          $this->color = $row['color'];
        }
      } else new RecordNotFoundException();
    }
    // object with data from arguments
    if (func_num_args() == 4) {
      $arguments = func_get_args();

      $this->id = $arguments[0];
      $this->area = new Area($arguments[1]);
      $this->nombre = $arguments[2];
      $this->color = $arguments[3];
    }
  }

  // methods
  public function toJson() {
    return json_encode(array(
      'id' => $this->id,
      'area' => json_decode($this->area->toJson()),
      'nombre' => $this->nombre,
      'color' => $this->color
    ));
  }
}

?>
