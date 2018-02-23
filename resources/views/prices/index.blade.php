@extends('layouts.app')
@extends('layouts.header')
@extends('layouts.nav')
@extends('layouts.footer')

@section('title') Prueba @endsection

@section('main')
<p class="h1 text-center">Prices</p>
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<p class="h1 text-right"><a href="{{ route('priceCreate') }}" class="btn btn-success">New Price</a></p>


<!--table-->
<table class="table table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Event Name</th>
            <th>Section **</th>
            <th>Price</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($prices as $i => $price)
            <tr>
                <td class="align-middle">{{ $i + 1 }}</td>
                <td class="align-middle">{{ $price->event }}</td>
                <td class="align-middle">{{ $price->section }}</td>
                <td class="align-middle">{{ $price->price }}</td>
                <td class="text-center">
                    <a href="{{ route('priceEdit', $price->section) }}" class="btn btn-primary"><img src="/images/octicons/svg/pencil.svg" alt="" width="20px"></a>
                    <a href="{{ route('priceDestroy', $price->section) }}" class="btn btn-danger"><img src="/images/octicons/svg/trashcan.svg" alt="" width="20px"></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>


@endsection
