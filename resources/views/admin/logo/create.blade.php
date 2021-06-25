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
                <form class="form" action="{{ route('logos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div
                        class="form-group row ">{{--ROW OF FILE INPUT WITH TITLE AND SELECTION--}}
                        <div class="col-md-6">{{--PIC_ALT--}}
                            <div class="form-group row">
                                <label for="pic_alt"
                                       class="col-form-label col-md-3 text-center">
                                    <i class="fa fa-asterisk text-danger"></i>
                                    عنوان
                                </label>
                                <div class="col-md-9">
                                    <input id="pic_alt"
                                           name="pic_alt"
                                           type="text"
                                           class="form-control @error('pic_alt') is-invalid @enderror"
                                           title="مقدار دهی الزامی"
                                           minlength="2"
                                           maxlength="70"
                                           value="{{ old('pic_alt') }}"
                                           required
                                    >
                                    @include('partials.form_error', ['input'=>'pic_alt'])
                                </div>
                            </div>
                        </div>{{--./PIC_ALT--}}

                        <div class="col-md-6">{{--./PIC--}}
                            <div class="form-group row">
                                <label for="pic"
                                       class="col-form-label col-md-3 text-center">
                                    <i class="fa fa-asterisk text-danger"></i>
                                    تصویر
                                </label>
                                <div class="col-md-9">
                                    <input id="pic"
                                           name="pic"
                                           type="file"
                                           class="form-control file-input @error('pic') is-invalid @enderror"
                                           onchange="showImage(this);"
                                           accept=".jpg,.jpeg,.png,.gif"
                                           required
                                    >
                                    @include('partials.form_error', ['input'=>'pic'])
                                </div>
                            </div>
                        </div>{{--./PIC--}}
                    </div>{{--./MAIN FIELDS ROW--}}




                    <div class="form-row">
                        <div class="col-md-12">{{--PREVIEW PIC + DEFAULT SELECTOR--}}
                            <div class="form-group row justify-content-center">
                                <div class="col-md-12 text-center">{{--IMG--}}
                                    <img src="{{asset('images/fallback/logo.png')}}"
                                         alt="نمایش لوگو منتخب"
                                         class="preview img rounded align-middle image-checkable"
                                         id="preview"
                                         height="400"
                                         name="status"
                                    >
                                </div>{{--./IMG--}}
                            </div>
                        </div>{{--./PREVIEW PIC + DEFAULT SELECTOR--}}
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
            $("#preview").imgCheckbox({
                preselect: true,
                graySelected: false,
                scaleSelected: true,
                checkMarkSize: "30px",
                checkMarkPosition: 'top-left',
                checkMarkImage: "{{ asset('images/asset/checked.png') }}",
                fadeCheckMark: true,
                addToForm: true,
            });

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
