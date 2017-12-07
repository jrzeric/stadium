<?php
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET');

  require_once($_SERVER['DOCUMENT_ROOT'].'/stadium/webapp/models/exceptions/recordnotfoundexception.php');
  require_once($_SERVER['DOCUMENT_ROOT'].'/stadium/webapp/models/precio.php');

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['evento']) && isset($_GET['seccion'])) {
      try {
        $p = new Precio($_GET['evento'], $_GET['seccion']);
        echo json_encode(array(
          'status' => 0,
          'precio' => json_decode($p->toJson())
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
  }
?>
