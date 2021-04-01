@extends('layouts.app')


@section('content')

    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('brands.brand', $brand) }}


    <div class="container my-3 rounded">
        <div class="row px-0 bg-white py-3">
            <div class="col-12 p-4 mb-4  text-center">
                <h1>{{ $brand->title }}</h1>
                <img class="img-fluid rounded"
                     src="{{ asset($brand->pic ?? 'images/fallback/brand.png') }}"
                     alt="{{ $brand->pic_alt ?? $brand->title_en }}"
                >

            </div>
            <div class="col-12">
                @include('front-v1.partials.products', ['products'=>$products, 'carousel'=>false])
            </div>

        </div>{{--row--}}

    </div>{{--container--}}
@endsection


