@extends('layouts.app')
@extends('layouts.header')
@extends('layouts.nav')
@extends('layouts.footer')

@section('title') Register an employee @endsection

@section('main')
<p class="h1 text-center">Update Event</p>

<form action="{{ route('eventUpdate', $event->id) }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="form-group col-md-4">
            <label for="name">Name</label>
            <input type="text" id="namr" class="form-control" name="name" placeholder="Name" value="{{ $event->name }}" required>
        </div>
        <div class="form-group col-md-4">
            <label for="date">Date</label>
            <input type="datetime-local" id="date" class="form-control" name="date" value="{{ $event->date }}" required>
        </div>
        <div class="form-group col-md-4">
            <label for="description">Description</label>
            <input type="text" id="description" class="form-control" name="description" placeholder="Description" value="{{ $event->description }}" required>
        </div>
    </div>

    <p class="text-center"><button type="submit" class="btn btn-primary">Update</button></p>
</form>


@endsection
