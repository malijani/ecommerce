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
                <form class="form" action="{{ route('social-medias.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">{{--TITLE--}}
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
                                           maxlength="70"
                                           minlength="2"
                                           class="form-control @error('title') is-invalid @enderror"
                                           placeholder="عنوان لینک"
                                           value="{{ old('title') }}"
                                           required
                                    >
                                    @include('partials.form_error', ['input'=>'title'])
                                </div>
                            </div>
                        </div>{{--./TITLE--}}

                        <div class="col-md-6">{{--LINK--}}
                            <div class="form-group row">
                                <label for="link"
                                       class="col-form-label col-md-2 text-center">
                                    <i class="fa fa-asterisk text-danger"></i>
                                    لینک
                                </label>
                                <div class="col-md-10">
                                    <input id="link"
                                           name="link"
                                           type="text"
                                           maxlength="100"
                                           minlength="1"
                                           class="ltr form-control @error('link') is-invalid @enderror"
                                           placeholder="لینک صفحه مجازی"
                                           value="{{ old('link') }}"
                                           required
                                    >
                                    @include('partials.form_error', ['input'=>'link'])
                                </div>
                            </div>
                        </div>{{--./LINK--}}
                        {{--TODO : ICON GOES HERE + ICON HELPER --}}
                        {{--TODO : IMAGE FIELDS GOES HERE!--}}

                        <div class="col-md-6">{{--STATUS--}}
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
                        </div>{{--STATUS--}}

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
