@extends('front-v1.user.dashboard.dashboard')

@section('bread-crumb')
    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('dashboard.tickets.show', $ticket) }}
@endsection
@section('dashboard-content')
    <div class="card border-0">
        <div class="card-header">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h4>تیکت <span dir="ltr">{{ '#'.$ticket->uuid }}</span></h4>
                </div>

                <div class="col-12 col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <span class="text-muted">دسته بندی : </span>
                            <span class="font-16 font-weight-bolder">{{ $ticket->category->title }}</span>
                        </div>
                        <div class="col-md-6">
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
                </div>

                <div class="col-md-12 mt-3 py-2">
                    <span class="font-16 font-weight-bolder">
                        {{ $ticket->title }}
                    </span>
                </div>

            </div>

        </div>

        <div class="card-body">

            {{--COMMENT FORM ROW--}}
            <div class="row p-md-4 rounded">
                <div class="col-12 p-0">
                    <form action="{{ route('dashboard.ticket-comments.store') }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="ticket_id" value="{{ $ticket->uuid }}">
                        <div class="form-group row">
                            <label for="message" class="col-form-label col-12 col-md-2">
                                <i class="fal fa-asterisk text-danger"></i>
                                پاسخ
                            </label>
                            <div class="col-12 col-md-10">
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
                            <label for="file" class="col-form-label col-12 col-md-2">
                                فایل
                            </label>
                            <div class="col-10">
                                <input type="file"
                                       name="file"
                                       id="file"
                                       class="form-control input-custom @error('file') is-invalid @enderror"
                                >
                            </div>
                        </div>

                        <div class="row">
                            <button type="submit"
                                    class="btn btn-custom form-control"
                            >
                                ثبت پاسخ
                            </button>
                        </div>


                    </form>
                </div>
            </div>


            {{--CONTENT ROW--}}
            <div class="row mt-3">
                @include('partials.ticket_comments', $ticket)
            </div>
        </div>
    </div>



@endsection

@push('scripts')

    <script src="{{ asset('front-v1/ckeditor/ckeditor.js') }}"></script>

    <script>
        $(document).ready(function () {
            CKEDITOR.replace('message', {
                contentsLangDirection: 'rtl',
                direction: 'rtl',
                contentsLanguage: 'fa',
                content: 'fa',
                language: 'fa',
                forcePasteAsPlainText: false,
                forceEnterMode: true,
                editorplaceholder: 'پاسخ شما به پشتیبان یا مطرح مسئله جدید',
                toolbarGroups: [{
                    "name": "basicstyles",
                    "groups": ["basicstyles"]
                },
                    {
                        "name": "links",
                        "groups": ["links"]
                    },
                    {
                        "name": "paragraph",
                        "groups": ["list", "blocks"]
                    },
                    {
                        "name": "document",
                        "groups": ["mode"]
                    },
                    {
                        "name": "insert",
                        "groups": ["insert"]
                    },
                    {
                        "name": "styles",
                        "groups": ["styles"]
                    },
                ],
            });
        });
    </script>
@endpush
