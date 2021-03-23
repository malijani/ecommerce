@extends('layouts.app_admin')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('adminrc/plugins/select2/select2.min.css') }}">
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card card-primary">

            <div class="card-header">
                <div class="card-title">{{ $title }}
                    <a href="{{ url()->previous() }}" role="button" class="pull-left text-white">
                        برگشت
                        <i class="fa fa-arrow-left"></i>
                    </a>
                </div>{{--./card-title--}}
            </div>{{--./card-header--}}
            <div class="card-body">
                <form action="{{ route('products.update', ['product'=>$product->id]) }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="row">
                        <div class="col-md-12">{{--TITLE : string -> max 100--}}
                            <div class="form-group row">
                                <label for="title" class="col-form-label col-md-2 text-center">
                                    <i class="fa fa-asterisk text-danger"></i>
                                    عنوان محصول
                                </label>
                                <div class="col-md-10">
                                    <input id="title"
                                           name="title"
                                           type="text"
                                           class="form-control @error('title') is-invalid @enderror"
                                           minlength="3"
                                           maxlength="100"
                                           placeholder=" نام محصول به فارسی : محصول با مشخصات دقیق "
                                           title="مقدار دهی الزامی"
                                           value="{{ $product->title }}"
                                           autocomplete="off"
                                           autofocus
                                           required
                                    >
                                    @include('partials.form_error', ['input'=>'title'])
                                </div>
                            </div>
                        </div>{{--./TITLE--}}

                        <div class="col-md-12">{{--TITLE_EN : string -> max 100--}}
                            <div class="form-group row">
                                <label for="title_en" class="col-md-2 col-form-label text-center">
                                    <i class="fa fa-asterisk text-danger"></i>
                                    عنوان لاتین محصول
                                </label>
                                <div class="col-md-10">
                                    <input
                                        name="title_en"
                                        type="text"
                                        class="form-control @error('title_en') is-invalid @enderror"
                                        id="title_en"
                                        placeholder="نام به انگلیسی : first-product"
                                        minlength="3"
                                        maxlength="100"
                                        title="مقدار دهی الزامی، عنوان انگلیسی بعنوان لینک در نظر گرفته خواهد شد"
                                        value="{{ $product->title_en }}"
                                        required
                                        autocomplete="off"
                                        dir="ltr"
                                    >
                                    @include('partials.form_error', ['input'=>'title_en'])
                                </div>
                            </div>
                        </div>{{--./TITLE_EN--}}

                        <div class="col-md-12">{{--PRICE : input number -> toman--}}
                            <div class="form-group row">
                                <label for="price" class="col-form-label col-md-2 text-center">
                                    <i class="fa fa-asterisk text-danger"></i>
                                    قیمت محصول
                                </label>
                                <div class="col-md-10">
                                    <input name="price"
                                           type="number"
                                           class="form-control @error('price') is-invalid @enderror"
                                           id="price"
                                           minlength="3"
                                           maxlength="100"
                                           placeholder=" قیمت محصول به تومان : 1000000 "
                                           title="مقدار دهی الزامی"
                                           value="{{ $product->price }}"
                                           autocomplete="off"
                                           required
                                    >
                                    @include('partials.form_error',['input'=>'price'] )
                                </div>
                            </div>
                        </div>{{--./PRICE--}}

                        <div class="col-md-12">{{--PRICE_SELF_BUY : input number -> toman--}}
                            <div class="form-group row">
                                <label for="price_self_buy" class="col-form-label col-md-2 text-center">
                                    <i class="fa fa-asterisk text-danger"></i>
                                    قیمت خرید
                                </label>
                                <div class="col-md-10">
                                    <input id="price_self_buy"
                                           name="price_self_buy"
                                           type="number"
                                           class="form-control @error('price_self_buy') is-invalid @enderror"
                                           minlength="3"
                                           maxlength="100"
                                           placeholder=" قیمت خرید به تومان : 1000000 "
                                           title="مقدار دهی الزامی"
                                           value="{{ $product->price_self_buy }}"
                                           autocomplete="off"
                                    >
                                    @include('partials.form_error',['input'=>'price_self_buy'] )
                                </div>
                            </div>
                        </div>{{--./PRICE_SELF_BUY--}}

                        <div class="col-md-12">{{--weight : input number -> gram--}}
                            <div class="form-group row">
                                <label for="weight" class="col-form-label col-md-2 text-center">
                                    <i class="fa fa-asterisk text-danger"></i>
                                    وزن محصول (گرم)
                                </label>
                                <div class="col-md-10">
                                    <input id="weight"
                                           name="weight"
                                           type="number"
                                           class="form-control @error('weight') is-invalid @enderror"
                                           minlength="2"
                                           maxlength="100"
                                           placeholder=" وزن محموله نهایی محصول جهت ارسال "
                                           title="مقدار دهی الزامی"
                                           value="{{ old('weight') ?? $product->weight }}"
                                           autocomplete="off"
                                    >
                                    @include('partials.form_error',['input'=>'weight'] )
                                </div>
                            </div>
                        </div>{{--./weight--}}


                        <div
                            class="col-md-6">{{--PRICE_TYPE : select -> 0 discount price, 1 definitive price, 2 ask price --}}
                            <div class="form-group row">
                                <label for="price_type" class="col-form-label col-md-4 text-center">
                                    نوع قیمت
                                </label>
                                <div class="col-md-8">
                                    <select id="price_type"
                                            name="price_type"
                                            title="نوع قیمت محصول در نمایش قیمت محصول و جذب مشتری اثر گذار است."
                                            class="form-control @error('price_type') is-invalid @enderror"
                                    >
                                        <option {{ $product->price_type ==0 ? 'selected' : '' }} value="0">دارای تخفیف
                                        </option>
                                        <option {{ $product->price_type ==1 ? 'selected' : '' }} value="1">قیمت
                                            نهایی(بدون
                                            تخفیف)
                                        </option>
                                        <option {{ $product->price_type ==2 ? 'selected' : '' }} value="2">قیمت
                                            متغیر(تماس
                                            برای
                                            پرسیدن قیمت)
                                        </option>
                                    </select>
                                    @include('partials.form_error', ['input'=>'price_type'])
                                </div>
                            </div>
                        </div>{{--./PRICE_TYPE--}}

                        <div class="col-md-6">{{--DISCOUNT_PERCENT : input number -> range : 0, 100 --}}
                            <div class="form-group row">
                                <label for="discount_percent" class="col-form-label col-md-4 text-center">
                                    <i class="fa fa-asterisk text-danger"></i>
                                    درصد تخفیف
                                </label>
                                <div class="col-md-8">
                                    <input id="discount_percent"
                                           name="discount_percent"
                                           type="number"
                                           class="form-control @error('discount_percent') is-invalid @enderror"
                                           minlength="0"
                                           maxlength="100"
                                           placeholder="درصد تخفیف"
                                           title="مقدار دهی الزامی"
                                           value="{{ $product->discount_percent }}"
                                           autocomplete="off"
                                    >
                                    @include('partials.form_error', ['input'=>'discount_percent'])
                                </div>
                            </div>
                        </div>{{--./DISCOUNT_PERCENT--}}

                        <div class="col-md-6">{{--ENTITY : input number--}}
                            <div class="form-group row">
                                <div class="col-md-4 text-center">
                                    <label for="entity" class="col-form-label">
                                        <i class="fa fa-asterisk text-danger"></i>
                                        تعداد
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input id="entity"
                                           name="entity"
                                           type="number"
                                           class="form-control @error('entity') is-invalid @enderror"
                                           minlength="0"
                                           maxlength="100"
                                           placeholder="موجودی محصول"
                                           title="مقدار دهی الزامی"
                                           value="{{ $product->entity }}"
                                           autocomplete="off"
                                           required
                                    >
                                    @include('partials.form_error', ['input'=>'entity'])
                                </div>
                            </div>
                        </div>{{--./ENTITY--}}

                        <div class="col-md-6">{{--ORIGIN : select -> 1 original, 2 second class, 3 third class--}}
                            <div
                                class="form-group row">
                                <div class="col-md-4 text-center">
                                    <label for="origin" class="col-form-label">کیفیت محصول</label>
                                </div>
                                <div class="col-md-8">
                                    <select id="origin"
                                            name="origin"
                                            title="با تعیین درجه بندی کیفیت محصول، مشتری دید بهتری نسبت به خرید محصول پیدا می‌کند."
                                            class="form-control @error('origin') is-invalid @enderror"
                                    >
                                        <option {{ $product->origin ==1 ? 'selected' : '' }} value="1">اورجینال</option>
                                        <option {{ $product->origin ==2 ? 'selected' : '' }} value="2">درجه ۲</option>
                                        <option {{ $product->origin ==3 ? 'selected' : '' }} value="3">درجه ۳</option>
                                    </select>
                                    @include('partials.form_error', ['input'=>'origin'])
                                </div>
                            </div>
                        </div>{{--./ORIGIN--}}

                        <div class="col-md-6">{{--DELIVER : select -> 0 express delivery, 1 long time delivery--}}
                            <div class="form-group row">
                                <div class="col-md-4 text-center">
                                    <label for="deliver" class="col-form-label">
                                        نحوه ارسال
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <select id="deliver"
                                            name="deliver"
                                            title="روش ارسال محصول به مشتری کمک میکند تا برای مدت زمان ارسال محصول تصمیم گیری کند."
                                            class="form-control @error('deliver') is-invalid @enderror"
                                    >
                                        <option {{ $product->deliver ==0 ? 'selected' : '' }} value="0">فوری</option>
                                        <option {{ $product->deliver ==1 ? 'selected' : '' }} value="1">زمان دار
                                        </option>
                                    </select>
                                    @include('partials.form_error', ['input'=>'deliver'])
                                </div>
                            </div>
                        </div>{{--./DELIVER--}}

                        <div class="col-md-6">{{--WARRANTY : select -> 0 without warranty, 1 with warranty--}}
                            <div class="form-group row">
                                <div class="col-md-4 text-center">
                                    <label for="warranty" class="col-form-label">
                                        گارانتی
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <select id="warranty"
                                            name="warranty"
                                            title="نوع گارانتی به مشتری کمک میکند تا در مورد ارجاع محصول و خرید نهایی تصمیم گیری کند"
                                            class="form-control @error('warranty') is-invalid @enderror"
                                    >
                                        <option {{ $product->warranty ==0 ? 'selected' : '' }} value="0">بدون گارانتی
                                        </option>
                                        <option {{ $product->warranty ==1 ? 'selected' : '' }} value="1">دارای گارانتی
                                        </option>
                                    </select>
                                    @include('partials.form_error', ['input'=>'warranty'])
                                </div>
                            </div>
                        </div>{{--./WARRANTY--}}

                        <div class="col-md-6">{{--CATEGORY_ID : number--}}
                            <div class="form-group row">
                                <div class="col-md-4 text-center">
                                    <label for="category_id" class="col-form-label">دسته بندی</label>
                                </div>
                                <div class="col-md-8">
                                    <select id="category_id"
                                            name="category_id"
                                            class="select2 form-control d-block @error('category_id') is-invalid @enderror"
                                            title="با انتخاب دسته بندی، مقاله شما از طریق دسته بندی منتخب قابل دسترسی خواهد بود."
                                    >

                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                    @if(!is_null(old('category_id')) && old('category_id') == $category->id)
                                                    selected
                                                @endif
                                            >{{ '+>'.' '.$category->title }}</option>
                                            @if($category->childrenRecursive->count())
                                                @include('admin.product.partials.create_form_category_child', ['children'=>$category->childrenRecursive,'old_selected_category'=>$product->category_id ,'level'=>1])
                                            @endif
                                        @endforeach
                                    </select>
                                    @include('partials.form_error', ['input'=>'category_id'])
                                </div>
                            </div>
                        </div>{{--./CATEGORY_ID--}}

                        <div class="col-md-6">{{--BRAND_ID : number--}}
                            <div class="form-group row">
                                <div class="col-md-4 text-center">
                                    <label for="brand_id" class="col-form-label">
                                        برند
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <select id="brand_id"
                                            name="brand_id"
                                            title="بخش بندی محصولات یک برند به دسترسی هرچه سریعتر کاربر به محصولات کمک فراوانی میکند."
                                            class="select2 form-control @error('brand_id') is-invalid @enderror"
                                    >
                                        {{--                                 :CONSTRAINT ERROR:       <option {{ old('brand_id')==0 ? 'selected' : '' }} value="0">بدون برند</option> --}}
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}"
                                                    @if($product->brand_id==$brand->id)
                                                    selected
                                                @endif
                                            >{{ $brand->title }}</option>
                                        @endforeach
                                    </select>
                                    @include('partials.form_error', ['input'=>'brand_id'])
                                </div>
                            </div>
                        </div>{{--./BRAND_ID--}}

                        <div class="col-md-6">{{--STATUS : number -> 1 show, 0 don't show--}}
                            <div class="form-group row">
                                <div class="col-md-4 text-center">
                                    <label for="status" class="col-form-label">
                                        وضعیت محصول
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <select id="status"
                                            name="status"
                                            title="با انتخاب نمایش، محصول شما قابل خریداری و نمایش خواهد بود"
                                            class="form-control @error('status') is-invalid @enderror"
                                    >
                                        <option {{ $product->status ==1 ? 'selected' : '' }} value="1">نمایش</option>
                                        <option {{ $product->status ==0 ? 'selected' : '' }} value="0">عدم نمایش
                                        </option>
                                    </select>
                                    @include('partials.form_error', ['input'=>'status'])
                                </div>
                            </div>
                        </div>{{--./STATUS--}}

                        <div class="col-md-6">{{--COLOR : hex color picker : #ffffff--}}
                            <div class="form-group row">
                                <div class="col-md-4 text-center">
                                    <label for="color" class="col-form-label">
                                        رنگ محصول
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input id="color"
                                           name="color"
                                           class="form-control @error('color') is-invalid @enderror"
                                           type="color"
                                           value="{{ $product->color ?? '#ffffff' }}"
                                    >
                                    @include('partials.form_error', ['input'=>'color'])
                                </div>
                            </div>
                        </div>{{--./COLOR--}}

                        <div class="col-md-12">{{--PICTURES : one to many relation (file, title)--}}
                            <div class="col-12">{{--HR--}}
                                <hr class="w-50">
                            </div>{{--./HR--}}
                            <div class="row justify-content-center">{{--HEADER & DESCRIPTION--}}
                                <div class="col-lg-8">
                                    <div class="text-center">
                                        <h3 class="font-weight-light">تصاویر</h3>
                                    </div>
                                    <div class="callout callout-info text-info text-center">
                                        <span class="">* هر محصول حداقل باید دارای یک تصویر باشد.</span><br>
                                        <span class="">* هر تصویر حداکثر دارای حجم دو مگابایت باشد.</span><br>
                                        {{--                                    <span class="">* اولین تصویر بعنوان تصویر منتخب و فعال نمایش داده خواهد شد.</span>--}}
                                    </div>
                                </div>
                            </div>{{--./HEADER & DESCRIPTION--}}
                            <div class="col-12">{{--FILE FIELDS--}}
                                <div class="row-file">
                                    <div>
                                        {{--DEFAULT PIC IS A PRETTY WAY I THINK--}}
                                        <input type="hidden"
                                               name="show_default" id="show_default"
                                               class="@error('show_default') is-invalid @enderror"
                                               value="{{old('show_default')}}"
                                        >
                                        @include('partials.form_error', ['input'=>'show_default'])
                                    </div>
                                    <div>
                                        {{--SAVE AND PASS CHANGES TO CONTROLLER--}}
                                        <input type="hidden" name="changed_titles" id="changed_titles"
                                               class="@error('changed_titles') is-invalid @enderror"
                                               value="{{old('changed_titles')}}"
                                        >
                                        @include('partials.form_error', ['input'=>'changed_titles'])
                                        <input type="hidden" name="changed_files" id="changed_files"
                                               class="@error('changed_files') is-invalid @enderror"
                                               value="{{old('changed_files')}}"
                                        >
                                        @include('partials.form_error', ['input'=>'changed_files'])
                                    </div>
                                    <div class="file-0">
                                        <div
                                            class="form-group row align-items-center align-middle">{{--MAIN FIELDS ROW--}}

                                            <div class="col-md-5">{{--FILE>TITLE--}}
                                                <div class="form-group row">
                                                    <label for="file[title][0]"
                                                           class="col-form-label col-md-3 text-center">
                                                        <i class="fa fa-asterisk text-danger"></i>
                                                        عنوان
                                                    </label>
                                                    <div class="col-md-9">
                                                        <input id="file[title][0]"
                                                               name="file[title][0]"
                                                               type="text"
                                                               class="form-control @error('file.title.0') is-invalid @enderror"
                                                               title="مقدار دهی الزامی"
                                                               minlength="2"
                                                               maxlength="100"
                                                               value="{{ $product->files->first()->title }}"
                                                               required
                                                               onclick="updateRow(this, '#changed_titles');"
                                                        >
                                                        @include('partials.form_error', ['input'=>'file.title.0'])
                                                    </div>
                                                </div>
                                            </div>{{--./FILE>TITLE--}}

                                            <div class="col-md-5 ">{{--FILE>FILE--}}
                                                <div class="form-group row">
                                                    <label for="file[file][0]"
                                                           class="col-form-label col-md-3 text-center">
                                                        <i class="fa fa-asterisk text-danger"></i>
                                                        تصویر
                                                    </label>
                                                    <div class="col-md-9">
                                                        <input id="file[file][0]"
                                                               name="file[file][0]"
                                                               type="file"
                                                               class="form-control file-input @error('file.file.0') is-invalid @enderror"
                                                               onchange="showImage(this);updateRow(this, '#changed_files');"
                                                               accept=".jpg,.jpeg,.png,.gif"
                                                        >
                                                        @include('partials.form_error', ['input'=>'file.file.0'])
                                                    </div>
                                                </div>
                                            </div>{{--./FILE>FILE--}}


                                            <div class="col-md-2">{{--PREVIEW IMAGE--}}
                                                <div class="form-group row">
                                                    <div class="col-md-12 text-center">{{--IMG--}}
                                                        <img src="{{asset($product->files->first()->link)}}"
                                                             alt="تصویر محصول"
                                                             class="img-0 img rounded align-middle image-checkable"
                                                             id="img-0"
                                                             width="100vw"
                                                             height="100vh"
                                                             onmouseover="configImgCheckbox(this.id)"
                                                        >
                                                    </div>{{--./IMG--}}
                                                </div>
                                            </div>{{--./PREVIEW IMAGE--}}

                                        </div>{{--./MAIN FIELDS ROW--}}
                                    </div>{{--./FILE-0--}}

                                    {{--########################OLDS##############################--}}

                                    @if($product->files->count() > 1){{--GENERATE OLD FILE FIELDS--}}
                                    @foreach($product->files as $file)
                                        @if($loop->first)
                                            @continue
                                        @endif

                                        <div class="file-{{ $loop->index }}">
                                            <div
                                                class="form-group row align-items-center align-middle">{{--MAIN FIELDS ROW--}}

                                                <div class="col-md-5">{{--FILE>TITLE--}}
                                                    <div class="form-group row">
                                                        <label for="file[title][{{$loop->index}}]"
                                                               class="col-form-label col-md-3 text-center">
                                                            <i class="fa fa-asterisk text-danger"></i>
                                                            عنوان
                                                        </label>
                                                        <div class="col-md-9">
                                                            <input id="file[title][{{$loop->index}}]"
                                                                   name="file[title][{{$loop->index}}]"
                                                                   type="text"
                                                                   class="form-control @error('file.title.'.$loop->index) is-invalid @enderror"
                                                                   title="مقدار دهی الزامی"
                                                                   minlength="2"
                                                                   maxlength="100"
                                                                   value="{{ $product->files[$loop->index]->title }}"
                                                                   required
                                                                   onclick="updateRow(this, '#changed_titles');"
                                                            >
                                                            @include('partials.form_error', ['input'=>'file.title.'.$loop->index])
                                                        </div>
                                                    </div>
                                                </div>{{--./FILE>TITLE--}}

                                                <div class="col-md-5 ">{{--FILE>FILE--}}
                                                    <div class="form-group row">
                                                        <label for="file[file][{{$loop->index}}]"
                                                               class="col-form-label col-md-3 text-center">
                                                            <i class="fa fa-asterisk text-danger"></i>
                                                            تصویر
                                                        </label>
                                                        <div class="col-md-9">
                                                            <input id="file[file][{{$loop->index}}]"
                                                                   name="file[file][{{$loop->index}}]"
                                                                   type="file"
                                                                   class="form-control file-input @error('file.file.'.$loop->index) is-invalid @enderror"
                                                                   onchange="showImage(this);updateRow(this, '#changed_files');"
                                                                   accept=".jpg,.jpeg,.png,.gif"
                                                            >
                                                            @include('partials.form_error', ['input'=>'file.file.'.$loop->index])
                                                        </div>
                                                    </div>
                                                </div>{{--./FILE>FILE--}}

                                                <div class="col-md-2">{{--PREVIEW IMAGE--}}
                                                    <div class="form-group row">
                                                        <div class="col-md-12 text-center">{{--IMG--}}
                                                            <img src="{{asset($product->files[$loop->index]->link)}}"
                                                                 alt="تصویر محصول"
                                                                 class="img-{{$loop->index}} img rounded align-middle image-checkable"
                                                                 id="img-{{$loop->index}}"
                                                                 width="100vw"
                                                                 height="100vh"
                                                                 onmouseover="configImgCheckbox(this.id);"
                                                            >
                                                            <div class="form-check">
                                                                <input class="form-check-input"
                                                                       name="option[{{$loop->index}}]"
                                                                       type="radio" value="d-{{$loop->index}}"
                                                                       id="delete-img-{{$loop->index}}"
                                                                    {{--                                                                    @if($product->files[$loop->index]->status==="2")--}}
                                                                    {{--                                                                       disabled--}}
                                                                    {{--                                                                    @endif--}}

                                                                >
                                                                <label class="form-check-label"
                                                                       for="delete-img-{{$loop->index}}">
                                                                    حذف
                                                                </label>
                                                            </div>
                                                            <div class="form-check">

                                                                <input class="form-check-input"
                                                                       name="option[{{$loop->index}}]"
                                                                       type="radio" value="h-{{$loop->index}}"
                                                                       id="hide-img-{{$loop->index}}"
                                                                       @if($product->files[$loop->index]->status == "0")
                                                                       checked
                                                                    @endif
                                                                    {{--                                                                        @if($product->files[$loop->index]->status==="2")--}}
                                                                    {{--                                                                           disabled--}}
                                                                    {{--                                                                        @endif--}}
                                                                >
                                                                <label class="form-check-label"
                                                                       for="hide-img-{{$loop->index}}">
                                                                    نمایش نده
                                                                </label>

                                                            </div>
                                                        </div>{{--./IMG--}}
                                                    </div>
                                                </div>{{--./PREVIEW IMAGE--}}

                                            </div>{{--./MAIN FIELDS ROW--}}
                                        </div>{{--./FILE-X--}}
                                    @endforeach
                                    @endif{{--END OLD FILE FIELDS GENERATION--}}

                                </div>
                            </div>{{--./FILE FIELDS--}}

                            <div class="col-12">{{--ADD/REMOVE BUTTONS--}}
                                <div class="text-center">
                                    <button type="button" class="add-row btn btn-success btn-sm">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                    <button type="button" class="del-row btn btn-danger btn-sm">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <div class="text-center py-3">
                                    <p class="alert alert-warning show_default_status"></p>
                                </div>
                            </div>{{--./ADD+REMOVE BUTTONS--}}

                            <div class="col-12">{{--HR--}}
                                <hr class="w-50">
                            </div>{{--./HR--}}
                        </div>{{--./PICTURES--}}


                        <div class="col-md-12">{{--Attributes : many to many relation (attribute, value)--}}
                            <div class="col-12">{{--HR--}}
                                <hr class="w-50">
                            </div>{{--./HR--}}

                            <div class="row justify-content-center">{{--HEADER & DESCRIPTION--}}
                                <div class="col-lg-8">
                                    <div class="text-center">
                                        <h3 class="font-weight-light">ویژگی ها</h3>
                                    </div>
                                    <div class="callout callout-info text-info text-center">
                                        <span
                                            class="">* محصولات با قیمت یکسان اما خصوصیات متفاوتی مانند طعم، رنگ و...</span><br>
                                        <span class="">* هر محصول می‌تواند داری یک یا چند ویژگی باشد.</span><br>
                                        <span class="">* این ویژگی ها در تغییر قیمت محصول نقشی ندارند.</span>
                                    </div>
                                </div>
                            </div>{{--./HEADER & DESCRIPTION--}}

                            <div class="col-12">{{--ATTRIBUTE FIELDS--}}
                                <div id="row-attribute">

                                    @if(!is_null($product->attrs)){{--GENERATE OLD ATTRIBUTE FIELDS--}}
                                    @foreach($product->attrs as $attr)
                                        {{--GENERATE OLD ATTRIBUTES--}}
                                        <div class="attribute-{{$loop->index}}">
                                            <div
                                                class="form-group row align-items-center align-middle">{{--MAIN FIELDS ROW--}}

                                                <div class="col-md-6">{{--ATTRIBUTE>TITLE--}}
                                                    <div class="form-group row">
                                                        <label for="attribute-id-{{$loop->index}}"
                                                               class="col-form-label col-md-3 text-center">
                                                            <i class="fa fa-asterisk text-danger"></i>
                                                            ویژگی
                                                        </label>
                                                        <div class="col-md-9">
                                                            <select id="attribute-id-{{$loop->index}}"
                                                                    name="attribute[id][{{$loop->index}}]"
                                                                    class="select2 form-control d-block @error('attribute.id.'.$loop->index) is-invalid @enderror"
                                                                    title="این ویژگی ها در ثبت سفارش های شخصی سازی شده به مشتری کمک میکند!"
                                                            >
                                                                @foreach($attributes as $option_attr)
                                                                    <option value="{{ $option_attr->id }}"
                                                                            @if($option_attr->id == $attr->id)
                                                                            selected
                                                                        @endif

                                                                    >{{ $option_attr->title }}</option>
                                                                @endforeach
                                                            </select>
                                                            @include('partials.form_error', ['input'=>'attribute.id.'.$loop->index])
                                                        </div>
                                                    </div>
                                                </div>{{--./ATTRIBUTE>TITLE--}}

                                                <div class="col-md-6">{{--ATTRIBUTE>VALUE--}}
                                                    <div class="form-group row">
                                                        <label for="attribute-value-{{$loop->index}}"
                                                               class="col-form-label col-md-3 text-center">
                                                            <i class="fa fa-asterisk text-danger"></i>
                                                            مقدار
                                                        </label>
                                                        <div class="col-md-9">
                                                            <input id="attribute-value-{{$loop->index}}"
                                                                   name="attribute[value][{{$loop->index}}]"
                                                                   type="text"
                                                                   class="form-control @error('attribute.value.'.$loop->index) is-invalid @enderror"
                                                                   title="مقدار دهی الزامی"
                                                                   minlength="2"
                                                                   maxlength="70"
                                                                   value="{{ $attr->pivot->attr_value }}"
                                                                   required
                                                            >
                                                            @include('partials.form_error', ['input'=>'attribute.value.'.$loop->index])
                                                        </div>
                                                    </div>
                                                </div>{{--./ATTRIBUTE>VALUE--}}

                                            </div>{{--./MAIN FIELDS ROW--}}
                                        </div>{{--./ATTRIBUTE-0--}}
                                    @endforeach
                                    @endif{{--END OLD FILE FIELDS GENERATION--}}


                                    {{--!!DYNAMIC FIELDS GOES HERE!!--}}
                                    {{--########################OLDS##############################--}}
                                    @if(!is_null(old('attribute'))){{--GENERATE OLD ATTRIBUTE FIELDS--}}
                                    @foreach(old('attribute.value') as $attribute_value)
                                        {{--GENERATE OLD ATTRIBUTES--}}
                                        <div class="attribute-{{$loop->index}}">
                                            <div
                                                class="form-group row align-items-center align-middle">{{--MAIN FIELDS ROW--}}

                                                <div class="col-md-6">{{--ATTRIBUTE>TITLE--}}
                                                    <div class="form-group row">
                                                        <label for="attribute-id-{{$loop->index}}"
                                                               class="col-form-label col-md-3 text-center">
                                                            <i class="fa fa-asterisk text-danger"></i>
                                                            ویژگی
                                                        </label>
                                                        <div class="col-md-9">
                                                            <select id="attribute-id-{{$loop->index}}"
                                                                    name="attribute[id][{{$loop->index}}]"
                                                                    class="select2 form-control d-block @error('attribute.id.'.$loop->index) is-invalid @enderror"
                                                                    title="این ویژگی ها در ثبت سفارش های شخصی سازی شده به مشتری کمک میکند!"
                                                            >
                                                                @foreach($attributes as $attr)
                                                                    <option value="{{ $attr->id }}"
                                                                            @if($attr->id == old('attribute.id.'.$loop->parent->index))
                                                                            selected
                                                                        @endif

                                                                    >{{ $attr->title }}</option>
                                                                @endforeach
                                                            </select>
                                                            @include('partials.form_error', ['input'=>'attribute.id.'.$loop->index])
                                                        </div>
                                                    </div>
                                                </div>{{--./ATTRIBUTE>TITLE--}}

                                                <div class="col-md-6">{{--ATTRIBUTE>VALUE--}}
                                                    <div class="form-group row">
                                                        <label for="attribute-value-{{$loop->index}}"
                                                               class="col-form-label col-md-3 text-center">
                                                            <i class="fa fa-asterisk text-danger"></i>
                                                            مقدار
                                                        </label>
                                                        <div class="col-md-9">
                                                            <input id="attribute-value-{{$loop->index}}"
                                                                   name="attribute[value][{{$loop->index}}]"
                                                                   type="text"
                                                                   class="form-control @error('attribute.value.'.$loop->index) is-invalid @enderror"
                                                                   title="مقدار دهی الزامی"
                                                                   minlength="2"
                                                                   maxlength="70"
                                                                   value="{{ old('attribute.value.'.$loop->index) }}"
                                                                   required
                                                            >
                                                            @include('partials.form_error', ['input'=>'attribute.value.'.$loop->index])
                                                        </div>
                                                    </div>
                                                </div>{{--./ATTRIBUTE>VALUE--}}

                                            </div>{{--./MAIN FIELDS ROW--}}
                                        </div>{{--./ATTRIBUTE-0--}}
                                    @endforeach
                                    @endif{{--END OLD FILE FIELDS GENERATION--}}

                                </div>
                            </div>{{--./ATTRIBUTE FIELDS--}}

                            <div class="col-12">{{--ADD/REMOVE BUTTONS--}}
                                <div class="text-center">
                                    <button type="button" id="add-attribute-field" class="btn btn-success btn-sm">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                    <button type="button" id="del-attribute-field" class=" btn btn-danger btn-sm">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>{{--./ADD+REMOVE BUTTONS--}}

                            <div class="col-12">{{--HR--}}
                                <hr class="w-50">
                            </div>{{--./HR--}}
                        </div>{{--./ATTRIBUTES--}}

                        <div class="col-md-6">{{--BEFORE : number--}}
                            <div class="form-group row">
                                <div class="col-md-4 text-center">
                                    <label for="before" class="col-form-label">محصول قبلی</label>
                                </div>
                                <div class="col-md-8">
                                    <select
                                        name="before"
                                        id="before"
                                        title="با انتخاب محصول قبلی مسیر روشنی برای کاربر و سئو تعیین کنید."
                                        class="select2 form-control @error('before') is-invalid @enderror"
                                    >
                                        <option {{ old('before')==0 ? 'selected' : '' }} value="0">بدون محصول قبلی
                                        </option>
                                        @foreach($products as $before_product)
                                            <option value="{{ $before_product->id }}"
                                                    @if($product->before==$before_product->id)
                                                    selected
                                                @endif
                                            >{{ $before_product->title }}</option>
                                        @endforeach
                                    </select>
                                    @include('partials.form_error', ['input'=>'before'])
                                </div>
                            </div>
                        </div>{{--./BEFORE--}}

                        <div class="col-md-6">{{--AFTER : number--}}
                            <div class="form-group row">
                                <div class="col-md-4 text-center">
                                    <label for="after" class="col-form-label">محصول بعدی</label>
                                </div>
                                <div class="col-md-8">
                                    <select
                                        name="after"
                                        id="after"
                                        title="با انتخاب محصول بعدی مسیر روشنی برای کاربر و سئو تعیین کنید."
                                        class="select2 form-control @error('after') is-invalid @enderror"
                                    >
                                        <option {{ old('after')==0 ? 'selected' : '' }} value="0">بدون محصول بعدی
                                        </option>
                                        @foreach($products as $after_product)
                                            <option value="{{ $after_product->id }}"
                                                    @if($product->after==$after_product->id)
                                                    selected
                                                @endif
                                            >{{ $after_product->title }}</option>
                                        @endforeach
                                    </select>
                                    @include('partials.form_error', ['input'=>'after'])
                                </div>
                            </div>
                        </div>{{--./AFTER--}}

                        <div class="col-md-12">{{--KEYWORDS : string -> max 70--}}
                            <div class="form-group">
                                <div class="">
                                    <label for="keywords" class="col-form-label">
                                        (سئو) کلمات کلیدی
                                    </label>
                                </div>
                                <div class="">
                                    <input id="keywords"
                                           type="text"
                                           name="keywords"
                                           class="form-control @error('keywords') is-invalid @enderror"
                                           minlength="3"
                                           maxlength="70"
                                           placeholder="مقاله، عنوان مقاله، دلیل ایجاد"
                                           title="برای سئو بهتر این موارد تعیین شوند"
                                           value="{{ $product->keywords }}"
                                    >
                                    @include('partials.form_error', ['input'=>'keywords'])
                                </div>
                            </div>
                        </div>{{--./KEYWORDS--}}

                        <div class="col-md-12">{{--DESCRIPTION : string -> max 70--}}
                            <div class="form-group">
                                <div class="">
                                    <label for="description" class="col-form-label">
                                        (سئو) توضیحات کلمات کلیدی
                                    </label>
                                </div>
                                <div class="">
                                    <input id="description"
                                           name="description"
                                           type="text"
                                           class="form-control @error('description') is-invalid @enderror"
                                           placeholder="این نمونه تستی برای توضیحات سئو درج شده، چگونه مقاله تستی را از لحاظ سئو پر بار کنیم؟"
                                           minlength="10"
                                           maxlength="255"
                                           title="توضیحات کلمات کلیدی را به صورت جمله های مرتبط پر جست و جو وارد کنید"
                                           value="{{ $product->description }}"
                                    >
                                    @include('partials.form_error', ['input'=>'description'])
                                </div>
                            </div>
                        </div>{{--./DESCRIPTION--}}

                        <div class="col-md-12">{{--SHORT_TEXT : string--}}
                            <div class="form-group">
                                <div class="">
                                    <label for="short_text" class="col-form-label">
                                        متن کوتاه محصول
                                    </label>
                                </div>
                                <div class="">
                                    <input id="short_text"
                                           type="text"
                                           name="short_text"
                                           class="form-control @error('short_text') is-invalid @enderror"
                                           minlength="3"
                                           maxlength="250"
                                           placeholder="لورم ایپسوم ..."
                                           title="برای نمایی از متن کوتاه مقاله این مورد را تعیین نمایید"
                                           value="{{ $product->short_text }}"
                                    >
                                    @include('partials.form_error', ['input'=>'short_text'])
                                </div>
                            </div>
                        </div>{{--./SHORT_TEXT--}}

                        <div class="col-md-12">{{--LONG_TEXT : text--}}
                            <div class="form-group">
                                <div class="">
                                    <label for="long_text">
                                        <i class="fa fa-asterisk text-danger"></i>
                                        توضیحات اجمالی محصول
                                    </label>
                                </div>
                                <div class="">
                            <textarea id="long_text"
                                      name="long_text"
                                      rows="10"
                                      class="form-control @error('long_text') is-invalid @enderror"
                                      placeholder="متن محصول...."
                                      dir="rtl"
                                      title="مقدار دهی الزامی"
                            >{{ $product->long_text }}</textarea>
                                    @include('partials.form_error', ['input'=>'long_text'])
                                </div>
                            </div>
                        </div>{{--./LONG_TEXT--}}
                    </div>

                    <button type="submit" class="btn btn-block btn-outline-success form-control">ثبت</button>
                </form>
            </div>{{--./card-body--}}
        </div>{{--./card--}}
    </div>{{--./col--}}
@endsection

@section('page-scripts')

    <script src="{{ asset('adminrc/plugins/ckeditor-full/ckeditor.js') }}"></script>
    <script src="{{ asset('adminrc/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('adminrc/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('adminrc/plugins/img-checkbox/jquery.imgcheckbox.js') }}"></script>

    <script>

        // Configure select2
        function configSelect2(selectClass) {
            $(selectClass).select2({
                dir: "rtl",
            });
        }

        function updateRow(el, inputId) {
            // Create a pretty string for php processing!
            let input = $(inputId);
            // console.log(el.getAttribute('name').slice(-2)[0]);
            let index = el.getAttribute('name').slice(-2)[0];
            // append ,X to changed_titles
            if (!input.val().includes(index)) {
                if (input.val() !== '') {
                    input.val(input.val() + ',' + index);
                } else {
                    input.val(index);
                }
            }
            // console.log(inputId + " : " + input.val());
        }

        function configImgCheckbox(imageId) {
            // Image is checkable to set as default picture
            $("#" + imageId).imgCheckbox({
                radio: true,
                preselect: false,
                canDeselect: true,
                checkMarkSize: "40px",
                checkMarkPosition: 'top-left',
                checkMarkImage: "{{ asset('images/asset/checked.png') }}",
                addToForm: false,

                onclick: function (el) {
                    let input = $("#show_default");
                    let status = $('.show_default_status')
                    let index = imageId.slice(-1);


                    if (input.val() !== '') {
                        //Uncheck other items => its radio? : item's are generated dynamically!
                        $("#img-" + input.val()).parent().removeClass('imgChked');
                        let delete_last = $("#delete-img-" + input.val());
                        let hide_last = $("#hide-img-" + input.val());
                        delete_last.prop('disabled', false);
                        hide_last.prop('disabled', false);
                        input.val('');
                    }

                    let isChecked = el.hasClass("imgChked");
                    /*var indexing = $(el.children()[0]).attr('id');*/
                    if (isChecked === true) {
                        let delete_this = $("#delete-img-" + index);
                        let hide_this = $("#hide-img-" + index);
                        delete_this.prop('disabled', true);
                        hide_this.prop('disabled', true);
                        input.val(index);
                        status.hide();

                    } else {
                        input.val('');
                        status.show();
                    }


                }
            });
        }


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

            readURL(element, $('.img-' + id(element)));
        }

        // Show file name when input is changed
        $(".custom-file-input").on("change", function () {
            let fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        $(document).ready(function () {


            // CKEDITOR CONFIGURATION
            CKEDITOR.replace('long_text', {
                height: 400,
                baseFloatZIndex: 10005,
                contentsLangDirection: 'rtl',
                direction: 'rtl',
                contentsLanguage: 'fa',
                content: 'fa',
                language: 'fa',

                filebrowserImageBrowseUrl: '{{route('unisharp.lfm.show')}}',
                filebrowserImageUploadUrl: '{{route('unisharp.lfm.upload', ['type'=>'Images', '_token'=>csrf_token()])}}',
                filebrowserBrowseUrl: '{{route('unisharp.lfm.show', ['type'=>'Files'])}}',
                filebrowserUploadUrl: '{{route('unisharp.lfm.upload', ['type'=>'Files', '_token'=>csrf_token()])}}',


                font_names: 'Vazir;' +
                    'Arial/Arial, Helvetica, sans-serif;' +
                    'Comic Sans MS/Comic Sans MS, cursive;' +
                    'Courier New/Courier New, Courier, monospace;' +
                    'Georgia/Georgia, serif;' +
                    'Lucida Sans Unicode/Lucida Sans Unicode, Lucida Grande, sans-serif;' +
                    'Tahoma/Tahoma, Geneva, sans-serif;' +
                    'Times New Roman/Times New Roman, Times, serif;' +
                    'Trebuchet MS/Trebuchet MS, Helvetica, sans-serif;' +
                    'Verdana/Verdana, Geneva, sans-serif',
                font_defaultLabel: 'Vazir',
                forcePasteAsPlainText: false,
                forceEnterMode: true,
                editorplaceholder: 'متن مقاله...',
            });

            configSelect2('.select2');

            // Show warning if default image isn't selected
            let status = $(".show_default_status");
            if ($("#show_default").val() !== '') {
                status.hide();
            } else {
                status.show();
                status.text('لطفاً یک تصویر را بعنوان تصویر پیشفرض محصول انتخاب نمایید!');
            }

            // Toggle check/uncheck radio buttons
            $('input[type="radio"]').on('click', function () {
                // var id = this.id;
                if ($(this).data('checked')) {
                    $(this).prop('checked', false);
                    $(this).data('checked', false);
                } else {
                    $(this).data('checked', true);
                }
                // $(':radio[id=' + id + ']').not(this).data('checked', false);
            });


            /*DYNAMIC FILE INPUT*/
            let max_fields = 5;
            let wrapper = $(".row-file");
            let add_button = $(".add-row");
            let del_button = $(".del-row")
            // Get last item count by extracting file-X class and removing file- to get x
            let wrapper_last_child_classes = wrapper.children().last().attr('class').split(' ');
            let x = wrapper_last_child_classes['0'].substr(-1, wrapper_last_child_classes['0'].length);
            // Add a new field for file upload
            add_button.click(function (e) {
                e.preventDefault();
                if (x < max_fields) {
                    ++x;
                    wrapper.append(
                        '   <div class="file-' + x + '">  ' +
                        '      <div class="form-group row align-items-center align-middle">  ' +
                        '         {{--MAIN FIELDS ROW--}}  ' +
                        '         <div class="col-md-5">  ' +
                        '            {{--FILE>TITLE--}}  ' +
                        '            <div class="form-group row">  ' +
                        '               <label for="file[title][' + x + ']"  ' +
                        '                  class="col-form-label col-md-3 text-center">  ' +
                        '               <i class="fa fa-asterisk text-danger"></i>  ' +
                        '               عنوان  ' +
                        '               </label>  ' +
                        '               <div class="col-md-9">  ' +
                        '                  <input  ' +
                        '                     id="file[title][' + x + ']"  ' +
                        '                     name="file[title][' + x + ']"  ' +
                        '                     type="text"  ' +
                        '                     class="form-control"  ' +
                        '                     title="مقدار دهی الزامی"  ' +
                        '                     minlength="2"  ' +
                        '                     maxlength="100"  ' +
                        '                     >  ' +
                        '               </div>  ' +
                        '            </div>  ' +
                        '         </div>  ' +
                        '         {{--./FILE>TITLE--}}  ' +
                        '         <div class="col-md-5 ">  ' +
                        '            {{--FILE>FILE--}}  ' +
                        '            <div class="form-group row">  ' +
                        '               <label for="file[file][' + x + ']"  ' +
                        '                  class="col-form-label col-md-3 text-center">  ' +
                        '               <i class="fa fa-asterisk text-danger"></i>  ' +
                        '               تصویر  ' +
                        '               </label>  ' +
                        '               <div class="col-md-9">  ' +
                        '                  <input ' +
                        '                     id="file[file][' + x + ']"  ' +
                        '                     name="file[file][' + x + ']"  ' +
                        '                     type="file"  ' +
                        '                     class="form-control file-input"  ' +
                        '                     onchange="showImage(this);"  ' +
                        '                     accept=".jpg,.jpeg,.png,.gif"  ' +
                        '                     required  ' +
                        '                     >  ' +
                        '               </div>  ' +
                        '            </div>  ' +
                        '         </div>  ' +
                        '         {{--./FILE>FILE--}}  ' +
                        '         <div class="col-md-2">  ' +
                        '            {{--PREVIEW IMAGE--}}  ' +
                        '            <div class="form-group row">  ' +
                        '               <div class="col-md-12 text-center">{{--IMG--}}  ' +
                        '                  <img src="{{asset('images/fallback/product.png')}}"  ' +
                        '                     alt="تصویر محصول"  ' +
                        '                     class="img-' + x + ' img rounded align-middle image-checkable"  ' +
                        '                     id="img-' + x + '"  ' +
                        '                     width="100vw"  ' +
                        '                     height="100vh"  ' +
                        '                     onmouseover="configImgCheckbox(this.id);"' +
                        '                     required  ' +
                        '                     >  ' +
                        '               </div>  ' +
                        '               {{--./IMG--}}  ' +
                        '            </div>  ' +
                        '         </div>  ' +
                        '         {{--./PREVIEW IMAGE--}}  ' +
                        '      </div>  ' +
                        '      {{--./MAIN FIELDS ROW--}}  ' +
                        '   </div>  ' +
                        '   {{--./FILE-0--}}  ' +
                        '    '
                    );

                } else {
                    swal({
                        text: "برای هر محصول حداکثر 6 تصویر در نظر گرفته شده است.",
                        icon: 'error',
                        button: "اوکی",
                    });
                }
            });


            // Remove last created upload file field
            del_button.click(function () {
                if (x < 0) {
                    $('.file-' + x).remove();
                    x = -1;
                } else if (x === 0) {
                    swal({
                        text: "هرمحصول حداقل باید دارای یک تصویر باشد..",
                        icon: 'error',
                        button: "اوکی",
                    });
                } else {
                    $('.file-' + x).remove();
                    --x;
                }

                let show_default = $("#show_default");
                let show_warning = $(".show_default_status");
                if (show_default.val() > x || show_default.val() === '') {
                    show_warning.show();
                    show_warning.text('لطفاً یک تصویر را بعنوان تصویر پیشفرض محصول انتخاب نمایید!');
                    show_default.val('');
                } else {
                    show_warning.hide();
                }

            });

            @foreach($product->files as $file)
            @if($file->status === "2")

            let selector = $(".img-" +{{$loop->index}});
            selector.mouseover();
            selector.click();
            @endif
            @endforeach



            {{--!! ATTRIBUTE HANDLING!!--}}
            let max_attribute_fields = 5;
            let attribute_wrapper = $("#row-attribute");
            let add_attribute_button = $("#add-attribute-field");
            let del_attribute_button = $("#del-attribute-field");
            let attribute_field_count = -1;
            if (attribute_wrapper.children().length > 0) {
                let attribute_wrapper_last_child = attribute_wrapper.children().last();
                let attribute_wrapper_last_child_classes = attribute_wrapper_last_child.attr('class').split(' ');
                attribute_field_count = attribute_wrapper_last_child_classes['0'].substr(-1, wrapper_last_child_classes['0'].length);
            }

            add_attribute_button.on('click', function (e) {
                e.preventDefault();
                if (attribute_field_count < max_attribute_fields) {
                    ++attribute_field_count;
                    attribute_wrapper.append(
                        '<div class="attribute-' + attribute_field_count + '">' +
                        '    <div' +
                        '        class="form-group row align-items-center align-middle">' +
                        '        <div class="col-md-6">' +
                        '            <div class="form-group row">' +
                        '                <label for="attribute-id-' + attribute_field_count + '"' +
                        '                    class="col-form-label col-md-3 text-center">' +
                        '                <i class="fa fa-asterisk text-danger"></i>' +
                        '                ویژگی' +
                        '                </label>' +
                        '                <div class="col-md-9">' +
                        '                    <select id="attribute-id-' + attribute_field_count + '"' +
                        '                        name="attribute[id][' + attribute_field_count + ']"' +
                        '                        class="select2 form-control d-block"' +
                        '                        title="با انتخاب دسته بندی، مقاله شما از طریق دسته بندی منتخب قابل دسترسی خواهد بود."' +
                        '                        >' +
                        '                    @foreach($attributes as $attr)' +
                        '                    <option value="{{ $attr->id }}">{{ $attr->title }}</option>' +
                        '                    @endforeach' +
                        '                    </select>' +
                        '                </div>' +
                        '            </div>' +
                        '        </div>' +
                        '        {{--./ATTRIBUTE>TITLE--}}' +
                        '        <div class="col-md-6">' +
                        '            <div class="form-group row">' +
                        '                <label for="attribute-value-' + attribute_field_count + '"' +
                        '                    class="col-form-label col-md-3 text-center">' +
                        '                <i class="fa fa-asterisk text-danger"></i>' +
                        '                مقدار' +
                        '                </label>' +
                        '                <div class="col-md-9">' +
                        '                    <input id="attribute-value-' + attribute_field_count + '"' +
                        '                        name="attribute[value][' + attribute_field_count + ']"' +
                        '                        type="text"' +
                        '                        class="form-control"' +
                        '                        title="مقدار دهی الزامی"' +
                        '                        minlength="2"' +
                        '                        maxlength="70"' +
                        '                        required' +
                        '                        >' +
                        '                </div>' +
                        '            </div>' +
                        '        </div>' +
                        '    </div>' +
                        '</div>'
                    );
                    /*CONFIGURE SELECT2 FOR DYNAMIC ELEMENT*/
                    configSelect2('.select2');
                } else {
                    swal({
                        text: "برای هر محصول حداکثر 6 ویژگی در نظر گرفته شده است.",
                        icon: 'error',
                        button: "اوکی",
                    });
                }
            });

            del_attribute_button.on('click', function () {

                if (attribute_field_count >= 0) {
                    --attribute_field_count;
                    attribute_wrapper.children().last().remove();
                } else {
                    attribute_field_count = -1;
                }
            });


        });
    </script>
@endsection

