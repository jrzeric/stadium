@extends('layouts.app')
@extends('layouts.header')
@extends('layouts.nav')
@extends('layouts.footer')

@section('title') Register a price @endsection

@section('main')
<p class="h1 text-center">New Price</p>

<form action="{{ route('priceStore') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="form-group col-md-4">
            <label for="event">Event Name</label>
            <select class="form-control" id="event" name="event">
                <option value="x">Select an Event</option>
                @foreach ($events as $event)
                    <option value="{{ $event->id }}">{{ $event->name }}</option>
                @endforeach
            </select>
            <!--<input type="text" id="eventName" class="form-control" name="eventName" placeholder="Event Name" required>-->
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label>Section</label>
            <input type="text" class="form-control" name="top" placeholder="Top" disabled>
        </div>
        <div class="form-group col-md-6">
            <label>Price</label>
            <input type="number" min="1" step="any" class="form-control" name="priceTop" placeholder="Price" required>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <input type="text" class="form-control" name="middle" placeholder="Middle" disabled>
        </div>
        <div class="form-group col-md-6">
            <input type="number" min="1" step="any" class="form-control" name="priceMiddle" placeholder="Price" required>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <input type="text" class="form-control" name="bottom" placeholder="Bottom" disabled>
        </div>
        <div class="form-group col-md-6">
            <input type="number" min="1" step="any" class="form-control" name="priceBottom" placeholder="Price" required>
        </div>
    </div>
    <p class="text-center"><button type="submit" class="btn btn-primary">Register</button></p>
</form>


@endsection
