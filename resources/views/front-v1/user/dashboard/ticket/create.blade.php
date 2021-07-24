@extends('front-v1.user.dashboard.dashboard')

@section('bread-crumb')
    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('dashboard.tickets.create') }}
@endsection
@section('dashboard-content')
    <div class="card border-0">

        <div class="card-header">
            <h4>ثبت تیکت جدید</h4>
        </div>

        <div class="card-body">
            <div class="row bg-light-gray rounded">
                <div class="col-12 p-4">
                    <form action="{{ route('dashboard.tickets.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            {{--CATEGORIES--}}
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="category_id" class="col-form-label col-12 col-md-2">
                                        <i class="fa fa-asterisk text-danger"></i>
                                        دسته بندی تیکت
                                    </label>
                                    <div class="col-12 col-md-10">
                                        <select
                                            name="category_id"
                                            id="category_id"
                                            class="select2 input-custom form-control @error('category_id') is-invalid @enderror"
                                            required
                                        >
                                            @if(is_null(old('category_id')))
                                                <option value="" selected>لطفاً دسته بندی تیکت را انتخاب کنید.</option>
                                            @endif

                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}"
                                                        @if(old('category_id') == $category->id) selected @endif
                                                >
                                                    {{ $category->title }}
                                                </option>
                                            @endforeach

                                        </select>
                                        @include('partials.form_error', ['input'=>'category_id'])
                                    </div>
                                </div>
                            </div>
                            {{--./CATEGORIES--}}

                            {{--PRIORITY--}}
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="priority" class="col-form-label col-12 col-md-2">
                                        <i class=" fa fa-asterisk text-danger"></i>
                                        اهمیت
                                    </label>
                                    <div class="col-12 col-md-10">
                                        <select name="priority"
                                                id="priority"
                                                class="form-control input-custom @error('priority') is-invalid @enderror"
                                                required
                                        >
                                            @if(is_null(old('priority')))
                                                <option value="" selected>انتخاب کنید...</option>
                                            @endif
                                            <option value="0" @if(old('priority')=='0') selected @endif>پایین</option>
                                            <option value="1" @if(old('priority')=='1') selected @endif>متوسط</option>
                                            <option value="2" @if(old('priority')=='2') selected @endif>مهم</option>
                                        </select>
                                        @include('partials.form_error', ['input'=>'priority'])
                                    </div>
                                </div>
                            </div>
                            {{--./PRIORITY--}}



                            {{--TITLE--}}
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="title"
                                           class="col-form-label col-12 col-md-2">
                                        <i class="fa fa-asterisk text-danger"></i>
                                        عنوان تیکت
                                    </label>
                                    <div class="col-12 col-md-10">
                                        <input id="title"
                                               name="title"
                                               type="text"
                                               maxlength="100"
                                               minlength="5"
                                               class="form-control input-custom @error('title') is-invalid @enderror"
                                               placeholder="عنوان کوتاه از مشکل یا پیام شما"
                                               value="{{ old('title') }}"
                                               required
                                        >
                                        @include('partials.form_error', ['input'=>'title'])
                                    </div>
                                </div>
                            </div>
                            {{--./TITLE--}}

                            {{--MESSAGE--}}
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="message"
                                           class="col-form-label col-12 col-md-2">
                                        <i class="fa fa-asterisk text-danger"></i>
                                        پیام
                                    </label>
                                    <div class="col-12 col-md-10">
                                    <textarea id="message"
                                              name="message"
                                              class="form-control @error('message') is-invalid @enderror"
                                              placeholder="توضیح کامل از مشکل یا پیام شما : ..."
                                              required
                                              rows="20"
                                    >{{ old('message') }}</textarea>
                                        @include('partials.form_error', ['input'=>'message'])
                                    </div>
                                </div>
                            </div>
                            {{--./MESSAGE--}}

                            {{--FILE--}}
                            <div class="col-12">
                                <div class="form-group row">
                                    <label for="pic"
                                           class="col-form-label col-12 col-md-2">
                                        فایل
                                    </label>
                                    <div class="col-12 col-md-10">
                                        <input id="file"
                                               name="file"
                                               type="file"
                                               class="form-control input-custom @error('file') is-invalid @enderror"
                                               accept=".png,.jpeg,.jpg,.gif"
                                        >
                                        @include('partials.form_error', ['input'=>'file'])
                                    </div>
                                </div>
                            </div>
                            {{--./FILE--}}



                            {{--SUBMIT BUTTON--}}
                            <div class="col-12">
                                <div class="form-group row my-3 text-center">
                                    <button type="submit" class="btn btn-custom form-control">
                                        ثبت تیکت
                                    </button>
                                </div>
                            </div>
                            {{--./SUBMIT BUTTON--}}
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-scripts')
    <script src="{{ asset('front-v1/ckeditor/ckeditor.js') }}"></script>

    <script>
        $(document).ready(function () {
            CKEDITOR.replace('message', {
                contentsLangDirection: 'rtl',
                direction: 'rtl',
                contentsLanguage: 'fa',
                content: 'fa',
                language: 'fa',
                editorplaceholder: 'توضیح کامل از مشکل یا پیام شما : ...',
                toolbarGroups: [{
                    "name": "basicstyles",
                    "groups": ["basicstyles"]
                },
                    {
                        "name": "links",
                        "groups": ["links"]
                    },
                    {
                        "name": "paragraph",
                        "groups": ["list", "blocks"]
                    },
                    {
                        "name": "document",
                        "groups": ["mode"]
                    },
                    {
                        "name": "insert",
                        "groups": ["insert"]
                    },
                    {
                        "name": "styles",
                        "groups": ["styles"]
                    },
                ],
            });
        });
    </script>
@endsection
