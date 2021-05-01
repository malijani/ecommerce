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
                <form class="form" action="{{ route('image-menus.store') }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">
                        <div class="col-md-6">{{--TITLE--}}
                            <div class="form-group row">
                                <label for="title"
                                       class="col-form-label col-md-3 text-center">
                                    <i class="fa fa-asterisk text-danger"></i>
                                    عنوان
                                </label>
                                <div class="col-md-9">
                                    <input id="title"
                                           name="title"
                                           type="text"
                                           class="form-control @error('title') is-invalid @enderror"
                                           placeholder="مقدار دهی الزامی"
                                           minlength="2"
                                           maxlength="50"
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
                                       class="col-form-label col-md-3 text-center">
                                    <i class="fa fa-asterisk text-danger"></i>
                                    لینک
                                </label>
                                <div class="col-md-9">
                                    <input id="link"
                                           name="link"
                                           type="text"
                                           class="form-control @error('link') is-invalid @enderror ltr"
                                           placeholder="https://site.ir/page/test"
                                           minlength="2"
                                           maxlength="100"
                                           value="{{ old('link') }}"
                                           required
                                    >
                                    @include('partials.form_error', ['input'=>'link'])
                                </div>
                            </div>
                        </div>{{--./LINK--}}


                        <div class="col-md-4">{{--./IMAGE--}}
                            <div class="form-group row">
                                <label for="image"
                                       class="col-form-label col-md-3 text-center">
                                    <i class="fa fa-asterisk text-danger"></i>
                                    تصویر
                                </label>
                                <div class="col-md-9">
                                    <input id="image"
                                           name="image"
                                           type="file"
                                           class="form-control file-input @error('image') is-invalid @enderror"
                                           onchange="showImage(this);"
                                           accept=".jpg,.jpeg,.png,.gif"
                                           required
                                    >
                                    @include('partials.form_error', ['input'=>'image'])
                                </div>
                            </div>
                        </div>{{--./IMAGE--}}

                        <div class="col-md-4">{{--TYPE--}}
                            <div class="form-group row">
                                <label for="type"
                                       class="col-form-label col-md-3 text-center"
                                >
                                    <i class="fa fa-asterisk text-danger"></i>
                                    دسته بندی
                                </label>

                                <div class="col-md-9">
                                    <select name="type"
                                            id="type"
                                            class="form-control @error('type') is-invalid @enderror"
                                            required
                                    >
                                        <option value="" disabled>انتخاب کنید...</option>
                                        <option value="0" @if(old('type')==0) selected @endif>
                                            صفحات نحوه فروش و ارسال
                                        </option>
                                        <option value="1" @if(old('type')==1) selected @endif>
                                            منو تصویری صفحه اصلی
                                        </option>
                                        <option value="2" @if(old('type')==2) selected @endif>
                                            منو تصاویر بزرگ صفحه اصلی
                                        </option>
                                        <option value="3" @if(old('type')==3) selected @endif>
                                            منو صفحات جانبی
                                        </option>
                                        <option value="4" @if(old('type')==4) selected @endif >
                                            منو تصاویر بزرگ پایین صفحه
                                        </option>
                                    </select>
                                    @include('partials.form_error', ['input'=>'type'])
                                </div>
                            </div>
                        </div>{{--./TYPE--}}

                        <div class="col-md-4">{{--STATUS--}}
                            <div class="form-group row">
                                <label for="status" class="col-form-label col-md-3 text-center">
                                    <i class=" fa fa-asterisk text-danger"></i>
                                    وضعیت
                                </label>
                                <div class="col-md-9">
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


                    <div class="form-row">
                        <div class="col-md-12">{{--PREVIEW IMAGE--}}
                            <div class="form-group row">
                                <div class="col-4 mx-auto text-center">{{--IMG--}}
                                    <img src="{{asset('images/fallback/image_menu.png')}}"
                                         alt="نمایش تصویر منو" class="preview img img-fluid rounded align-middle w-50"
                                         id="preview"
                                    >
                                </div>{{--./IMG--}}
                            </div>
                        </div>{{--./PREVIEW PIC --}}
                    </div>

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
    <script type="text/javascript">
        // Set image src for selected image tag
        function readURL(input, img) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    img.attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Show image preview for each file input
        function showImage(element) {
            //$('input[name="file[file]['+id+']"]').attr('name');
            function id(element) {
                let name = $(element).attr('name');
                return name[name.length - 2];
            }

            readURL(element, $('#preview'));
        }

    </script>
@endsection
