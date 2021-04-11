@extends('layouts.app')


@section('content')

    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('cart') }}

    <div class="container my-3 rounded">
        <div class="row bg-white">

            <div class="col-12 col-lg-12 py-4 text-center align-middle">{{--PRODUCTS--}}
                <i class="fa fa-info-circle fa-2x"></i>
                <h4 class="d-inline mx-1">سبد خرید شما خالیست.</h4>

                <div class="my-3">
                    <a href="{{ route('home') }}"
                       class="btn btn-light w-50 font-16 border p-4 font-weight-bolder"
                    >
                        <i class="fa fa-shoe-prints fa-rotate-270 fa-2x align-middle"></i>
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

