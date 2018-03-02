@extends('layouts.appSeats300')
@extends('layouts.header')
@extends('layouts.nav')
@extends('layouts.footer')
@extends('layouts.svgSeats300')


@section('title') Venta @endsection

@section('main')

<h1>Seats</h1>
<div id="seatsSubtotal"></div>
<div id="button" onload="fillSeats">
  <label for="exampleFormControlSelect2">Select your seats</label>
  <select multiple class="form-control" id="seats">

  </select>
</div>
<div id="subtotal1"></div>

@endsection
