@extends('layouts.appSeats300')
@extends('layouts.header')
@extends('layouts.nav')
@extends('layouts.footer')
@extends('layouts.svgSeats300')


@section('title') Venta @endsection

@section('main')

<div id="salesTitle">
  <label id="countTickets"></label>
  <label id="title"></label>
</div>
<label id="js" name="js" hidden></label>
<div class="salesButton"><a href="{{ route('sales.index') }}" class="btn btn-success">Checkout</a></div>
<div id="tickets" class="tickets"></div>
<div id="total"></div>

@endsection
