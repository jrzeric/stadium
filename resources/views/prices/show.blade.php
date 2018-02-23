@extends('layouts.app')
@extends('layouts.header')
@extends('layouts.nav')
@extends('layouts.footer')

@section('title') Edit prices @endsection

@section('main')
<p class="h1 text-center">Edit prices</p>

<form action="{{ route('priceUpdate', $price->section) }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="form-group col-md-4">
            <label for="event">Event Name</label>
            <select class="form-control" id="event" name="event">
                <option value="{{ $price->eventId }}">{{ $price->event }}</option>
            </select>
            <!--<input type="text" id="eventName" class="form-control" name="eventName" placeholder="Event Name" required>-->
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label>Section</label>
            <input type="text" class="form-control" name="section" value="{{ $price->section }}" disabled>
        </div>
        <div class="form-group col-md-6">
            <label>Price</label>
            <input type="number" min="1" step="any" class="form-control" name="price" placeholder="Price" value="{{ $price->price }}" required>
        </div>
    </div>

    <p class="text-center"><button type="submit" class="btn btn-primary">Update</button></p>
</form>


@endsection
