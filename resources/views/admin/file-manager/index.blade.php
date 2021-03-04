@extends('layouts.app_admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 h-100">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe src="{{ route('unisharp.lfm.show') }}"
                            class="embed-responsive-item"
                            allowfullscreen
                    ></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection
