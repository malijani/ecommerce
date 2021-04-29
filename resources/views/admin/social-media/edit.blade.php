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
                <form class="form" action="{{ route('social-medias.update', $social_media->id) }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
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
                                           placeholder="نام شبکه اجتماعی"
                                           value="{{ old('title') ?? $social_media->title }}"
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
                                           value="{{ old('link') ?? $social_media->link }}"
                                           required
                                    >
                                    @include('partials.form_error', ['input'=>'link'])
                                </div>
                            </div>
                        </div>{{--./LINK--}}

                        <div class="col-md-6">{{--ICON--}}
                            <div class="form-group row">
                                <label for="icon"
                                       class="col-form-label col-md-2 text-center"
                                >
                                    <i class="fa fa-asterisk text-danger"></i>
                                    آیکن
                                </label>
                                <div class="col-10">
                                    <input type="text"
                                           class="form-control @error('icon') is-invalid @enderror ltr"
                                           minlength="2"
                                           maxlength="50"
                                           name="icon"
                                           id="icon"
                                           value="{{ old('icon') ?? $social_media->icon }}"
                                           placeholder="instagram"
                                           required
                                    >
                                    @include('partials.form_error', ['input'=>'icon'])
                                    <span class="text-muted">
                                        برای مشاهده لیست آیکن ها
                                        <a href="#icon_suggestion"> اینجا </a>
                                        کلیک کن
                                    </span>
                                </div>
                            </div>
                        </div>{{--./ICON--}}

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
                                        <option value="0" @if(old('status') ?? $social_media->status ==0) selected @endif>عدم نمایش</option>
                                        <option value="1" @if(old('status') ?? $social_media->status ==1) selected @endif>نمایش</option>
                                    </select>
                                    @include('partials.form_error', ['input'=>'status'])
                                </div>
                            </div>
                        </div>{{--./STATUS--}}

                        <div class="col-md-12">{{--SIDE IMAGE--}}
                            <div class="form-group row align-items-center">
                                <label for="side_image" class="col-form-label-col-2 text-center">
                                    <i class="fa fa-asterisk text-danger"></i>
                                    تصویر کوچک
                                </label>
                                <div class="col-md-4">
                                    <input type="file"
                                           class="form-control file-input @error('side_image') is-invalid @enderror"
                                           name="side_image"
                                           id="side_image"
                                           accept=".jpg,.jpeg,.png,.gif"
                                           onchange="showImage(this, 'preview-side-image');"
                                    >
                                    @include('partials.form_error', ['input'=>'side_image'])
                                </div>

                                <div class="col-md-6 text-center">{{--IMG--}}
                                    <img src="{{asset($social_media->side_image)}}"
                                         alt="تصویر انتخابی ساید بار "
                                         class="preview-side-image img img-fluid rounded align-middle"
                                         id="preview-side-image"
                                    >
                                </div>{{--./IMG--}}
                            </div>

                        </div>{{--./SIDE IMAGE--}}

                        <div class="col-md-12">{{--BANNER IMAGE--}}
                            <div class="form-group row align-items-center">
                                <label for="banner_image" class="col-form-label-col-2 text-center">
                                    <i class="fa fa-asterisk text-danger"></i>
                                    تصویر بزرگ
                                </label>
                                <div class="col-md-4">
                                    <input type="file"
                                           class="form-control file-input @error('banner_image') is-invalid @enderror"
                                           name="banner_image"
                                           id="banner_image"
                                           accept=".jpg,.jpeg,.png,.gif"
                                           onchange="showImage(this, 'preview-banner-image');"
                                    >
                                    @include('partials.form_error', ['input'=>'banner_image'])
                                </div>

                                <div class="col-md-6 text-center">{{--IMG--}}
                                    <img src="{{asset($social_media->banner_image)}}"
                                         alt="تصویر انتخابی بنر "
                                         class="preview-banner-image img img-fluid rounded align-middle"
                                         id="preview-banner-image"
                                    >
                                </div>{{--./IMG--}}
                            </div>

                        </div>{{--./BANNER IMAGE--}}


                        <div class="col-12">{{--SUBMIT BUTTON--}}
                            <div class="form-group row my-5 text-center">
                                <button type="submit" class="btn btn-outline-primary form-control">
                                    بروز رسانی
                                </button>
                            </div>
                        </div>{{--./SUBMIT BUTTON--}}
                    </div>


                </form>


                <div class="row" id="icon_suggestion">
                    <div class="col-md-8 mx-auto text-center bg-light rounded p-5">
                        <div class="content">
                            <p>
                                آیکن ها از نوع fontawesome هستن! و برای استفاده از اونا کافیه قسمت دوم بعد از -fa رو کپی
                                کنی و تو محل تعبیه شده قرار بدی.
                                مثلاً:
                            </p>
                            <span>
                                <i class="fa fa-instagram"></i> fa fa-instagram
                            </span>
                            <p>
                                برای استفاده از این آیکن کافیه که کلمه instagram رو وارد کنی!
                                برای دیدن لیست تمامی آیکن ها به
                                <a target="_blank" href="https://www.w3schools.com/icons/fontawesome_icons_brand.asp"
                                   class="btn btn-outline-info text-light"
                                > اینجا </a>
                                مراجعه کن
                            </p>
                        </div>
                    </div>
                </div>
            </div>{{--./MAIN FIELDS ROW--}}
            {{--./FORM END--}}
        </div>
    </div>

    <!-- /.card -->
@endsection

@section('page-scripts')
    <script>
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
        function showImage(element, preview_id) {
            //$('input[name="file[file]['+id+']"]').attr('name');
            function id(element) {
                let name = $(element).attr('name');
                return name[name.length - 2];
            }

            readURL(element, $('#' + preview_id));
        }
    </script>
@endsection
