@extends('layouts.app')


@section('content')

    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('page') }}

    <div class="container my-3 bg-white">

        <div class="row py-3">

            @foreach($pages as $page)
                <div class="col-md-12 col-lg-4 mt-3 text-center text-md-right">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $page->menu_title }}</h5>
                            <p class="card-text">{{ strip_tags($page->content_short) }}</p>
                            <a href="{{ route('page.show', $page->title_en) }}" class="card-link">مشاهده</a>
                        </div>
                    </div>
                </div>
            @endforeach
                

        </div>{{--row--}}
        <div class="row my-3">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-center">
                    {{ $pages->links() }}
                </div>
            </div>
        </div>
    </div>{{--container--}}

@endsection
