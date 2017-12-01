<?php

require_once('sqlsrvconnection.php');
require_once('exceptions/recordnotfoundexception.php');

class Butaca {
  // attributes
  private $id;
  private $row;
  private $column;
  private $section;
  private $status;

  // getters and setters
  public function getId() { return $this->id; }
  public function setId($value) { $this->id = $value; }

  public function getRow() { return $this->row; }
  public function setRow($value) { $this->row = $value; }

  public function getColumn() { return $this->column; }
  public function setColumn($value) { $this->column = $value; }

  public function getSection() { return $this->section; }
  public function setSection($value) { $this->section = $value; }

  public function getStatus() { return $this->status; }
  public function setStatus($value) { $this->status = $value; }

  // constructor
  function __construct() {
    if(func_num_args() == 0) {
      $this->id = 0;
      $this->row = "";
      $this->column = 0;
      $this->section = 0;
      $this->status = "";
    }
    // object with data from database
    if (func_num_args() == 1) {
      $id = func_get_arg(0);

      $connection = SqlSrvConnection::getConnection();
      $query = 'select id, fila, columna, seccion, status from [catalogo].[butacas_ctg] where id = ?';

      $parameters = array($id);
      $found = sqlsrv_query($connection, $query, $parameters);

      if ($found) {
        while ($row = sqlsrv_fetch_array($found)) {
          $this->id = $row['id'];
          $this->row = $row['fila'];
          $this->column = $row['columna'];
          $this->section = $row['seccion'];
          $this->status = $row['status'];
        }
      }
    }
    // Object with data from arguments
    if (func_num_args() == 5) {
      $arguments = func_get_args();
      $this->id = $arguments[0];
      $this->row = $arguments[1];
      $this->column = $arguments[2];
      $this->section = $arguments[3];
      $this->status = $arguments[4];
    }
  }

  // methods
  public function toJson() {
    return json_encode(array(
      'id' => $this->id,
      'row' => $this->row,
      'column' => $this->column,
      'section' => $this->section,
      'status' => $this->status
    ));
  }

  public static function getAll($value) {
    $list = array();

    $connection = SqlSrvConnection::getConnection();
    $query = 'select id, fila, columna, seccion, status from [catalogo].[butacas_ctg] where seccion = ? order by fila desc';

    $parameters = array($value);
    $found = sqlsrv_query($connection, $query, $parameters);

    if ($found) {
      while ($row = sqlsrv_fetch_array($found)) {
        array_push($list, new Butaca(
          $row['id'],
          $row['fila'],
          $row['columna'],
          $row['seccion'],
          $row['status']
        )
      );
      }
    } else throw new RecordNotFoundException();

    sqlsrv_free_stmt($found);
    sqlsrv_close($connection);

    return $list;
  }

  public static function getAllJson($value) {
    $list = array();
    foreach (self::getAll($value) as $item) {
      array_push($list, json_decode($item->toJson()));
    }//foreach
    return json_encode(array('butacas' => $list));
  }
}

?>
