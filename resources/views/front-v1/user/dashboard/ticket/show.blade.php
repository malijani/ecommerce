@extends('front-v1.user.dashboard.dashboard')

@section('bread-crumb')
    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('dashboard.tickets.show', $ticket->show) }}
@endsection
@section('dashboard-content')

@endsection
