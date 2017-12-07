<!DOCTYPE html>
<html>
  <head>
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
    ?>
    <?php if(!empty($_POST)):?>
      <?php if(isset($_POST['event'])): ?>
        <?php if($_POST['event'] != 0): ?>
          <?php if($_POST['section'] == 23 || $_POST['section'] == 24): ?>
            <?php header('Location: seats15.php?event='.$_POST['event'].'&area='.$_POST['area'].'&section='.$_POST['section']); ?>
          <?php else: ?>
            <?php header('Location: seats300.php?event='.$_POST['event'].'&area='.$_POST['area'].'&section='.$_POST['section']); ?>
          <?php endif; ?>
        <?php endif; ?>
      <?php endif; ?>
      <?php if(isset($_POST['reset'])): ?>
        <?php if($_POST['reset'] == 2): ?>
          <script type="text/javascript">window.alert('Venta completada!')</script>
        <?php endif; ?>
      <?php endif; ?>
    <?php endif; ?>
    <meta charset="utf-8">
    <title>Stadium</title>
    <!-- style sheets -->
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="inc/css/menu.css">
    <link rel="stylesheet" href="inc/js/menu.css">
		<link rel="stylesheet" href="css/stadiumchart.css">
		<link rel="stylesheet" href="css/popup/popup.css">
    <!-- scripts -->
    <script src="js/popup/popupclass.js"></script>
    <script src="js/popup/globals.js"></script>
    <script src="js/popup/index.js"></script>
		<script src="js/popup/popup.js"></script>
    <script src="js/stadiumchart.js"></script>
  </head>
  <body <?php if(!isset($eventId)): ?> onload="getEventos()" <?php endif; ?> >
		<header>

			<nav id="menu">
				<?php include_once('inc/menu.php'); ?>
			</nav>
		</header>
		<main>
			<section id="stadium">
	      <svg>
	        <?php include_once('inc/stadium.html'); ?>
	      </svg>
			</section>
			<aside id="total" onload="getList()">
        <?php if(!isset($eventId)): ?>
          <!-- Muestra los eventos a elegir si no ha seleccionado alguno anteriormente -->
          <select id="eventos" class="soflow">
            <option value="0">Selecciona un evento</option>
          </select>
        <?php else: ?>
          <!-- Muestra solo el evento seleccionado anteriormente en el combobox -->
          <select id="eventos" class="soflow">
            <option value="<?php echo $eventId; ?>" selected>Evento: <?php echo $eventId; ?></option>
          </select>
          <!-- Muestra la opcion de cancelar venta -->
          <form action="cancelSell.php" method="post">
            <input type="submit" value="Cancelar compra" class="cancelar">
          </form>
        <?php endif; ?>


        <?php if(isset($lista)): ?>
          <form action="venta.php" method="post">
            <input type="hidden" name="event" value='0'>
            <input type="submit" value="Vender" class="vender">
          </form>
        <?php endif; ?>

        <?php if(isset($eventId)): ?>
          <label id="prueba" hidden><?php echo $eventId; ?></label>
        <?php else: ?>
          <label id="prueba" hidden>0</label>
        <?php endif; ?>


        </form>
				<h1>Butacas seleccionadas</h1><br>
        <?php require_once('models/butacaPrueba.php'); ?>
        <div id='seatsSubtotal'></div>
			</aside>
		</main>
  </body>
	<footer>
		<?php include_once('inc/footer.php'); ?>
	</footer>
</html>
<?php session_write_close(); ?>
