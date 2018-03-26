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
        <script src="/js/popup/popupclass.js"></script>
        <script src="/js/popup/globals.js"></script>
        <script src="/js/popup/index.js"></script>
    		<script src="/js/popup/popup.js"></script>
    		<script src="/js/seatchart.js"></script>
    		<script src="/js/stadiumchart.js"></script>
    </head>
    <body onload="salesSelect()">
        <header class="header">
            @yield('header')
        </header>
        <main class="main">
            @if (session('status'))
                <div class="alert alert-success" onload="flushSession()">
                    {{ session('status') }}
                </div>
            @endif
            <nav id="nav" class="nav" style="visibility: hidden">
                @yield('nav')
            </nav>
            <section id="section" class="section">
              <aside class="chartSection">
                  <svg> @yield('stadiumChart') </svg>
              </aside>
              <aside id="sale" class="sale" style="display: block;">
                  @yield('main')
              </aside>
              <aside id="saleTicket" class="sale" style="display: none;">
                  <div id="salesTitle">
                      <label id="countTickets"></label>
                      <label id="title"></label>
                  </div>
                  <form action="{{ route('sales.store') }}" method="post">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input id="js" name="js" hidden>
                      <div class="salesButton text-center"><button type="submit" class="btn btn-primary" onclick="flushSession()">Sell</button></div>
                  </form>
                      <div class="salesButton text-center"><button type="submit" class="btn btn-danger" onclick="flushSession()">Canel</button></div>

                  <div id="tickets" class="tickets"></div>
                  <div id="total"></div>
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
