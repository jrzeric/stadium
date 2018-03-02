<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE');

require_once($_SERVER['DOCUMENT_ROOT'].'/stadium/webapp/models/butacaLista.php');
session_id("lista");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (isset($_GET['get']) || isset($_GET['getAll'])) {
    if (isset($_GET['get'])) {
      try {
        // Creates or recover the node list
        if (@$_SESSION['lista']) {
          $b = $_SESSION['lista'];
          echo $b->toJson(isset($_GET['get']));
        } else
          echo json_encode(array(
            'status' => 1,
            'errorMessage' => 'The list is empty.'
          ));
      } catch (Excepction $ex) {
        echo json_encode(array(
          'status' => 2,
          'errorMessage' => 'Something was wrong.'
        ));
      }
    }
    if (isset($_GET['getAll'])) { #session_unset();
      try {
        // Creates or recover the node list
        if (@$_SESSION['lista']) {
          $b = $_SESSION['lista'];
          echo $b->getAllJson();
        } else
          echo json_encode(array(
            'status' => 1,
            'errorMessage' => 'The list is empty.'
          ));
      } catch (Excepction $ex) {
        echo json_encode(array(
          'status' => 2,
          'errorMessage' => 'Something was wrong.'
        ));
      }
    }
  } else
    echo json_encode(array(
      'status' => 1,
      'errrorMessage' => "Missing parameters"
    ));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_GET['add']) || isset($_GET['price'])) {
    // adds a node to the list
    if (isset($_GET['add']) && isset($_GET['price'])) {
      try {
        // Creates or recover the node list
        if (!@$_SESSION['lista'])
          $b = new Lista();
        else
          $b = $_SESSION['lista'];
        // add a node to the list
        $b->add(new Nodo($_GET['add'], $_GET['price']));
        // saves de list to a session to future use
        $_SESSION['lista'] = $b;
        echo json_encode(array(
          'status' => 0,
          'message' => $_GET['add'].' con $'.$_GET['price'].' se ha insertado satisfactoriamente.'
        ));
      } catch (Excepction $ex) {
        echo json_encode(array(
          'status' => 1,
          'errorMessage' => 'Something was wrong.'
        ));
      }

    }
  } else
    echo json_encode(array(
      'status' => 1,
      'errrorMessage' => "Missing parameters"
    ));
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
  if (isset($_GET['delete']) || isset($_GET['deleteAll'])) {
    // deletes a specific seat from the list
    if (isset($_GET['delete'])) {
      try {
        // Creates or recover the node list
        if ($_SESSION['lista']) {
          $b = $_SESSION['lista'];
          $message = $b->delete($_GET['delete']);
          echo json_encode(json_decode($message));
        } else {
          session_unset();
          echo json_encode(array(
            'status' => 1,
            'errorMessage' => 'The list is empty.'
          ));
        }
      } catch (Excepction $ex) {
        echo json_encode(array(
          'status' => 2,
          'errorMessage' => 'Something was wrong.'
        ));
      }
    }
    // deletes all data from the list
    if (isset($_GET['deleteAll'])) {
      try {
        // Creates or recover the node list
        if ($_SESSION['lista']) {
          $b = $_SESSION['lista'];
          $message = $b->deleteAll();
          session_unset();
          echo json_encode(array(
            'status' => 0,
            'message' => 'Datos eliminados.'
          ));
        } else {
          session_unset();
          echo json_encode(array(
            'status' => 1,
            'errorMessage' => 'The list is empty.'
          ));
        }
      } catch (Excepction $ex) {
        echo json_encode(array(
          'status' => 2,
          'errorMessage' => 'Something was wrong.'
        ));
      }
    }
  } else
    echo json_encode(array(
      'status' => 3,
      'errrorMessage' => "Missing parameters"
    ));
}
session_write_close();
?>
