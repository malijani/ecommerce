@push('styles')
    <link rel="stylesheet" href="{{ asset('front-v1/bootstrap-slider/bootstrap-slider.min.css') }}">
@endpush

<form action="{{ route('search.search') }}"
      method="GET"
      id="search-form"
      class="bg-light p-4 shadow-sm rounded"
>
    {{--CONTENT--}}
    <div class="form-group row">
        <label for="content"
               class="col-form-label col-12 col-md-2"
        >
            جست و جو در
        </label>
        <div class="col-12 col-md-10">
            <select name="content"
                    id="content"
                    class="w-25 custom-select"

            >
                <option value="all" selected>همه</option>
                <option value="products">محصولات</option>
                <option value="articles">مقالات</option>
                <option value="brands">برند ها</option>
                <option value="categories">دسته بندی ها</option>
            </select>
        </div>
    </div>
    {{--./CONTENT--}}

    {{--PRICE_RANGE--}}
    <div class="form-group row">
        <label for="price_range"
               class="col-form-label col-12 col-md-2"
        >
            محدوده قیمت
        </label>
        <div class="col-12 col-md-10">
            <button class="btn btn-white">
                <span id="min_price_text">
                    100,000
                </span>
                تومن
            </button>
            <input id="price_range"
                   type="text"
                   class="form-control"
                   value=""
                   data-slider-value="[100000,10000000]"
                   data-slider-tooltip="hide"
                   data-slider-handle="square"
            >
            <button class="btn btn-white">
                <span id="max_price_text">
                    10,000,000
                </span>
                تومن
            </button>
        </div>
    </div>
    <input type="hidden" id="min_price" value="100000">
    <input type="hidden" id="max_price" value="10000000">
    {{--./PRICE_RANGE--}}

    {{--QUERY--}}
    <div class="form-group row">
        <label for="q"
               class="col-form-label col-12 col-md-2"
        >
            متن مورد نظر
        </label>
        <div class="col-12 col-md-10">
            <input type="text"
                   class="form-control input-custom"
                   name="q"
                   id="q"
                   placeholder="جست و جوی حرفه ای"
                   autocomplete="none"
                   required
                   maxlength="100"
            >
        </div>
    </div>
    {{--./QUERY--}}

    {{--SUBMIT--}}
    <div class="form-group">
        <div class="col-12">
            <button type="submit"
                    class="btn btn-custom form-control"
            >
                <i class="fal fa-search"></i>
                جست و جو
            </button>
        </div>
    </div>
    {{--./SUBMIT--}}
</form>

@push('scripts')
    <script src="{{ asset('front-v1/bootstrap-slider/bootstrap-slider.min.js') }}"></script>
    <script>
        let content = $("#content");
        let price_range = $("#price_range")
        let min_price = $("#min_price");
        let max_price = $("#max_price");
        let min_price_text = $("#min_price_text");
        let max_price_text = $("#max_price_text");

        content.on('change', function () {

            if (content.val() === 'products' || content.val() === 'all') {
                price_range.show();
            } else {
                price_range.hide();
            }
        });


        let price_slider = price_range.slider({
            min: 100000,
            max: 10000000,
            step: 5,
            dir: 'rtl',
        }).on('slide', function (e) {
            let min_selected_price = e.value[0];
            let max_selected_price = e.value[1];
            min_price.val(min_selected_price);
            max_price.val(max_selected_price);

            min_price_text.html(Intl.NumberFormat('en-US').format(min_selected_price));
            max_price_text.html(Intl.NumberFormat('en-US').format(max_selected_price));
        });

        console.log(price_slider.slider('getValue')[0])

    </script>

@endpush
