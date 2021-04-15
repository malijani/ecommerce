@extends('layouts.app')


@section('content')

    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('page.show', $page) }}

    <div class="container my-3 rounded">
        <div class="row bg-white">
            <div class="col-12 ">
                <div class="py-4 text-center">
                    <h1 class="font-24">{{$page->menu_title}}</h1>
                </div>
            </div>


            <div class="col-12 p-4">
                {!! $page->content !!}
            </div>

        </div>{{--row--}}
    </div>{{--container--}}
@endsection
