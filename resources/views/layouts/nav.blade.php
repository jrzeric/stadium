@section('nav')
<nav class="nav flex-column">
    <a class="nav-link active" href="/sales/">Sales</a>
    <!--<a class="nav-link active" href="/tickets/">Tickets</a>-->
    @if(Session::get('profile') == 1)
    <a class="nav-link" href="/employees/">Employees</a>
    <a class="nav-link" href="/events/">Events</a>
    <a class="nav-link" href="/prices/">Prices</a>
    @endif
    <!--<a class="nav-link disabled" href="#">Disabled</a>-->
    <a class="nav-link" href="/auth/logout/">LOGOUT</a>

</nav>
@endsection
