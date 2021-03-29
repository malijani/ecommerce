@extends('layouts.app')


@section('content')

        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('categories') }}

    <div class="container my-3">

        <div class="row">

            <div class="container">
                <div class="row">
                    @include('front-v1.partials.categories', ['categories'=>$categories])
                </div>
            </div>
        </div>{{--row--}}

    </div>{{--container--}}
@endsection
