@extends('front-v1.user.dashboard.dashboard')

@section('bread-crumb')
    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('dashboard') }}
@endsection

@section('dashboard-content')
    <h4>داشبورد {{ \Illuminate\Support\Facades\Auth::user()->full_name }} در {{ config('app.name') }}</h4>
    <div class="border p-4 m-4 rounded text-center font-weight-bolder font-16">
        با کلیک روی گزینه های داشبورد، حساب {{ config('app.name') }} خود را مدیریت کنید.
    </div>
    <div class="row">
            <div class="col-md-6 mb-2 mb-md-0">
                <a href="{{ route('home') }}"
                class="btn btn-light w-100 font-16 border p-4 font-weight-bolder"
                >
                    <i class="fa fa-shoe-prints fa-rotate-270 fa-2x align-middle"></i>
                    ادامه خرید
                </a>
            </div>
        <div class="col-md-6">
            <a href="{{ route('cart.index') }}"
               class="btn btn-light w-100 font-16 border p-4 font-weight-bolder"
            >
                <i class="fa fa-shopping-cart fa-2x align-middle"></i>
                مشاهده سبد خرید
            </a>
        </div>
    </div>
@endsection
