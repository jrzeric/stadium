@extends('layouts.appStadium')
@extends('layouts.header')
@extends('layouts.nav')
@extends('layouts.footer')
@extends('layouts.svgStadium')


@section('title') Venta @endsection

@section('main')

@if (session('tickets'))
    <div class="alert alert-success">
        {{ session('tickets') }}
    </div>
@endif

<div id="salesSelect">
  <h3>Event</h3>
  <select class="form-control" id="eventos" name="eventos">
      @foreach ($events as $event)
          <option value="{{ $event->id }}">{{ $event->name }}</option>
      @endforeach
  </select>
</div>
@endsection
