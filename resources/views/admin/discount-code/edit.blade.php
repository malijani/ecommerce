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
                <form class="form" action="{{ route('discount-codes.update', $discount_code->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div
                        class="form-group row ">
                        <div class="col-md-6">{{--CODE--}}
                            <div class="form-group row">
                                <label for="code"
                                       class="col-form-label col-md-2 text-center">
                                    <i class="fa fa-asterisk text-danger"></i>
                                    کد تخفیف
                                </label>
                                <div class="col-md-10">
                                    <input id="code"
                                           name="code"
                                           type="text"
                                           class="form-control @error('code') is-invalid @enderror"
                                           placeholder="کد تخفیف"
                                           minlength="2"
                                           maxlength="10"
                                           value="{{ old('code') ?? $discount_code->code }}"
                                           required
                                    >
                                    @include('partials.form_error', ['input'=>'code'])
                                </div>
                            </div>
                        </div>{{--./CODE--}}


                        <div class="col-md-6">{{--PERCENT--}}
                            <div class="form-group row">
                                <label for="percent"
                                       class="col-form-label col-md-2 text-center">
                                    <i class="fa fa-asterisk text-danger"></i>
                                    درصد تخفیف
                                </label>
                                <div class="col-md-10">
                                    <input id="percent"
                                           name="percent"
                                           type="number"
                                           class="form-control @error('percent') is-invalid @enderror"
                                           placeholder="10"
                                           min="1"
                                           max="100"
                                           value="{{ old('percent') ?? $discount_code->percent }}"
                                           required
                                    >
                                    @include('partials.form_error', ['input'=>'percent'])
                                </div>
                            </div>
                        </div>{{--./PERCENT--}}

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
                                        <option value="0" @if(old('status') ?? $discount_code->status ==0) selected @endif>غیر قابل استفاده</option>
                                        <option value="1" @if(old('status') ?? $discount_code->status ==1) selected @endif>قابل استفاده</option>
                                    </select>
                                    @include('partials.form_error', ['input'=>'status'])
                                </div>
                            </div>
                        </div>{{--./STATUS--}}
                    </div>{{--./MAIN FIELDS ROW--}}


                    <div class="form-group row my-5 text-center">

                        <button type="submit" class="btn btn-outline-primary form-control">
                            بروز رسانی
                        </button>

                    </div>
                </form>
                {{--./FORM END--}}
            </div>
        </div>
    </div>
    <!-- /.card -->
@endsection
