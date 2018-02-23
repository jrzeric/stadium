@extends('layouts.app')
@extends('layouts.header')
@extends('layouts.nav')
@extends('layouts.footer')

@section('title') Register an employee @endsection

@section('main')
<p class="h1 text-center">New Event</p>

<form action="{{ route('eventStore') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="form-group col-md-4">
            <label for="name">Name</label>
            <input type="text" id="namr" class="form-control" name="name" placeholder="Name" required>
        </div>
        <div class="form-group col-md-4">
            <label for="date">Date</label>
            <input type="datetime-local" id="date" class="form-control" name="date" required>
        </div>
        <div class="form-group col-md-4">
            <label for="description">Description</label>
            <input type="text" id="description" class="form-control" name="description" placeholder="Description" required>
        </div>
    </div>

    <p class="text-center"><button type="submit" class="btn btn-primary">Register</button></p>
</form>


@endsection
