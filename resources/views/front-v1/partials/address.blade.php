<h4>آدرس تحویل سفارش</h4>
@if($default_address!=null)
    <div class="row mt-5">
        <div class="col-2 text-center">
            <i class="fa fa-location-arrow fa-2x"></i>
        </div>
        <div class="col-10 pr-1 pl-4 font-weight-bolder">
            <div class="main-address">
                <div class="p-1">
                    {{$default_address['province']}} - {{$default_address['city']}}
                    - {{ $default_address['address'] }}
                </div>
                @if(isset($default_address['name_family']))
                    <div class="p-2">
                        <i class="fa fa-user"></i>
                        {{$default_address['name_family']}}
                    </div>
                @endif
                @if(isset($default_address['mobile']) || isset($default_address['tell']))
                    <div class="ltr p-2">
                        {{$default_address['mobile']}} - {{$default_address['tell']}}
                        <i class="fa fa-phone"></i>
                    </div>
                @endif
                @if(isset($default_address['post_code']))
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
            <span class="alert-danger p-4 rounded">آدرسی برای ارسال سفارش وجود ندارد! لطفاً یک آدرس جدید ثبت کنید.</span>
        </div>
    </div>
@endif

<div class="row mt-5">{{--ADD NEW ADDRESS--}}
    <div class="col-12">
        <button type="button"
                name="add-new-address-button"
                id="add-new-address-button"
                class="btn btn-outline-info w-100"
                data-toggle="collapse"
                data-target="#add-new-address-form"
                aria-expanded="false"
                aria-controls="collapseExample"
        >
            <i class="fa fa-plus"></i>
            ثبت آدرس جدید
        </button>
    </div>

    <div class="col-12 collapse @if($default_address==null || $errors->any()) show @endif" id="add-new-address-form">{{--create address form--}}
        <div class="card">
            <div class="card-header">
                <div class="text-center font-weight-bolder">
                    افزودن آدرس گیرنده
                </div>
            </div>
            <div class="card-body">
                {{--name_family, mobile, tell, province, city, address, post_code, status--}}
                <form action="{{ route('address.store') }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="name_family">
                                <i class="fa fa-asterisk text-danger"></i>
                                نام و نام خانوادگی
                            </label>
                            <input name="name_family"
                                   type="text"
                                   class="form-control @error('name_family') is-invalid @enderror"
                                   id="name_family"
                                   placeholder="نام و نام خانوادگی گیرنده مرسوله : محمد علیجانی"
                                   value="{{ old('name_family') }}"
                                   required
                                   autofocus
                                   autocomplete="off"
                            >
                            @include('partials.form_error',['input'=>'name_family'] )
                        </div>
                        <div class="form-group col-md-6">
                            <label for="mobile">
                                <i class="fa fa-asterisk text-danger"></i>
                                تلفن همراه
                            </label>
                            <input name="mobile"
                                   type="text"
                                   class="form-control text-center ltr @error('mobile') is-invalid @enderror"
                                   id="mobile"
                                   placeholder="09121231122"
                                   value="{{ old('mobile') }}"
                                   maxlength="11"
                                   required
                                   autocomplete="off"
                            >
                            @include('partials.form_error',['input'=>'mobile'] )
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tell">
                                تلفن ثابت
                            </label>
                            <input name="tell"
                                   type="number"
                                   class="form-control text-center ltr @error('tell') is-invalid @enderror"
                                   id="tell"
                                   placeholder="02122435465"
                                   value="{{ old('tell') }}"
                                   autocomplete="off"
                            >
                            @include('partials.form_error',['input'=>'tell'] )
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="province">
                                <i class="fa fa-asterisk text-danger"></i>
                                استان
                            </label>
                            <select name="province"
                                    class="form-control w-100 @error('province') is-invalid @enderror"
                                    id="province"
                                    required
                            >
                                <option value="" >لطفاً استان مقصد را انتخاب کنید</option>
                                @foreach($provinces as $province)
                                    <option value="{{$province->title}}">{{$province->title}}</option>
                                @endforeach
                            </select>
                            @include('partials.form_error',['input'=>'province'] )
                        </div>
                        <div class="form-group col-md-6">
                            <label for="city">
                                <i class="fa fa-asterisk text-danger"></i>
                                شهر
                            </label>
                            <select name="city"
                                    class="form-control @error('city') is-invalid @enderror"
                                    id="city"
                                    required
                            >
                                <option value="">ابتدا استان مقصد را انتخاب کنید</option>
                            </select>
                            @include('partials.form_error',['input'=>'city'] )
                        </div>
                        <div class="form-group col-md-12">
                            <label for="address">
                                <i class="fa fa-asterisk text-danger"></i>
                                آدرس
                            </label>
                            <textarea name="address"
                                      type="text"
                                      class="form-control @error('address') is-invalid @enderror"
                                      id="address"
                                      placeholder=" منطقه 1 شهرداری (گشت 16987)، لشگرک بزرگراه ارتش(لشگرک)، جاده تلو لواسان، پلاک 0"
                                      rows="5"
                                      required
                            >{{ old('address') }}</textarea>
                            @include('partials.form_error',['input'=>'address'] )
                        </div>
                        <div class="form-group col-md-12">
                            <label for="post_code">
                                کد پستی
                            </label>
                            <input name="post_code"
                                   type="number"
                                   class="form-control text-center @error('post_code') is-invalid @enderror"
                                   id="post_code"
                                   placeholder="1698713911"
                                   value="{{ old('post_code') }}"
                                   autocomplete="off"
                            >
                            @include('partials.form_error',['input'=>'post_code'] )
                        </div>
                    </div>
                    <div class="form-row d-flex justify-content-center p-4 mb-4">
                        <div class="form-check">
                            <input name="status"
                                   class="form-check-input"
                                   type="checkbox"
                                   id="status"
                                   @if(old('status'))
                                   checked
                                @endif
                            >
                            <label class="form-check-label pr-5" for="status">
                                تعیین بعنوان آدرس پیش فرض
                            </label>
                            @include('partials.form_error',['input'=>'status'] )
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">ثبت آدرس گیرنده</button>
                </form>

            </div>
        </div>
    </div>{{--./create address form--}}
