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
                <form class="form" action="{{ route('footer-texts.store') }}" method="POST">
                    @csrf

                    <div
                        class="form-group row ">
                        <div class="col-md-12">{{--TITLE--}}
                            <div class="form-group row">
                                <label for="title"
                                       class="col-form-label col-md-2 text-center">
                                    <i class="fa fa-asterisk text-danger"></i>
                                    عنوان
                                </label>
                                <div class="col-md-10">
                                    <input id="title"
                                           name="title"
                                           type="text"
                                           class="form-control @error('title') is-invalid @enderror"
                                           placeholder="سرنوشته متن فوتر"
                                           minlength="2"
                                           maxlength="50"
                                           value="{{ old('title') }}"
                                           required
                                    >
                                    @include('partials.form_error', ['input'=>'title'])
                                </div>
                            </div>
                        </div>{{--./TITLE--}}

                        <div class="col-md-12">{{--./CONTENT--}}
                            <div class="form-group row">
                                <label for="content"
                                       class="col-form-label col-md-2 text-center">
                                    <i class="fa fa-asterisk text-danger"></i>
                                    محتوا
                                </label>
                                <div class="col-md-10">
                                    <textarea name="content"
                                              id="content"
                                              class="form-control @error('content') is-invalid @enderror"
                                              cols="30"
                                              rows="10"
                                              minlength="10"
                                    >{{ old('content') }}</textarea>
                                    @include('partials.form_error', ['input'=>'content'])
                                </div>
                            </div>
                        </div>{{--./CONTENT--}}

                        <div class="col-md-12">{{--STATUS--}}
                            <div class="form-group row">
                                <label for="status" class="col-form-label col-md-2 text-center">
                                    <i class=" fa fa-asterisk text-danger"></i>
                                    وضعیت
                                </label>
                                <div class="col-md-10">
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
                        </div>{{--./STATUS--}}
                    </div>{{--./MAIN FIELDS ROW--}}


                    <div class="form-group row my-5 text-center">

                        <button type="submit" class="btn btn-outline-primary form-control">
                            ذخیره
                        </button>

                    </div>
                </form>
                {{--./FORM END--}}
            </div>
        </div>
    </div>
    <!-- /.card -->
@endsection


@section('page-scripts')

    <script src="{{ asset('adminrc/plugins/ckeditor-full/ckeditor.js') }}"></script>
    <script>
        $(document).ready(function () {
            // CKEDITOR CONFIGURATION
            CKEDITOR.replace('content', {
                height: 400,
                baseFloatZIndex: 10005,
                contentsLangDirection: 'rtl',
                direction: 'rtl',
                contentsLanguage: 'fa',
                content: 'fa',
                language: 'fa',

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
                editorplaceholder: 'محتوای متن فوتر',
            });
        });
    </script>

@endsection
