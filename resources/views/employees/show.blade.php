@extends('layouts.app')
@extends('layouts.header')
@extends('layouts.nav')
@extends('layouts.footer')

@section('title') Register an employee @endsection

@section('main')
<p class="h1 text-center">Update Employee</p>

<form action="{{ route('employeeUpdate', $employee->id) }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="form-group col-md-6">
            <label for="firstName">First Name</label>
            <input type="text" id="firstName" class="form-control" name="firstName" placeholder="First Name" value="{{ $employee->firstName }}" required>
        </div>
        <div class="form-group col-md-6">
            <label for="lastName">Last Name</label>
            <input type="text" id="lastName" class="form-control" name="lastName" placeholder="Last Name" value="{{ $employee->lastname }}" required>
        </div>
    </div>

    <p class="text-center"><button type="submit" class="btn btn-primary">Update</button></p>
</form>


@endsection
