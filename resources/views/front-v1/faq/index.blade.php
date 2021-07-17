@extends('layouts.app')


@section('content')

    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('faq') }}

    <div class="container-fluid my-3">{{--CONTAINER-FLUID--}}
        <div class="row justify-content-center">{{--ROW--}}
            {{--RIGHT ASIDE CONTENT--}}
            <div class="d-none d-lg-block col-lg-2">
                @include('front-v1.partials.shared.menu_aside')
                <div id="basket_aside_content">
                    @include('front-v1.partials.shared.basket_aside')
                </div>
            </div>
            {{--./RIGHT ASIDE CONTENT--}}

            {{--MAIN CONTENT--}}
            <div class="col-12 col-lg-8 my-2 shadow-lg rounded p-0">
                @if(!empty($faqs) && $faqs->count())
                    @foreach($faqs as $faq)
                        <div class="card border-0 @if(!$loop->first) mt-1 @endif  border-radius-0">
                            <a class="text-dark" data-toggle="collapse" href="#collapse-{{ $faq->id }}" role="button"
                               aria-expanded="false" aria-controls="collapse-{{$faq->id}}">
                                <div class="card-header border-bottom-0"
                                     id="heading-{{$faq->id}}"
                                >
                                    <div class="row justify-content-center">
                                        <div class="col-12 col-md-10 text-right">
                                            <h5 class="mb-0 font-20">
                                                {{ $faq->question }}
                                            </h5>
                                        </div>
                                        <div id="faq-{{$faq->id}}-icon"
                                             class="col-md-2 d-none d-md-inline-block text-left">
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
                                <div class="card-body border-bottom">
                                    {!! $faq->answer !!}

                                </div>
                            </div>
                        </div>

                    @endforeach
                @else
                    <div class="alert alert-warning border-0 text-center py-5">
                        <h5>
                            <span><i class="fal fa-pen fa-2x align-middle"></i></span>
                            در حال تکمیل بخش پرسش های متداول
                        </h5>
                    </div>
                @endif

            </div>
            {{--./MAIN CONTENT--}}

            @include('front-v1.partials.shared.social_media_aside')
        </div>{{--./ROW--}}
        @include('front-v1.partials.shared.social_media_banner')
    </div>{{--./CONTAINER-FLUID--}}

@endsection

@push('scripts')
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
@endpush
