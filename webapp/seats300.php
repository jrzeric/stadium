<!DOCTYPE html>
<html>
  <head>
    <?php session_id("evento"); session_start(); ?>
    <meta charset="utf-8">
    <title>Stadium</title>
    <!-- style sheets -->
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/seatchart.css">
    <!-- scripts -->
    <script src="js/seatchart.js"></script>
    <?php if(isset($_GET['event'])) $event = $_GET['event']; ?>
    <?php if(isset($_GET['area'])) $area = $_GET['area']; ?>
    <?php if(isset($_GET['section'])) $section = $_GET['section']; ?>
    <?php $_SESSION['evento'] = $event; ?>
  </head>
  <body onload="init(<?php echo $event; ?>, <?php echo $section; ?>)">
    <header>

			<nav id="menu">
				<?php include_once('inc/menu.php'); ?>
			</nav>
		</header>
    <main>
      <section id="seats">
	      <svg>
	        <?php include_once('inc/seats.html'); ?>
	      </svg>
			</section>
    </main>
    <aside id="subtotal">
      <h1>Butacas seleccionadas</h1>
      <div id="seatsSubtotal"></div>
      <div id="button">
        <form action="../webapp/" method="post">
          <input type="hidden" name="eventId" value=<?php echo $event; ?>>
          <input type="submit" value="Volver" class="volver">
        </form>
      </div>
      <div id="subtotal1"></div>
    </aside>
  </main>
</body>
<footer>
  <?php include_once('inc/footer.php'); ?>
</footer>
</html>
<?php session_write_close(); ?>
