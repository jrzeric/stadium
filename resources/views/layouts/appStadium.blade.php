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
        <title>Seat Organizer - @yield('title')</title>
        <!--bootstrap files-->
        <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
        <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
        <!--jquery-->
        <script src="/assets/jquery/jquery-3.3.1.min.js"></script>
        <!--user files-->
        <link rel="stylesheet" href="/css/usr.css">
        <link rel="stylesheet" href="/css/popup.css">
        <script src="/js/usr.js"></script>
        <!--stadium-->
        <script src="js/popup/popupclass.js"></script>
        <script src="js/popup/globals.js"></script>
        <script src="js/popup/index.js"></script>
    		<script src="js/popup/popup.js"></script>
    		<script src="js/others/index.js"></script>
    		<script src="js/others/seatchart.js"></script>
    		<script src="js/others/stadiumchart.js"></script>


    		<script src="js/popup.js"></script>
        


    </head>
    <body>
        <header class="header">
            @yield('header')
        </header>
        <main class="main">
            <nav id="nav" class="nav" style="visibility: hidden">
                @yield('nav')
            </nav>
            <section id="section" class="section">
              <?php if(isset($eventId)): ?>
                <label id="prueba" hidden><?php echo $eventId; ?></label>
              <?php else: ?>
                <label id="prueba" hidden>0</label>
              <?php endif; ?>
              <aside class="stadiumChart">
                  <svg> @yield('stadiumChart') </svg>
              </aside>
              <aside class="sale">
                  @yield('main')
              </aside>
            </section>

        </main>
        <!-- disabled footer
            <footer class="footer">
                @yield('footer')
            </footer>
        -->
    </body>
</html>
