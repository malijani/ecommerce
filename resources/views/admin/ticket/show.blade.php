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
                        @if($ticket->status == 0)
                            <span class="badge badge-success">{{ $ticket->status_text }}</span>
                        @elseif($ticket->status == 1)
                            <span class="badge badge-warning">{{ $ticket->status_text }}</span>
                        @elseif($ticket->status == 2)
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
                        <form action="{{ route('ticket-comments.store') }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ $ticket->id }}" name="ticket_id">
                            <div class="form-group row">
                                <label for="message" class="col-form-label col-md-2 text-center">
                                    <i class="fa fa-asterisk text-danger"></i>
                                    پاسخ
                                </label>
                                <div class="col-md-10">
                    <textarea name="message"
                              id="message"
                              class="form-control @error('message') is-invalid @enderror"
                              cols="30"
                              rows="10"
                              required
                    >{!!  old('message') !!}</textarea>
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
                    @include('partials.ticket_comments', ['ticket' => $ticket])
                </div>

            </div>{{--CARD BODY--}}

        </div>{{--CARD--}}
    </div>


@endsection


@section('page-scripts')
    <script src="{{ asset('adminrc/plugins/ckeditor-full/ckeditor.js') }}"></script>
    @include('admin.partials.ckeditor', ['input_id'=>'message'])
@endsection
