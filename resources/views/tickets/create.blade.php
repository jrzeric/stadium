@extends('layouts.app')
@extends('layouts.header')
@extends('layouts.nav')
@extends('layouts.footer')

@section('title') Tickets @endsection

@section('main')
<p class="h1 text-center">Select a Event</p>

<form action="{{ route('employeeStore') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="form-group col-md-6">
            <label for="firstName">First Name</label>
            <input type="text" id="firstName" class="form-control" name="firstName" placeholder="First Name" required>
        </div>
        <div class="form-group col-md-6">
            <label for="lastName">Last Name</label>
            <input type="text" id="lastName" class="form-control" name="lastName" placeholder="Last Name" required>
        </div>
    </div>

    <p class="text-center"><button type="submit" class="btn btn-primary">Register</button></p>
</form>


@endsection
