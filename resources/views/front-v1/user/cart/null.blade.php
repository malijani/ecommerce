@extends('layouts.app')


@section('content')

    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('cart') }}

    <div class="container my-3 rounded">
        <div class="row bg-white">

            <div class="col-12 col-lg-12 py-4 text-center align-middle">{{--PRODUCTS--}}
                <i class="fa fa-info-circle fa-2x"></i>
                <h4 class="d-inline mx-1">سبد خرید شما خالیست.</h4>

                <div class="my-3">
                <a href="{{ route('product.index')  }}" class="btn btn-lg  btn-outline-info">
                    ادامه خرید
                </a>
                </div>

            </div>{{--./PRODUCTS--}}
        </div>{{--row--}}
    </div>{{--container--}}
@endsection

@section('page-scripts')
    <script>
        $(document).ready(function () {
            // TODO : MAKE IT AJAX!!
        });
    </script>
@endsection

