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
                <form class="form" action="{{ route('footer-links.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">{{--TITLE--}}
                            <div class="form-group row">
                                <label for="title"
                                       class="col-form-label col-md-2 text-center">
                                    <i class="fa fa-asterisk text-danger"></i>
                                    عنوان لینک
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
                                           placeholder="لینک مرتبط با عنوان"
                                           value="{{ old('link') }}"
                                           required
                                    >
                                    @include('partials.form_error', ['input'=>'link'])
                                </div>
                            </div>
                        </div>{{--./LINK--}}

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

                        <div class="col-md-6">{{--ITEM--}}
                            <div class="form-group row">
                                <label for="item_id" class="col-form-label col-md-2 text-center">
                                    <i class=" fa fa-asterisk text-danger"></i>
                                    سر دسته
                                </label>
                                <div class="col-md-10">
                                    <select name="item_id"
                                            id="item_id"
                                            class="form-control @error('item_id') is-invalid @enderror"
                                            required
                                    >
                                        <option value="" disabled>انتخاب کنید...</option>
                                        @foreach($footer_items as $item)
                                            <option value="{{ $item->id }}"
                                                @if($item->id == old('item_id')) selected @endif
                                            >{{ $item->title }}</option>
                                        @endforeach

                                    </select>
                                    @include('partials.form_error', ['input'=>'item_id'])
                                </div>
                            </div>
                        </div>{{--ITEM--}}


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
