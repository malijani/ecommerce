@push('styles')
    <link rel="stylesheet" href="{{ asset('front-v1/select2/select2.min.css') }}">
@endpush

<div class="card border-0 shadow-sm">
    <div class="card-header ">
        <h4>آدرس تحویل سفارش</h4>
    </div>

    <div class="card-body">
        @if($default_address!=null)
            <div class="row mt-5">
                <div class="col-2 text-center">
                    <i class="fal fa-location-arrow fa-2x"></i>
                </div>
                <div class="col-10 pr-1 pl-4 font-weight-bolder text-right">
                    <div class="main-address">
                        <div class="p-1">
                            {{$default_address['province']}} - {{$default_address['city']}}
                            - {{ $default_address['address'] }}
                        </div>
                        @if(!empty($default_address['name_family']))
                            <div class="p-2">
                                <i class="fa fa-user"></i>
                                {{$default_address['name_family']}}
                            </div>
                        @endif
                        @if(!empty($default_address['mobile']))
                            <div class="ltr p-2">
                                {{$default_address['mobile']}}
                                @if(!empty($default_address['tell']))
                                    - {{$default_address['tell']}}
                                @endif
                                <i class="fa fa-phone"></i>
                            </div>
                        @endif
                        @if(!empty($default_address['post_code']))
                            <div class="ltr p-2">
                                {{$default_address['post_code']}}
                                <i class="fa fa-home"></i>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="row mt-5">
                <div class="col-12 text-center">
                    <p class="alert alert-danger p-4 rounded"
                    >
                        آدرسی برای ارسال سفارش وجود ندارد! لطفاً یک آدرس جدید ثبت کنید.
                    </p>
                </div>
            </div>
        @endif

        {{--ADD NEW ADDRESS--}}
        <div class="row mt-5">
            <div class="col-12">
                <button type="button"
                        name="add-new-address-button"
                        id="add-new-address-button"
                        class="btn btn-custom w-100"
                        data-toggle="collapse"
                        data-target="#add-new-address-form"
                        aria-expanded="false"
                        aria-controls="collapseExample"
                >
                    <i class="fa fa-plus"></i>
                    ثبت آدرس جدید
                </button>
            </div>
            {{--FORM COLLAPSE--}}
            <div class="col-12 collapse @if($default_address==null || $errors->any()) show @endif"
                 id="add-new-address-form"
            >

                <div class="card-body px-0">
                    {{--name_family, mobile, tell, province, city, address, post_code, status--}}
                    <form action="{{ route('address.store') }}"
                          method="POST"
                          class="text-right"
                    >
                        @csrf

                        <div class="form-row form-group">
                            <label for="name_family"
                                   class="col-form-label py-0 col-12"
                            >
                                <i class="fa fa-asterisk text-danger"></i>
                                نام و نام خانوادگی
                            </label>
                            <div class="col-12">
                                <input name="name_family"
                                       type="text"
                                       class="input-custom form-control @error('name_family') is-invalid @enderror"
                                       id="name_family"
                                       placeholder="نام و نام خانوادگی گیرنده مرسوله : محمد علیجانی"
                                       value="{{ old('name_family') }}"
                                       minlength="5"
                                       maxlength="100"
                                       required
                                       autofocus
                                       autocomplete="off"
                                >
                                @include('partials.form_error',['input'=>'name_family'] )
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-row form-group">
                                    <label for="mobile"
                                           class="col-form-label py-0 col-12"
                                    >
                                        <i class="fa fa-asterisk text-danger"></i>
                                        تلفن همراه
                                    </label>
                                    <div class="col-12">
                                        <input name="mobile"
                                               type="text"
                                               class="input-custom form-control text-center ltr @error('mobile') is-invalid @enderror"
                                               id="mobile"
                                               placeholder="09121231122"
                                               value="{{ auth()->user()->mobile ?? old('mobile') }}"
                                               maxlength="11"
                                               minlength="11"
                                               required
                                               autocomplete="off"
                                        >
                                        @include('partials.form_error',['input'=>'mobile'] )
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-row form-group">
                                    <label for="tell"
                                           class="col-form-label py-0 col-12"
                                    >
                                        تلفن ثابت
                                    </label>
                                    <div class="col-12">
                                        <input name="tell"
                                               type="text"
                                               class="input-custom form-control text-center ltr @error('tell') is-invalid @enderror"
                                               id="tell"
                                               placeholder="02122435465"
                                               maxlength="11"
                                               minlength="11"
                                               value="{{ old('tell') }}"
                                               autocomplete="off"
                                        >
                                        @include('partials.form_error',['input'=>'tell'] )
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-row form-group">
                                    <label for="province"
                                           class="col-form-label py-0 col-12"
                                    >
                                        <i class="fa fa-asterisk text-danger"></i>
                                        استان
                                    </label>
                                    <div class="col-12">
                                        <select name="province"
                                                class="input-custom form-control @error('province') is-invalid @enderror"
                                                id="province"
                                                required
                                        >
                                            <option value="">لطفاً استان مقصد را انتخاب کنید</option>
                                            @foreach($provinces as $province)
                                                <option value="{{$province->title}}">{{$province->title}}</option>
                                            @endforeach
                                        </select>
                                        @include('partials.form_error',['input'=>'province'] )
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-row form-group">
                                    <label for="city"
                                           class="col-form-label py-0 col-12"
                                    >
                                        <i class="fa fa-asterisk text-danger"></i>
                                        شهر
                                    </label>
                                    <div class="col-12">
                                        <select name="city"
                                                class="input-custom form-control @error('city') is-invalid @enderror"
                                                id="city"
                                                disabled
                                                required
                                        >
                                            <option value="">ابتدا استان مقصد را انتخاب کنید</option>
                                        </select>
                                        @include('partials.form_error',['input'=>'city'] )
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-row form-group align-items-center">
                            <label for="address"
                                   class="col-form-label py-0 col-12"
                            >
                                <i class="fa fa-asterisk text-danger"></i>
                                آدرس
                            </label>
                            <div class="col-12">
                                <textarea name="address"
                                          type="text"
                                          class="textarea-custom form-control @error('address') is-invalid @enderror"
                                          id="address"
                                          placeholder=" منطقه 1 شهرداری (گشت 16987)، لشگرک بزرگراه ارتش(لشگرک)، جاده تلو لواسان، پلاک 0"
                                          rows="4"
                                          required
                                >{{ old('address') }}</textarea>
                                @include('partials.form_error',['input'=>'address'] )
                            </div>
                        </div>


                        <div class="form-row form-group align-items-center">
                            <label for="post_code"
                                   class="col-form-label py-0 col-12"
                            >
                                کد پستی
                            </label>
                            <div class="col-12">
                                <input name="post_code"
                                       type="text"
                                       class="input-custom form-control text-center @error('post_code') is-invalid @enderror"
                                       id="post_code"
                                       placeholder="1698713911"
                                       maxlength="10"
                                       minlength="10"
                                       value="{{ old('post_code') }}"
                                       autocomplete="off"
                                >
                                @include('partials.form_error',['input'=>'post_code'] )
                            </div>
                        </div>

                        <div class="form-row form-group align-items-center justify-content-start">
                            <div class="col-2">
                                <input name="status"
                                       class="form-control"
                                       type="checkbox"
                                       id="status"
                                       @if(old('status')) checked @endif
                                >
                            </div>
                            <label class="col-form-label py-0 col-8"
                                   for="status"
                            >
                                تعیین بعنوان آدرس پیش فرض
                            </label>
                            @include('partials.form_error',['input'=>'status'] )
                        </div>

                        <div class="form-row">
                            <div class="col-12 mt-3">
                                <button type="submit"
                                        class="btn btn-custom w-100"
                                >
                                    ثبت آدرس گیرنده
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{--./FORM COLLAPSE--}}
        </div>
        {{--./ADD NEW ADDRESS--}}




        @if(count($addresses)>1)
            <div class="row mx-2 w-100">
                @foreach($addresses as $address)

                    @if($address['id']==$default_address['id'])
                        @continue
                    @endif
                    <div class="col-12 mt-4 border rounded p-4">
                        <div class="row align-items-center">
                            <div class="col-lg-10 col-12 mb-1">
                                <div class="other-addresses">
                                    <div class="p-1">
                                        {{$address['province']}} - {{$address['city']}}
                                        - {{ $address['address'] }}
                                    </div>
                                    @if(!empty($address['name_family']))
                                        <div class="p-2">
                                            <i class="fa fa-user"></i>
                                            {{$address['name_family']}}
                                        </div>
                                    @endif
                                    @if(!empty($address['mobile']))
                                        <div class="ltr p-2">
                                            {{$address['mobile']}}
                                            @if( !empty($address['tell']))
                                            - {{$address['tell']}}
                                            @endif
                                            <i class="fa fa-phone"></i>
                                        </div>
                                    @endif
                                    @if(!empty($address['post_code']))
                                        <div class="ltr p-2">
                                            {{$address['post_code']}}
                                            <i class="fa fa-home"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-1 col-6 pr-0 text-center">
                                <button class="btn btn-light"
                                        id="set-default-{{$address['id']}}"
                                        onclick="setDefault({{$address['id']}});"
                                        data-target="{{ route('address.update',$address['id']) }}"
                                >
                                    <i class="fal fa-check-square fa-2x text-success"></i>
                                </button>
                            </div>
                            <div class="col-lg-1 col-6 pr-0 text-center">
                                <button class="btn btn-light"
                                        id="del-{{$address['id']}}"
                                        onclick="del({{$address['id']}});"
                                        data-target="{{ route('address.destroy', $address['id']) }}"
                                >
                                    <i class="fal fa-trash-alt fa-2x text-danger"></i>
                                </button>
                            </div>

                        </div>
                    </div>

                @endforeach
            </div>
        @endif
    </div>
