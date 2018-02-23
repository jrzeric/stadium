@extends('layouts.app')
@extends('layouts.header')
@extends('layouts.nav')
@extends('layouts.footer')

@section('title') Prueba @endsection

@section('main')
<p class="h1 text-center">Employees</p>
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<p class="h1 text-right"><a href="{{ route('employeeCreate') }}" class="btn btn-success">New employee</a></p>


<!--table-->
<table class="table table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($employees as $i => $employee)
            <tr>
                <td class="align-middle">{{ $i + 1 }}</td>
                <td class="align-middle">{{ $employee->firstName }}</td>
                <td class="align-middle">{{ $employee->lastname }}</td>
                <td class="text-center">
                    <a href="{{ route('employeeEdit', $employee->id) }}" class="btn btn-primary"><img src="/images/octicons/svg/pencil.svg" alt="" width="20px"></a>
                    <a href="{{ route('employeeDestroy', $employee->id) }}" class="btn btn-danger"><img src="/images/octicons/svg/trashcan.svg" alt="" width="20px"></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>


@endsection
