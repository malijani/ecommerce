@extends('layouts.app_admin')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('adminrc/plugins/select2/select2.min.css') }}">
@endsection

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
                <form class="form" action="{{ route('faqs.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-12">{{--QUESTION--}}
                            <div class="form-group row">
                                <label for="question"
                                       class="col-form-label col-md-2 text-center">
                                    <i class="fa fa-asterisk text-danger"></i>
                                    پرسش
                                </label>
                                <div class="col-md-10">
                                    <input id="question"
                                           name="question"
                                           type="text"
                                           maxlength="70"
                                           minlength="5"
                                           class="form-control @error('question') is-invalid @enderror"
                                           placeholder="سوال پر تکرار: زمینه فعالیت وبسایت ، نحوه ارسال و ..."
                                           value="{{ old('question') }}"
                                           required
                                    >
                                    @include('partials.form_error', ['input'=>'question'])
                                </div>
                            </div>
                        </div>{{--./QUESTION--}}

                        <div class="col-md-12">{{--ANSWER--}}
                            <div class="form-group row">
                                <label for="answer"
                                       class="col-form-label col-md-2 text-center">
                                    <i class="fa fa-asterisk text-danger"></i>
                                    پاسخ
                                </label>
                                <div class="col-md-10">
                                    <textarea id="answer"
                                              name="answer"
                                              class="form-control @error('answer') is-invalid @enderror"
                                              placeholder="پاسخ به پرسش مطرح شده"
                                              required
                                              rows="20"
                                    >{{ old('answer') }}</textarea>
                                    @include('partials.form_error', ['input'=>'answer'])
                                </div>
                            </div>
                        </div>{{--./ANSWER--}}


                        <div class="col-md-4">{{--STATUS--}}
                            <div class="form-group row">
                                <label for="status" class="col-form-label col-md-4 text-center">
                                    <i class=" fa fa-asterisk text-danger"></i>
                                    وضعیت
                                </label>
                                <div class="col-md-8">
                                    <select name="status"
                                            id="status"
                                            class="form-control @error('status') is-invalid @enderror"
                                            required
                                    >
                                        <option value="" disabled>انتخاب کنید...</option>
                                        <option value="0" @if(old('status')==0) selected @endif>عدم نمایش</option>
                                        <option value="1" @if(old('status')==1) selected @endif>نمایش</option>
                                    </select>
                                    @include('partials.form_error', ['input'=>'status'])
                                </div>
                            </div>
                        </div>{{--STATUS--}}

                        <div class="col-md-4">{{--COLLAPSE--}}
                            <div class="form-group row">
                                <label for="collapse" class="col-form-label col-md-4 text-center">
                                    <i class=" fa fa-asterisk text-danger"></i>
                                    نحوه نمایش
                                </label>
                                <div class="col-md-8">
                                    <select name="collapse"
                                            id="collapse"
                                            class="form-control @error('collapse') is-invalid @enderror"
                                            required
                                    >
                                        <option value="" disabled>انتخاب کنید...</option>
                                        <option value="0" @if(old('collapse')==0) selected @endif>جمع شده</option>
                                        <option value="1" @if(old('collapse')==1) selected @endif>باز شده</option>
                                    </select>
                                    @include('partials.form_error', ['input'=>'screen'])
                                </div>
                            </div>
                        </div>{{--./COLLAPSE--}}


                        <div class="col-md-4">{{--SORT--}}
                            <div class="form-group row">
                                <label for="sort" class="col-form-label col-md-4 text-center">
                                    <i class=" fa fa-asterisk text-danger"></i>
                                    اولویت
                                </label>
                                <div class="col-md-8">
                                    <input name="sort"
                                           id="sort"
                                           type="number"
                                           min="0"
                                           max="255"
                                           class="form-control @error('sort') is-invalid @enderror"
                                           required
                                           placeholder="ترتیب نمایش به کاربر : 1-255"
                                           value="{{ old('sort') }}"
                                    >
                                    @include('partials.form_error', ['input'=>'sort'])
                                </div>
                            </div>
                        </div>{{--./SORT--}}


                        <div class="col-12">{{--SUBMIT BUTTON--}}
                            <div class="form-group row my-5 text-center">
                                <button type="submit" class="btn btn-outline-primary form-control">
                                    ذخیره
                                </button>
                            </div>
                        </div>{{--./SUBMIT BUTTON--}}
                    </div>


                </form>

            </div>{{--./MAIN FIELDS ROW--}}
            {{--./FORM END--}}
        </div>
    </div>

    <!-- /.card -->
@endsection


@section('page-scripts')
    <script src="{{ asset('adminrc/plugins/ckeditor-full/ckeditor.js') }}"></script>
    <script src="{{ asset('adminrc/plugins/select2/select2.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                dir: "rtl",
            });

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
                editorplaceholder: 'پاسخ به پرسش مطرح شده',
            });
        });
    </script>

@endsection
