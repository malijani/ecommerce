@extends('front-v1.user.dashboard.dashboard')

@section('bread-crumb')
    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('dashboard.tickets.show', $ticket) }}
@endsection
@section('dashboard-content')
    <h4>تیکت <span dir="ltr">{{ '#'.$ticket->uuid }}</span></h4>
    {{--TITLE ROW--}}
    <div class="row my-3 bg-whitesmoke p-4 rounded">
        <div class="col-12 text-center my-1">
            <span class="font-16 font-weight-bolder">
            {{ $ticket->title }}
            </span>
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

    {{--COMMENt ROW--}}
    <div class="row bg-grey-50 p-4 rounded">
        <div class="col-12 text-center">
            <form action="{{ route('dashboard.tickets.store') }}" method="POST" enctype="multipart/form-data">
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
        <div class="col-12 border rounded p-4 ">
            {!! $ticket->message !!}
            @if(!is_null($ticket->file))
                <hr>
                <a href="{{ route('ticket-files.show', $ticket->id) }}"
                >
                    دانلود فایل
                </a>

            @endif
        </div>
    </div>

@endsection

@section('page-scripts')
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
                editorplaceholder: 'با تشکر از انتخاب ما، بسته شما به سمت مقصد ارسال شد با کد رهگیری : ...',
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
@endsection