</div>



@push('scripts')

    <script src="{{ asset('front-v1/select2/select2.min.js') }}"></script>
    <script>

        /*UPDATE USER ADDRESS AS DEFAULT ADDRESS*/
        function setDefault(id) {
            $.ajax({
                url: $("#set-default-" + id).attr('data-target'),
                type: 'POST',
                data: {
                    '_method': 'PATCH',
                },
                success: function (data) {
                    Swal.fire({
                        position: 'top',
                        icon: "success",
                        title: "<h5>" + data.message + "</h5>",
                        showConfirmButton: false,
                        timer: 1500,
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function (data) {
                    Swal.fire({
                        position: 'top',
                        icon: "error",
                        title: "<h5>" + data.responseJSON.message + "</h5>",
                        showConfirmButton: false,
                        timer: 1500,
                    }).then(() => {
                        location.reload();
                    });
                }

            })
        }

        /*delete an address from user address portal*/
        function del(id) {
            $.ajax({
                url: $("#del-" + id).attr('data-target'),
                type: 'POST',
                data: {
                    '_method': 'DELETE',
                    'id': id,
                },
                success: function (data) {
                    Swal.fire({
                        position: 'top',
                        icon: "success",
                        title: "<h5>" + data.message + "</h5>",
                        showConfirmButton: false,
                        timer: 1500,
                    }).then(() => {
                        location.reload();
                    });

                },
                error: function (data) {
                    Swal.fire({
                        position: 'top',
                        icon: "error",
                        title: "<h5>" + data.responseJSON.message + "</h5>",
                        showConfirmButton: false,
                        timer: 1500,
                    }).then(() => {
                        location.reload();
                    });
                }
            });

        }


        let
            persianNumbers = [/۰/g, /۱/g, /۲/g, /۳/g, /۴/g, /۵/g, /۶/g, /۷/g, /۸/g, /۹/g],
            arabicNumbers = [/٠/g, /١/g, /٢/g, /٣/g, /٤/g, /٥/g, /٦/g, /٧/g, /٨/g, /٩/g],
            fixNumbers = function (str) {
                if (typeof str === 'string') {
                    for (let i = 0; i < 10; i++) {
                        str = str.replace(persianNumbers[i], i).replace(arabicNumbers[i], i);
                    }
                }
                return str;
            };

        $(document).ready(function () {

            /*FIX NUMBERS ON INPUT*/
            $("input:text").on('keyup', function () {
                $(this).val(fixNumbers($(this).val()));
            });


            /*CREATE SELECT2 AND AJAX REQUEST OF CITIES*/
            let province = $('#province');
            let city = $('#city');
            province.select2({
                placeholder: 'استان مقصد را انتخاب نمایید',
                dir: 'rtl',
                language: 'fa',
                width: '100%',
                noResults: function () {
                    return "نتیجه ای یافت نشد!";
                },
            });
            city.select2({
                placeholder: 'ابتدا استان مقصد را انتخاب کنید',
                dir: 'rtl',
                language: 'fa',
                width: '100%',
                noResults: function () {
                    return "نتیجه ای یافت نشد!";
                },
            });

            province.on('change', function () {
                let title = province.val();
                if (title !== '') {
                    $('body').css({'opacity': '0.5'});
                    $.ajax({
                        url: "{{ route('province.cities') }}",
                        type: 'POST',
                        data: {
                            'title': title,
                        },
                        success: function (data) {
                            city.html('');
                            $.each(data, function (i, item) {
                                city.append(
                                    $('<option>', {
                                        value: item.title,
                                        text: item.title,
                                    }),
                                );
                            });
                            city.prop('disabled', false);
                            $('body').css({'opacity': '1'});


                        },
                        error: function () {
                            $('body').css({'opacity': '1'});
                            city.prop('disabled', true);
                        },
                    });
                }
            });

        });
    </script>
@endpush
