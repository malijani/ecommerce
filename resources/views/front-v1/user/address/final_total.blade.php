@if(!empty(session()->get('total')) && session()->get('total')['count'] >= 1)
    @php($total = session()->get('total'))

    <div class="card border-0 shadow-sm">
        <div class="card-header border-bottom-0 text-center">
            <h5 class="font-20 font-weight-bolder">
                فاکتور نهایی سفارش
            </h5>
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
                    <li class="list-group-item text-success">
                        <div class="row justify-content-around">
                            <div class="col-auto text-center p-1">
                                تخفیف نهایی
                                @if(isset($total['discount_code']))
                                    ({{ $total['discount_code'] }})
                                @endif
                            </div>
                            <div class="col-auto text-center p-1">
                                {{ number_format($total['discount']) }} تومن
                            </div>
                        </div>
                    </li>
                @endif

                <li class="list-group-item font-weigh-bolder">
                    <div class="row justify-content-around">
                        <div class="col-auto text-center p-1">
                            هزینه نهایی سفارش
                        </div>
                        <div class="col-auto text-center p-1">
                            {{ number_format($total['final_price']) }} تومن
                        </div>
                    </div>
                </li>

                <li class="list-group-item">
                    <div class="row justify-content-around">
                        <div class="col-12">
                            <form action="{{ route('factor.store') }}" method="POST">
                                @csrf


                                <div class="form-group row">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="driver[zarinpal]"
                                                       class=" align-middle"
                                                >
                                                    <input type="radio"
                                                           name="driver[zarinpal]"
                                                           class="align-middle w-50"
                                                           checked
                                                    >
                                                    <img src="{{ asset('images/asset/payment_gateways/z_pal.png') }}"
                                                         alt="درگاه امن زرین پال"
                                                         class="img img-fluid align-middle w-25"
                                                    >
                                                </label>
                                            </div>
                                            <div class="col-6">
                                                <span>
                                                    درگاه زرین پال
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="driver[behpardakht]" class=" align-middle">
                                                    <input type="radio"
                                                           name="driver[behpardakht]"
                                                           class="align-middle w-50"
                                                    >
                                                    <img src="{{ asset('images/asset/payment_gateways/z_pal.png') }}"
                                                         alt="درگاه امن به پرداخت"
                                                         class="img img-fluid align-middle w-25"
                                                    >
                                                </label>
                                            </div>
                                            <div class="col-6">
                                                <span>
                                                    بانک ملت
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 text-center mt-3">
                                        <button type="submit"
                                                class="btn btn-custom form-control font-weight-bold"
                                        >
                                            <i class="far fa-dollar-sign align-middle mx-1"></i>
                                            پرداخت
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
