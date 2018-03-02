<!DOCTYPE html>
<html>
    <head>
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
              <aside class="chartSection">
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
