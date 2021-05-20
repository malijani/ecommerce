@extends('front-v1.user.dashboard.dashboard')

@section('bread-crumb')
    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('dashboard.profile') }}
@endsection

@section('dashboard-content')
    <h4>مدیریت حساب کاربری</h4>
    <form role="form" action="{{ route('dashboard.profile.update', $user->id) }}" method="POST"
          enctype="multipart/form-data">
        @csrf
        {{ method_field('PUT') }}

        <div class="card-body">

            {{--IMAGE--}}
            <div class="form-group row justify-content-center">

                <label for="pic" class="profile-pic col-form-label col-md-5 position-relative text-center">
                    <img src="{{ asset($user->pic ?? 'images/fallback/user.png') }}"
                         alt="{{ $user->name }}"
                         class="img img-fluid rounded"
                         id="preview"
                    >

                    @if(isset($user->pic))
                        <button type="button"
                                data-url="{{ route('dashboard.profile.update', $user->id) }}"
                                class="delete_pic btn btn-sm btn-outline-danger rounded-circle position-absolute mr-1"
                        >
                            <i class="fal fa-times align-middle"></i>
                        </button>
                    @endif

                </label>

                <div class="col-md-8">
                    <input id="pic"
                           type="file"
                           name="pic"
                           accept=".jpg,.jpeg,.png"
                           onchange="showImage(this);"
                           hidden
                    >
                    @include('partials.form_error', ['input'=>'pic'])
                </div>


            </div>


            {{--NAME--}}
            <div class="form-group row justify-content-center align-items-center">
                <label for="name"
                       class="col-md-2 col-form-label text-md-center">
                    نام
                </label>
                <div class="col-md-6 col-8">
                    <input id="name"
                           type="text"
                           class="form-control text-center @error('name') is-invalid @enderror"
                           name="name" value="{{ old('name') ?? $user->name }}"
                           autocomplete="name"
                           placeholder="نام کاربر"
                    >
                    @include('partials.form_error', ['input'=>'name'])
                </div>
                <div class="col-4 text-center bg-whitesmoke rounded py-2">
                    <span class="text-muted font-weight-bolder">
                        {{ $user->uuid }}
                    </span>
                </div>
            </div>


            {{--EMAIL--}}
            <div class="form-group row justify-content-center">
                <label for="email"
                       class="col-md-2 col-form-label text-md-center"
                >
                    آدرس ایمیل
                </label>

                <div class="col-md-10 ">
                    <input
                        name="email"
                        id="email"
                        class="form-control text-center @error('email') is-invalid @enderror"
                        value="{{ $user->email }}"
                        maxlength="70"
                        minlength="10"
                        placeholder="user@gmail.com"
                    >
                    @include('partials.form_error', ['input'=>'name'])
                </div>
            </div>


            {{--MOBILE--}}
            <div class="form-group row justify-content-center">
                <label for="mobile"
                       class="col-md-2 col-form-label text-md-center"
                >
                    تلفن همراه
                </label>

                <div class="col-md-10">
                    <input id="mobile"
                           type="number"
                           class="ltr form-control text-center @error('mobile') is-invalid @enderror"
                           name="mobile"
                           value="{{ $user->mobile }}"
                           minlength="11"
                           maxlength="11"
                           autocomplete="mobile"
                           placeholder="09103234432"
                           required
                           readonly
                    >

                    @include('partials.form_error', ['input'=>'mobile'])
                </div>

            </div>


        </div>

        <div class="row my-4">
            <div class="col-12 px-3">
                <button type="submit" class="btn btn-block btn-outline-info">اعمال ویرایش</button>
            </div>
        </div>
    </form>

@endsection

@push('scripts')
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
        function showImage(element) {
            //$('input[name="file[file]['+id+']"]').attr('name');
            function id(element) {
                let name = $(element).attr('name');
                return name[name.length - 2];
            }

            readURL(element, $('#preview'));
        }

        @if(isset($user->pic))
        $(document).ready(function () {
            $(".delete_pic").on('click', function () {
                $.ajax({
                    url: $(this).attr('data-url'),
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        '_method': 'PATCH',
                        'delete': 'true',
                    },
                    success: function (result) {
                        location.reload();
                    },
                    error: function () {
                        location.reload();
                    }
                });
            });
        });
        @endif
    </script>
@endpush

