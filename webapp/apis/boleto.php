<?php
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET');

  require_once($_SERVER['DOCUMENT_ROOT'].'/stadium/webapp/models/boleto.php');

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['folio'])) {
      try {
        $b = new Boleto($_GET['folio']);
        echo json_encode(array(
          'status' => 0,
          'boleto' => json_decode($b->toJson())
        ));
      } catch(RecordNotFoundException $ex) {
        echo json_encode(array(
          'status' => 1,
          'errorMessage' => $ex->get_message()
        ));
      }
    } else {
      if (isset($_GET['evento']) && isset($_GET['butaca'])) {
        try {
          echo Boleto::seatsBougthJson($_GET['evento'], $_GET['butaca']);
        } catch (Exception $e) {
          echo json_encode(array(
            'status' => 2,
            'message' => 'Butaca no vendida'
          ));
        }

      } else
        echo json_encode(array(
          'status' => 3,
          'errorMessage' => 'Missing parameters'
        ));
    }
  }
?>
