<?php

require_once('butacaNodo.php');

# Lista circular
class Lista {
  // attributes
  private $first;
  private $lastest;

  // contructor
  function __construct() {
    // empty object
    if (func_num_args() == 0) {
      $this->first = NULL;
      $this->lastest = NULL;
    }
  }

  // methods
  public function add($node) {
    if ($this->isEmpty()) {
      // first node
      $this->first = $node;
      $this->lastest = $node;
      $this->first->setNext($this->lastest);
      $this->lastest->setPrevius($this->first);
    } else {
      $backup = $this->lastest;
      $this->lastest->setNext($node);
      $this->lastest = $node;
      $this->lastest->setPrevius($backup);
      $this->lastest->setNext($this->first);
      $this->first->setPrevius($this->lastest);
    }
  }

  private function search($idNode) {
    if (!$this->isEmpty()) {
      $node = $this->first;
      $found = FALSE;

      do {
        if ($node->getId() == $idNode)
          $found = TRUE;
        else
          $node = $node->getNext();
      } while(!$found && $node != $this->first);

      if ($found)
        return array("status" => 0,"node" => $node);
      else
        return array("status" => 1,"errorMessage" => "No encontrado. ");
    } else
      return array("status" => 2,"errorMessage" => "Sin butacas. ");
  }

  public function delete($idNode) {
    $result = $this->search($idNode);

    if($result["status"] == 0) {
      $object = $result["node"];

      // one element in the list
      if ($this->first === $this->lastest) {
        $this->first = NULL;
        $this->lastest = NULL;
        // two elements
      } elseif ($object->getNext() == $object->getPrevius()) {
          $survivedObject = $object->getNext();
          $survivedObject->setNext($survivedObject);
          $survivedObject->setPrevius($survivedObject);

          // changing first and lastest if apply
          if ($object == $this->first)
            $this->first = $object->getNext();

          if ($object == $this->lastest)
            $this->lastest = $object->getPrevius();
          // more than two elements
        } else {
          $prevObject = $object->getPrevius();
          $nextObject = $object->getNext();

          $prevObject->setNext($nextObject);
          $nextObject->setPrevius($prevObject);

          // changing first and lastest if apply
          if ($object == $this->first)
            $this->first = $object->getNext();

          if ($object == $this->lastest)
            $this->lastest = $object->getPrevius();
        }
        return json_encode(array(
          'status' => $result["status"],
          'message' => 'Se ha eliminado el elemento.'
        ));
    } else {
      return json_encode(array(
        'status' => $result["status"],
        'message' => $result["errorMessage"].' No se elimino algun elemento.'
      ));
    }
  }

  public function deleteAll() {
    $this->first = NULL;
    $this->lastest = NULL;
  }

  public function isEmpty() {
    if (is_null($this->first) && is_null($this->lastest))
      return TRUE;
    else
      return FALSE;
  }

/*  public function toJson($idNode) {
    $result = $this->search($idNode);

    if($result["status"] == 0) {
      $object = $result["node"];
      return json_encode(array(
        'status' => 0,
        'butaca' => json_decode($object->toJson())
      ));
    } else {
      return json_encode(array(
        'status' => $result["status"],
        'message' => $result["errorMessage"].' No se elimino algun elemento.'
      ));
    }
  }*/

  public function getAllJson() {
    if (!$this->isEmpty()) {
      $node = $this->first;
      $array = array();
      do {
        array_push($array, json_decode($node->toJson()));
        $node = $node->getNext();
      } while ($node !== $this->first);

      return json_encode(array('Seleccionados' => $array));
    } else
      return json_encode(array(
        'status' => 1,
        'errorMessage' => 'Lista vacia.'
      ));
  }
}

?>
