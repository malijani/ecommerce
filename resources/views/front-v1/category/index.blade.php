@extends('layouts.app')


@section('content')

{{--        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('category') }}--}}

    <div class="container my-3">

        <div class="row">
{{--            @foreach($products as $product)--}}

{{--            @endforeach--}}

        </div>{{--row--}}
        <div class="row my-3">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-center">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>{{--container--}}

@endsection
