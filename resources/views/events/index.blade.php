@extends('layouts.app')
@extends('layouts.header')
@extends('layouts.nav')
@extends('layouts.footer')

@section('title') Prueba @endsection

@section('main')
<p class="h1 text-center">Events</p>
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<p class="h1 text-right"><a href=" {{ route('eventCreate') }}" class="btn btn-success">New event</a></p>


<!--table-->
<table class="table table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Date</th>
            <th>Description</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($events as $i => $event)
            <tr>
                <td class="align-middle">{{ $i + 1 }}</td>
                <td class="align-middle">{{ $event->name }}</td>
                <td class="align-middle">{{ $event->date }}</td>
                <td class="align-middle">{{ $event->description }}</td>
                <td class="text-center">
                    <a href="{{ route('eventEdit', $event->id) }}" class="btn btn-primary"><img src="/images/octicons/svg/pencil.svg" alt="" width="20px"></a>
                    <a href="" class="btn btn-danger"><img src="/images/octicons/svg/trashcan.svg" alt="" width="20px"></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>


@endsection
