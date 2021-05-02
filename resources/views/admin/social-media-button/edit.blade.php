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
                <form class="form" action="{{ route('social-media-buttons.update', $social_media_button->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div
                        class="form-group row ">
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
                                           value="{{ old('title') ?? $social_media_button->title }}"
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
                                           placeholder="https://instagram.com/..."
                                           minlength="2"
                                           maxlength="100"
                                           value="{{ old('link') ?? $social_media_button->link }}"
                                           required
                                    >
                                    @include('partials.form_error', ['input'=>'link'])
                                </div>
                            </div>
                        </div>{{--./LINK--}}

                        <div class="col-md-12">{{--./IMAGE--}}
                            <div class="form-group row">
                                <label for="image"
                                       class="col-form-label col-md-2 text-center">
                                    <i class="fa fa-asterisk text-danger"></i>
                                    تصویر
                                </label>
                                <div class="col-md-10">
                                    <input id="image"
                                           name="image"
                                           type="file"
                                           class="form-control file-input @error('image') is-invalid @enderror"
                                           onchange="showImage(this);"
                                           accept=".jpg,.jpeg,.png,.gif"
                                    >
                                    @include('partials.form_error', ['input'=>'image'])
                                </div>
                            </div>
                        </div>{{--./IMAGE--}}


                    </div>{{--./MAIN FIELDS ROW--}}




                    <div class="form-row">
                        <div class="col-md-12">{{--PREVIEW IMAGE--}}
                            <div class="form-group row">
                                <div class="col-md-12 text-center">{{--IMG--}}
                                    <img src="{{asset($social_media_button->image)}}"
                                         alt="نمایش لوگو منتخب"
                                         class="preview img rounded align-middle"
                                         id="preview"
                                    >
                                </div>{{--./IMG--}}
                            </div>
                        </div>{{--./IMAGE--}}
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
    <script src="{{ asset('adminrc/plugins/img-checkbox/jquery.imgcheckbox.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {

        });

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
