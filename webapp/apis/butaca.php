<?php
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET');

  require_once($_SERVER['DOCUMENT_ROOT'].'/stadium/webapp/models/butaca.php');

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['section'])) {
      echo Butaca::getAllJson($_GET['section']);
    } else
      echo json_encode(array(
        'status' => 1,
        'errorMessage' => 'Missing parameters'
      ));
  }
?>
