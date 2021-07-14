@push('styles')
    <link rel="stylesheet" href="{{ asset('front-v1/css/bootstrap-image-checkbox.min.css') }}">
@endpush

@if(!empty(session()->get('total')) && session()->get('total')['count'] >= 1)
    @php($total = session()->get('total'))
    <div class="row">
        <div class="card border-0 shadow-sm">
            <div class="card-header border-bottom-0 text-center">
                <h5 class="font-20 font-weight-bolder">
                    فاکتور نهایی سفارش
                </h5>
            </div>
            <div class="card-body pb-0">
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


                    <div class="col-12 px-0 pt-4">
                        <form action="{{ route('factor.store') }}" method="POST">
                            @csrf
                            <div class="form-row form-group">
                                <label for="description"
                                       class="col-form-label col-12 pt-0"
                                >
                                    درخواست شما
                                </label>
                                <div class="col-12">
                                    <textarea name="description"
                                              id="description"
                                              class="textarea-custom form-control"
                                              rows="5"
                                              placeholder="درخواست اختصاصی شما برای این سفارش"
                                              maxlength="255"
                                    >{{ old('user_ask') }}</textarea>
                                </div>
                            </div>

                            <div class="form-row form-group justify-content-center">
                                <div class="col-6 col-lg-4 mx-auto text-center">
                                    <div class="custom-control custom-radio image-checkbox bg-dark rounded">
                                        <input type="radio"
                                               class="payment_gate custom-control-input"
                                               id="behpardakht"
                                               name="driver"
                                               value="behpardakht"
                                               disabled
                                        >
                                        <label class="custom-control-label"
                                               for="behpardakht"
                                        >
                                            <img src="{{ asset('images/asset/payment_gateways/behpardakht.png') }}"
                                                 title="درگاه امن به پرداخت بانک ملت"
                                                 alt="درگاه امن به پرداخت بانک ملت"
                                                 class="img-fluid"

                                            >

                                        </label>
                                    </div>
                                </div>

                                <div class="col-6 col-lg-4 mx-auto text-center">
                                    <div class="custom-control custom-radio image-checkbox bg-light rounded">
                                        <input type="radio"
                                               class="payment_gate custom-control-input"
                                               id="zarinpal"
                                               name="driver"
                                               value="zarinpal"
                                               checked
                                        >
                                        <label class="custom-control-label"
                                               for="zarinpal"
                                        >
                                            <img src="{{ asset('images/asset/payment_gateways/zarinpal.png') }}"
                                                 title="درگاه پرداخت امن شرکت زرین پال"
                                                 alt="درگاه پرداخت امن شرکت زرین پال"
                                                 class="img-fluid"
                                            >
                                        </label>
                                    </div>
                                </div>
                                @include('partials.form_error', ['input'=> 'driver'])
                            </div>

                            {{--SUBMIT--}}
                            <div class="form-row">
                                <div class="col-12 text-center mt-2 px-0 py-1">
                                    <button type="submit"
                                            class="btn btn-custom form-control font-weight-bold"
                                    >
                                        <i class="far fa-dollar-sign align-middle mx-1"></i>
                                        پرداخت
                                    </button>
                                </div>
                            </div>

                            {{--TERMS CONDITIONS--}}
                            <div class="form-row align-items-center justify-content-center py-2">
                                @include('partials.form_error', ['input'=> 'agree_terms'])

                                <div class="col-2">
                                    <input type="checkbox"
                                           class="form-control"
                                           id="agree_terms"
                                           name="agree_terms"
                                           checked
                                           required
                                    >
                                </div>

                                <label for="agree_terms"
                                       class="col-form-label col-10 col-md-8 text-right"
                                >
                                    @if(!empty($terms_conditions))
                                        <button class="btn p-1"
                                                type="button"
                                                data-toggle="collapse"
                                                data-target="#terms_conditions"
                                                aria-expanded="false"
                                                aria-controls="terms_conditions"
                                                title="مشاهده قوانین و مقررات "
                                        >
                                            <u>
                                                قوانین و مقررات
                                            </u>
                                        </button>
                                    @else
                                        قوانین و مقررات
                                    @endif
                                    {{ config('app.short.name') }} را میپذیرم.
                                </label>

                                @if(!empty($terms_conditions))
                                    <div class="col-12 p-0 mt-2 rounded">
                                        <div class="collapse"
                                             id="terms_conditions"
                                        >
                                            <div class="card">
                                                <div class="card-body bg-light p-1">
                                                    {!! $terms_conditions->content !!}
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </ul>
            </div>
        </div>
    </div>



    @push('scripts')
        <script>
            $(document).ready(function () {
                let payment_gate = $('.payment_gate');
                payment_gate.click(function () {
                    payment_gate.not(this).prop('checked', false);
                    payment_gate.not(this).parent().removeClass('bg-light rounded');
                    $(this).parent().addClass('bg-light rounded');
                });
            });
        </script>
    @endpush






@else
    <div class="card">
        <div class="card-body">
            <h5 class="font-20 font-weight-bolder">محصولی برای خرید ثبت نشده!</h5>
        </div>
    </div>
@endif