</div>{{--./ADD NEW ADDRESS--}}
@if(count($addresses)>1)
    <div class="row mx-2 w-100">
        @foreach($addresses as $address)

            @if($address['id']===$default_address['id'])
                @continue
            @endif
            <div class="col-12 mt-4 border rounded p-4">
                <div class="row">
                    <div class="col-lg-10 col-12 mb-1">
                        <div class="other-addresses">
                            <div class="p-1">
                                {{$address['province']}} - {{$address['city']}}
                                - {{ $address['address'] }}
                            </div>
                            @if(isset($address['name_family']))
                                <div class="p-2">
                                    <i class="fa fa-user"></i>
                                    {{$address['name_family']}}
                                </div>
                            @endif
                            @if(isset($address['mobile']) || isset($address['tell']))
                                <div class="ltr p-2">
                                    {{$address['mobile']}} - {{$address['tell']}}
                                    <i class="fa fa-phone"></i>
                                </div>
                            @endif
                            @if(isset($address['post_code']))
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



@section('page-scripts')

    <script>
        function setDefault(id) {
            $.ajax({
                url: $("#set-default-" + id).attr('data-target'),
                type: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}',
                    '_method': 'PATCH',
                    'status': 'on',
                },
                success: function (result) {
                    location.reload();
                },
                error: function () {
                    location.reload();
                }

            })
        }

        /*delete an address from user address portal*/
        function del(id) {
            $.ajax({
                url: $("#del-" + id).attr('data-target'),
                type: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}',
                    '_method': 'DELETE',
                    'id': id,
                },
                success: function () {
                    location.reload();

                },
                error: function () {
                    location.reload();
                }
            });

        }

        $(document).ready(function () {
            let province = $('#province');
            let city = $('#city');

            province.on('change', function () {
                let title = province.val();
                if (title !== '') {
                    $('body').css({'opacity': '0.5'});
                    $.ajax({
                        url: "{{ route('province.cities') }}",
                        type: 'POST',
                        data: {
                            '_token': '{{csrf_token()}}',
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
                            $('body').css({'opacity': '1'});
                        },
                        error: function () {
                            $('body').css({'opacity': '1'});
                        },
                    });
                }
            });

        });
    </script>
@endsection
