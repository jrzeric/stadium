@extends('layouts.app')
@extends('layouts.header')
@extends('layouts.nav')
@extends('layouts.footer')

@section('title') Tickets @endsection

@section('main')
<p class="h1 text-center">Tickets</p>

<div class="row">
    <div class="form-group col-md-4">
        <label for="event">Event Name</label>
        <select class="form-control" id="event" name="event" onchange="getTickets()">
            <option value="x">Select an Event</option>
            @foreach ($events as $event)
                <option value="{{ $event->id }}">{{ $event->name }}</option>
            @endforeach
        </select>
        <!--<input type="text" id="eventName" class="form-control" name="eventName" placeholder="Event Name" required>-->
    </div>
</div>


@endsection
