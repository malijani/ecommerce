@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header p-5 text-center font-20">تایید حقیقی بودن ایمیل</div>

                <div class="card-body font-18">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            یه لینک به ایمیل شما ارسال شده.
                        </div>
                    @endif

                    قبل از هرگونه اقدامی جهت سفارش محصول لطفاً ایمیل خود را تایید کنید تا برای پشتیبانی ارتباط بهتری با شما داشته باشیم!
                    اگر ایمیل تایید را دریافت نکردید،
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline font-18">اینجا کلیک کنید تا دوباره ارسال بشه</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
