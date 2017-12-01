<?php
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET');

  require_once($_SERVER['DOCUMENT_ROOT'].'/stadium/webapp/models/butaca.php');

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['numero'])) {
      try {
        $v = new Venta($_GET['numero']);
        echo json_encode(array(
          'status' => 0,
          'venta' => json_decode($v->toJson());
        ));
      } catch(RecordNotFoundException $ex) {
        'status' => 1,
        'errorMessage' => $ex->get_message()
      }
    } else
      echo json_encode(array(
        'status' => 2,
        'errorMessage' => 'Missing parameters'
      ));
  }
?>
