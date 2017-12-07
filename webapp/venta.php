<!DOCTYPE html>
<html>
  <head>
    <?php include_once('models/venta.php'); ?>
    <?php require_once($_SERVER['DOCUMENT_ROOT'].'/stadium/webapp/models/butacaLista.php'); ?>
    <?php require_once($_SERVER['DOCUMENT_ROOT'].'/stadium/webapp/models/boleto.php'); ?>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
    session_id("evento");
    session_start();
    if (isset($_SESSION['evento'])) {
      $eventId = $_SESSION['evento'];
    }
    session_write_close();

    session_id("lista");
    session_start();
    if (isset($_SESSION['lista']))
      $lista = $_SESSION['lista'];
    session_write_close();


     if (empty($_POST)){
       // debe acceder desde el boton
       header('Location: stadium.php');
     } else {
       if ($_POST['event'] == 0) {
         if (isset($lista)) {
           try {
             // local variables
             $json = json_decode($lista->getAllJson());
             $numBoletos = count($json->Seleccionados);
             $ano = date("y");
             $mes = date("m");
             $dia = date("d");
             $hora = date("H");
             $minuto = date("i");
             $segundo = date("s");
             $rand = rand(101,999);

             // Venta
             $numBoleto = $ano.$mes.$dia.$hora.$minuto.$segundo.$rand;
             $numVenta = $numBoleto.$numBoletos;
             $evento = $eventId;
             $fecha = date("Y").'-'.$mes.'-'.$dia.' '.$hora.':'.$minuto.':'.$segundo;
             $vendedor = 100;

             Venta::add($numVenta, $evento, $fecha, $vendedor);

             for ($i=0; $i < count($json->Seleccionados); $i++) {
               $butaca = $json->Seleccionados[$i]->id;
               Boleto::add($numBoleto.($i+1), $numVenta, $butaca);
             }
           } catch (Exception $ex) { header('Location: cancelSell.php'); }


           // destroy data from list

           session_id("evento");
           session_start();
           if(isset($_SESSION['evento']))
             session_destroy();

           session_id("lista");
           session_start();
           if(isset($_SESSION['lista']))
             session_destroy();

           ?>
           <form id="toIndex" action="http://localhost/stadium/webapp/" method="post">
             <input type="hidden" name="reset" value="2">
           </form>
           <script type="text/javascript">
               document.getElementById('toIndex').submit();
           </script>
           <?php

         } else
           header('Location: stadium.php');
       }
       else
           // el evento no debe ser 0
           echo "No debe ser 0";
     }
       ?>
  </body>
</html>
