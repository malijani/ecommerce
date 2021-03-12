@extends('layouts.app')


@section('content')

        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('products') }}

        <div class="container my-3 rounded">
            <div class="row px-0 bg-white py-3">
                <div class="col-12">
                    @include('front-v1.partials.products', ['products'=>$products, 'carousel'=>false])
                </div>
            </div>{{--row--}}

            <div class="row my-3">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-center">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
@endsection
