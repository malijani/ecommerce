@extends('front-v1.user.dashboard.dashboard')

@section('bread-crumb')
    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('dashboard') }}
@endsection

@section('dashboard-content')
    <h4>داشبورد {{ \Illuminate\Support\Facades\Auth::user()->full_name}} در {{ config('app.short.name') }}</h4>
    <div class="border p-4 m-4 rounded text-center font-weight-bolder font-16">
        با کلیک روی گزینه های داشبورد، حساب {{ config('app.short.name') }} خود را مدیریت کنید.
    </div>
    <div class="row">
        <div class="col-md-6 mb-2 mb-md-0">
            <a href="{{ route('home') }}"
               class="btn btn-light w-100 font-16 border p-4 font-weight-bolder"
            >
                <i class="fa fa-shoe-prints fa-rotate-270 fa-2x align-middle"></i>
                ادامه خرید
            </a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('cart.index') }}"
               class="btn btn-light w-100 font-16 border p-4 font-weight-bolder"
            >
                <i class="fa fa-shopping-cart fa-2x align-middle"></i>
                مشاهده سبد خرید
            </a>
        </div>
    </div>

    <div class="row my-3">
        <div class="col-12 p-0">
            <canvas id="myChart"></canvas>
        </div>
    </div>
@endsection


@push('scripts')
    {{--TODO : DOWNLOAD CHART JS--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.4.1/chart.min.js"></script>
    <script>

        @if(!empty($paid_factors) && $paid_factors->count())
        var ctx = document.getElementById('myChart');

        const data = [
                @foreach($paid_factors as $factor)
            {
                x: "{{ verta($factor->paid_at)->formatJalaliDatetime() }}",
                raw_price: "{{ $factor->raw_price }}",
                discount: "{{ $factor->discount_price }} ",
                price: "{{ $factor->price }}",
            },
            @endforeach
        ];
        const cfg = {
            type: 'bar',
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'نمودار فاکتور های پرداخت شده'
                    },
                },
                responsive: true,
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true
                    }
                }
            },
            data: {
                datasets: [
                    {
                        label: 'پرداخت شده',
                        data: data,
                        backgroundColor: [
                            'rgba(0, 24, 255, 0.4)',
                        ],
                        parsing: {
                            yAxisKey: 'price'
                        },
                    }, {
                        label: 'تخفیف',
                        data: data,
                        backgroundColor: [
                            'rgba(0, 255, 0, 1)',
                        ],
                        parsing: {
                            yAxisKey: 'discount'
                        },
                    }]
            },
        };
        const chart = new Chart(ctx, cfg);
        @endif
    </script>
@endpush
