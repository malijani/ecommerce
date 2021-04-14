@extends('layouts.app')


@section('content')

    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('faq') }}

    <div class="container my-3 bg-white rounded">
        {{--TITLE--}}
        {{--META KEYWORDS--}}
        {{--META DISCRIPTION--}}
        {{--HEADER BOX--}}
        {{--FOOTER BOX--}}


        <div class="row p-3 py-5 ">
            <div class="col-12">

                @foreach($faqs as $faq)
                    <div class="card">
                        <a class="text-dark" data-toggle="collapse" href="#collapse-{{ $faq->id }}" role="button"
                           aria-expanded="false" aria-controls="collapse-{{$faq->id}}">
                            <div class="card-header" id="heading-{{$faq->id}}">
                                <div class="row justify-content-center">
                                    <div class="col-10 text-center text-md-right">
                                        <h5 class="mb-0 font-20">
                                            {{ $faq->question }}
                                        </h5>
                                    </div>
                                    <div id="faq-{{$faq->id}}-icon" class="col-2 d-none d-md-inline-block text-left">
                                        @if($faq->collapse == 1)
                                            <i class="far fa-minus-square fa-2x align-middle"></i>
                                        @else
                                            <i class="far fa-plus-square fa-2x align-middle"></i>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div id="collapse-{{ $faq->id }}" class="collapse @if($faq->collapse == 1)show @endif"
                             aria-labelledby="heading-{{$faq->id}}"
                        >
                            <div class="card-body">
                                {!! $faq->answer !!}

                            </div>
                        </div>
                    </div>

                @endforeach

            </div>{{--col-12--}}
        </div>{{--row--}}
    </div>{{--container--}}

@endsection

@section('page-scripts')
    <script>
        $(document).ready(function () {
            /*CONTROL THE DIRECTION OF CARET IN ATTRIBUTE SHOW*/
            @foreach($faqs as $faq)

            $("#collapse-{{$faq->id}}").on('show.bs.collapse hide.bs.collapse', function (e) {
                if (e.type === 'show') {
                    $("#faq-{{$faq->id}}-icon").html('<i class="far fa-minus-square fa-2x align-middle"></i>');
                } else {
                    $("#faq-{{$faq->id}}-icon").html('<i class="far fa-plus-square fa-2x align-middle"></i>');
                }
            });

            @endforeach
        });
    </script>
@endsection
