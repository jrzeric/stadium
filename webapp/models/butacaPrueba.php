<?php

require_once('butacaLista.php');
require_once('butacaNodo.php');

@session_id("lista");
@session_start();

if (isset($_SESSION['lista'])){
  try {
    // Creates or recover the node list
    if ($_SESSION['lista']) {
      $lista = $_SESSION['lista'];
      $json = json_decode($lista->getAllJson());
      $suma = 0;
      for ($i=0; $i < count($json->Seleccionados); $i++) {
        $id = $json->Seleccionados[$i]->id;
        $precio = $json->Seleccionados[$i]->price;
        ?>
        <div class="checkbox" >
          <input type="checkbox" id="<?php echo $id; ?>" value="<?php echo $precio; ?>">
          <label class="container"><?php echo 'Butaca: '.$id.'. Precio: '.$precio.'.'; ?></label>
        </div>
        <?php
        $suma += $precio;
        echo '<br>';
      }
      echo "<h3 class='sumaT'>Total: ".$suma."</h3>";
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



?>
