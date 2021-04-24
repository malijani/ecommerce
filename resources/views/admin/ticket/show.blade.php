@extends('layouts.app_admin')

@section('content')
    <div class="col-md-12">

        <div class="card card-primary">

            <div class="card-header">
                <div class="card-title">{{ $title }}
                    <a href="{{ url()->previous() }}" role="button" class="pull-left text-white">
                        برگشت
                        <i class="fa fa-arrow-left"></i>
                    </a>
                </div>
            </div>
            <!-- /.card-header -->

            <div class="card-body">
                <!-- form start -->
                {{--TITLE ROW--}}
                <div class="row my-3 p-4 border border-info rounded">
                    <div class="col-12 text-center my-1">
                        <h2>{{ $ticket->title }}</h2>

                    </div>
                    <div class="col-12 mr-5 mt-3">
                        <span class="text-muted">دسته بندی : </span>
                        <span class="font-16 font-weight-bolder">{{ $ticket->category->title }}</span>
                    </div>

                    <div class="col-12 mt-3 mr-5">
                        <span class="text-muted">وضعیت کلی تیکت : </span>
                        @if($ticket->status === 0)
                            <span class="badge badge-success">{{ $ticket->status_text }}</span>
                        @elseif($ticket->status === 1)
                            <span class="badge badge-warning">{{ $ticket->status_text }}</span>
                        @elseif($ticket->status === 2)
                            <span class="badge badge-danger">{{ $ticket->status_text }}</span>
                        @else
                            <span class="badge badge-light">نامشخص</span>
                        @endif


                        @if($ticket->priority == 0)
                            <span class="badge badge-info">{{ $ticket->priority_text }}</span>
                        @elseif($ticket->priority == 1)
                            <span class="badge badge-warning">{{ $ticket->priority_text }}</span>
                        @elseif($ticket->priority == 2)
                            <span class="badge badge-danger">{{ $ticket->priority_text }}</span>
                        @else
                            <span class="badge badge-light">نامشخص</span>
                        @endif
                    </div>
                </div>

                {{--COMMENT FORM ROW--}}
                <div class="row bg-light-gray p-4 rounded">
                    <div class="col-12 text-center">
                        <form action="{{ route('dashboard.tickets.store') }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="message" class="col-form-label col-md-2 text-center">
                                    <i class="fal fa-asterisk text-danger"></i>
                                    پاسخ
                                </label>
                                <div class="col-md-10">
                    <textarea name="message"
                              id="message"
                              class="form-control @error('message') is-invalid @enderror"
                              cols="30"
                              rows="10"
                              required
                    >{{ old('message') }}</textarea>
                                    @include('partials.form_error', ['input'=>'message'])
                                </div>

                            </div>
                            <div class="form-group row">
                                <label for="file" class="col-form-label col-2 text-center">
                                    فایل
                                </label>
                                <div class="col-10">
                                    <input type="file"
                                           name="file"
                                           id="file"
                                           class="form-control @error('file') is-invalid @enderror"
                                    >
                                </div>
                            </div>

                            <div class="row">
                                <button type="submit" class="btn btn-outline-primary form-control">ثبت پاسخ</button>
                            </div>


                        </form>
                    </div>
                </div>


                {{--CONTENT ROW--}}
                <div class="row mt-3">
                    <div class="col-12 border rounded p-4 @if($ticket->user->isAdmin()) bg-grey-50 @endif">
                        <div class="row align-items-center m-0 p-0">
                            <div class="col-3 col-md-1">
                                <img src="{{ asset('images/fallback/user.png') }}"
                                     alt="{{ $ticket->user->full_name }}"
                                     class="rounded-circle img-fluid img-bordered-sm"
                                >
                            </div>
                            <div class="col-3">
                                {{ $ticket->user->full_name }}
                                @if($ticket->user->isAdmin())
                                    <span class="badge badge-primary">ادمین</span>
                                @endif
                            </div>

                            @if( $ticket->user->isAdmin())
                                <div class="col-5 text-left">
                                    {{ $ticket->user->contact_information }}
                                </div>
                            @endif

                        </div>
                        <hr>
                        <div class="row px-4 py-2">
                            <div class="col-12">
                                {!! $ticket->message !!}
                            </div>
                        </div>

                        <div class="row align-items-center px-3 py-1">

                            @if(!is_null($ticket->file))
                                <div class="col-4">
                                    <a href="{{ route('ticket-files.show', $ticket->id) }}"
                                       class="btn btn-light"
                                    >
                                        <i class="fa fa-download fa-2x align-middle"></i>
                                        دانلود فایل
                                    </a>
                                </div>
                            @endif
                            <div class="col text-left">
                    <span class="text-muted">
                        ثبت شده در :
                    {{ $ticket->created_at }}
                    </span>
                            </div>

                        </div>
                    </div>
                </div>

            </div>{{--CARD BODY--}}

        </div>{{--CARD--}}
    </div>


@endsection


@section('page-scripts')
    <script src="{{ asset('adminrc/plugins/ckeditor-full/ckeditor.js') }}"></script>
    <script>
        $(document).ready(function () {

            // CKEDITOR CONFIGURATION
            CKEDITOR.replace('message', {
                height: 400,
                baseFloatZIndex: 10005,
                contentsLangDirection: 'rtl',
                direction: 'rtl',
                contentsLanguage: 'fa',
                content: 'fa',
                language: 'fa',


                filebrowserImageBrowseUrl: '{{route('unisharp.lfm.show')}}',
                filebrowserImageUploadUrl: '{{route('unisharp.lfm.upload', ['type'=>'Images', '_token'=>csrf_token()])}}',
                filebrowserBrowseUrl: '{{route('unisharp.lfm.show', ['type'=>'Files'])}}',
                filebrowserUploadUrl: '{{route('unisharp.lfm.upload', ['type'=>'Files', '_token'=>csrf_token()])}}',


                font_names: 'Vazir;' +
                    'Arial/Arial, Helvetica, sans-serif;' +
                    'Comic Sans MS/Comic Sans MS, cursive;' +
                    'Courier New/Courier New, Courier, monospace;' +
                    'Georgia/Georgia, serif;' +
                    'Lucida Sans Unicode/Lucida Sans Unicode, Lucida Grande, sans-serif;' +
                    'Tahoma/Tahoma, Geneva, sans-serif;' +
                    'Times New Roman/Times New Roman, Times, serif;' +
                    'Trebuchet MS/Trebuchet MS, Helvetica, sans-serif;' +
                    'Verdana/Verdana, Geneva, sans-serif',
                font_defaultLabel: 'Vazir',
                forcePasteAsPlainText: false,
                forceEnterMode: true,
                editorplaceholder: 'با تشکر از انتخاب ما، بسته شما به سمت مقصد ارسال شد با کد رهگیری : ...',
            });
        });
    </script>

@endsection
