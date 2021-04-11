@extends('front-v1.user.dashboard.dashboard')

@section('bread-crumb')
    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('dashboard.addresses') }}
@endsection
@section('dashboard-content')
    @include('front-v1.partials.address')
@endsection
