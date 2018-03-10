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
        <link rel="stylesheet" href="/css/seatchart.css">
        <script src="/js/seatchart.js"></script>
    </head>
    <body onload="init({{ $event }}, {{ $section }})">
        <header class="header">
            @yield('header')
        </header>
        <main class="main">
            <nav id="nav" class="nav" style="visibility: hidden">
                @yield('nav')
            </nav>
            <section id="section" class="section">
              <aside class="chartSection">
                  <svg> @yield('seatsChart') </svg>
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
