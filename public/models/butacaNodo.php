<?php

class Nodo {
  // attributes
  private $id;
  private $price;
  private $next;
  private $previus;

  // getters and setters
  public function getId() { return $this->id; }

  public function getPrice() { return $this->price; }

  public function getNext() { return $this->next; }
  public function setNext($next) { $this->next = $next; }

  public function getPrevius() { return $this->previus; }
  public function setPrevius($previus) { $this->previus = $previus; }

  // constructor
  function __construct() {
    // empty object
    if (func_num_args() == 0) {
      $this->id = 0;
      $this->price = 0.00;
      $this->next = NULL;
    }
    // object data from arguments
    if (func_num_args() == 2) {
      $this->id = func_get_arg(0);
      $this->price = func_get_arg(1);
    }
  }

  // methods
  public function toJson() {
    return json_encode(array(
      'id' => $this->id,
      'price' => $this->price
    ));
  }
}

?>
