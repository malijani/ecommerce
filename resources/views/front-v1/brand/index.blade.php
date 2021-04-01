@extends('layouts.app')


@section('content')

    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('brands') }}

    <div class="container my-3 bg-white">

        <div class="row">
            @include('front-v1.partials.brands', ['brands'=>$brands])
        </div>{{--row--}}

        <div class="row justify-content-center my-3">
            {{ $brands->links() }}
        </div>

    </div>{{--container--}}
@endsection
