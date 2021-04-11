@extends('layouts.app')

@section('content')


    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('address') }}

    <div class="container my-3 rounded">
        <div class="row bg-white">


            <div class="col-12  col-lg-8 py-4">{{--addresses--}}
                @include('front-v1.partials.address') {{--It gets default_address, addresses--}}
            </div>{{--./addresses--}}

            <div class="col-12 col-lg-4 py-4">{{--FINAL DESCRIPTION--}}
                <h3>فاکتور نهایی سفارش</h3>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th scope="row">تعداد کالا</th>
                            <td>{{ $total['count'] }}</td>
                        </tr>
                        <tr>
                            <th scop="row">وزن مرسوله</th>
                            <td>{{ $total['weight'] }} گرم</td>
                        </tr>
                        <tr class="font-weight-bolder">
                            <th scope="row">هزینه نهایی سفارش</th>
                            <td>{{ number_format($total['final_price']) }} تومن</td>
                        </tr>
                        {{-- <tr class="">
                             <td colspan="2">
                                 <a href="{{ route('address.index') }}"
                                    type="button"
                                    class="btn btn-outline-success w-100 font-weight-bolder"
                                 >
                                     ثبت سفارش
                                 </a>
                             </td>
                         </tr>--}}
                        </tbody>
                    </table>
                </div>

            </div>{{--./FINAL DESCRIPTION--}}

        </div>{{--row--}}
    </div>{{--container--}}
@endsection




