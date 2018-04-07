@extends('layouts.app')
@extends('layouts.header')
@extends('layouts.nav')
@extends('layouts.footer')

@section('title') Register an employee @endsection

@section('main')
<p class="h1 text-center">New Employee</p>

<form action="{{ route('employeeStore') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="form-group col-md-4">
            <label for="firstName">First Name</label>
            <input type="text" id="firstName" class="form-control" name="firstName" placeholder="First Name" onchange="generateUser()" required>
        </div>
        <div class="form-group col-md-4">
            <label for="lastName">Last Name</label>
            <input type="text" id="lastName" class="form-control" name="lastName" placeholder="Last Name" onchange="generateUser()" required>
        </div>
        <div class="form-group col-md-4">
            <label for="event">Profile</label>
            <select class="form-control" id="profile" name="profile">
                <option value="x">Select an Profile</option>
                @foreach ($profiles as $profile)
                    <option value="{{ $profile->id }}">{{ $profile->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="firstName">Email</label>
            <input type="text" id="email" class="form-control" name="email" required readonly>
        </div>
        <div class="form-group col-md-6">
            <label for="lastName">Password</label>
            <input type="password" id="password" class="form-control" name="password" placeholder="Password" required>
        </div>
    </div>

    <p class="text-center"><button type="submit" class="btn btn-primary">Register</button></p>
</form>


@endsection
