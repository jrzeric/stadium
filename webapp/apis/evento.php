<?php
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET');

  require_once($_SERVER['DOCUMENT_ROOT'].'/stadium/webapp/models/evento.php');

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
      try {
        $b = new Evento($_GET['id']);
        echo json_encode(array(
          'status' => 0,
          'butaca' => json_decode($b->toJson())
        ));
      } catch(RecordNotFoundException $ex) {
        echo json_encode(array(
					'status' => 1,
					'errorMessage' => $ex->get_message()
				));
      }
    } else
      echo json_encode(array(
        'status' => 2,
        'errorMessage' => 'Missing parameters'
      ));
?>
