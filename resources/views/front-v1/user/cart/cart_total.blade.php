@if(!empty(session()->get('total')) && session()->get('total')['count'] >= 1)
    @php($total = session()->get('total'))

    <div class="card">
        <div class="card-header border-bottom-0">
            <h5 class="font-20 font-weight-bolder">مجموع سبد</h5>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="row justify-content-around">
                        <div class="col-auto text-center p-1">
                            تعداد کالا
                        </div>
                        <div class="col-auto text-center p-1">
                            {{ $total['count'] }} عدد
                        </div>
                    </div>
                </li>

                <li class="list-group-item">
                    <div class="row justify-content-around">
                        <div class="col-auto text-center p-1">
                            وزن مرسوله
                        </div>
                        <div class="col-auto text-center p-1">
                            {{ $total['weight'] }} گرم
                        </div>
                    </div>
                </li>
                @if($total['discount'] > 0)
                    <li class="list-group-item">
                        <div class="row justify-content-around">
                            <div class="col-auto text-center p-1">
                                جمع قیمت(بدون تخفیف)
                            </div>
                            <div class="col-auto text-center p-1">
                                {{ number_format($total['raw_price']) }} تومن
                            </div>
                        </div>
                    </li>

                    <li class="list-group-item text-success">
                        <div class="row justify-content-around">
                            <div class="col-auto text-center p-1">
                                جمع تخفیف
                            </div>
                            <div class="col-auto text-center p-1">
                                {{ number_format($total['discount']) }} تومن
                            </div>
                        </div>
                    </li>
                @endif
                <li class="list-group-item font-weigh-bolder font-18">
                    <div class="row justify-content-around">
                        <div class="col-auto text-center p-1">
                            قیمت نهایی
                        </div>
                        <div class="col-auto text-center p-1">
                            {{ number_format($total['final_price']) }} تومن
                        </div>
                    </div>
                </li>

                <li class="list-group-item font-weigh-bolder font-18">
                    <div class="row justify-content-around">
                        <div class="col-12">
                            <form action="{{ route('cart.discount') }}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-12">
                                        <input type="text"
                                               name="discount_code"
                                               id="discount_code"
                                               class="text-center form-control @error('discount_code') is-invalid @enderror"
                                               minlength="2"
                                               maxlength="10"
                                               value="{{old('discount_code')}}"
                                               placeholder="کد تخفیف"
                                               autocomplete="off"
                                        >
                                        @include('partials.form_error', ['input' => 'discount_code'])
                                    </div>

                                    <div class="col-12 text-center mt-3">
                                        <button type="submit"
                                                class="btn btn-custom form-control font-weight-bold"
                                        >
                                            <span class="font-14">اعمال تخفیف و</span>
                                            <span class="font-18">ثبت سفارش</span>
                                        </button>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

@else
    <div class="card">
        <div class="card-body">
            <h5 class="font-20 font-weight-bolder">محصولی برای خرید ثبت نشده!</h5>
        </div>
    </div>
@endif
