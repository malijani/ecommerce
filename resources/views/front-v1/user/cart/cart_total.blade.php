
@if(!empty(session()->get('total')) && session()->get('total')['count'] >= 1)
    @php($total = session()->get('total'))
    <h6>مجموع سبد</h6>
    <div class="table-responsive">
        <table class="table">
            <tbody>
            <tr>
                <th scope="row">تعداد کالا</th>
                <td>{{ $total['count'] }} عدد</td>
            </tr>
            <tr>
                <th scope="row">وزن مرسوله</th>
                <td>{{ $total['weight'] }} گرم</td>
            </tr>
            <tr class="">
                <th scope="row">جمع قیمت(بدون تخفیف)</th>
                <td>{{ number_format($total['raw_price']) }} تومن</td>
            </tr>
            <tr class="text-success">
                <th scope="row">جمع تخفیف</th>
                <td>{{ number_format($total['discount']) }} تومن</td>
            </tr>
            <tr class="font-weight-bolder">
                <th scope="row">قیمت نهایی</th>
                <td>{{ number_format($total['final_price']) }} تومن</td>
            </tr>

            <tr class="">
                <td colspan="2">

                    <form action="{{ route('cart.discount') }}" method="POST">
                        @csrf

                        <input type="text"
                               name="discount_code"
                               id="discount_code"
                               class="form-control @error('discount_code') is-invalid @enderror"
                               minlength="2"
                               maxlength="10"
                               value="{{old('discount_code')}}"
                               placeholder="کد تخفیف"
                               autocomplete="off"
                        >
                        @include('partials.form_error', ['input' => 'discount_code'])


                        <div class="col-12 text-center mt-2">
                            <button type="submit"
                                    class="btn btn-outline-primary form-control font-weight-bold"
                            >
                                ثبت سفارش و اعمال تخفیف
                            </button>

                        </div>


                    </form>

                </td>
            </tr>
            </tbody>
        </table>
    </div>
@else

@endif
