<?php

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
  public function __construct() {
    // empty object
    if (func_get_args() == 0) {
      $this->id = 0;
      $this->area = "";
      $this->nombre = "";
      $this->color = "";
    }
  }
}

?>
