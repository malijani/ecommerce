@extends('front-v1.user.dashboard.dashboard')

@section('bread-crumb')
    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('dashboard.tickets') }}
@endsection
@section('dashboard-content')
    <h4>تیکت های من</h4>
    <div class="row my-3">
        <div class="col-12">
            <a href="{{ route('dashboard.tickets.create') }}"
               class="btn btn-outline-info w-100 font-weight-bolder font-16"
               >
                ثبت تیکت جدید
                <i class="fa fa-plus-square fa-2x align-middle mr-2"></i>
            </a>
        </div>
    </div>

    @if($tickets->isEmpty())
        <div class="row">
        <div class="col-md-12 mb-2 mb-md-0 text-center">
            <p
               class="w-100 font-16 border p-4 font-weight-bolder rounded"
            >
                <i class="fal fa-info-circle fa-2x align-middle"></i>
                تیکتی برای شما ثبت نشده. برای ارتباط با پشتیبانی و یا مشاوره همین الان یکی ثبت کن!
            </p>
        </div>
        </div>


    @else
        <div class="row mt-3 d-none d-md-flex align-items-center py-1 font-16">
            <div class="col-md-3 text-center">
                کد
            </div>
            <div class="col-md-5 text-center">
                عنوان
                <hr class="w-25">
                دسته بندی
            </div>
            <div class="col-md-1 text-center">
                وضعیت
            </div>
            <div class="col-md-3 text-center">
                آخرین بروزرسانی
            </div>
        </div>
        @foreach($tickets as $ticket)
            <div class="row mt-3 border rounded p-md-4 py-3 align-items-center">
                <div class="col-md-3 text-center my-1">
                    <a href="{{ route('dashboard.tickets.show', $ticket->uuid) }}"
                       dir="ltr"
                       class="font-weight-bolder"
                       title="برای مشاهده تیکت کلیک کنید"
                    >
                        {{ '#'.$ticket->uuid }}
                    </a>
                </div>
                <div class="col-md-5 text-center font-weight-bold my-1">
                    {{ $ticket->limited_title}}
                    <hr class="w-25">
                    {{ $ticket->category->title }}
                </div>
                <div class="col-md-1 text-center my-1">
                    @if($ticket->status === 0)
                        <span class="badge badge-success">{{ $ticket->status_text }}</span>
                    @elseif($ticket->status === 1)
                        <span class="badge badge-warning">{{ $ticket->status_text }}</span>
                    @elseif($ticket->status === 2)
                        <span class="badge badge-danger">{{ $ticket->status_text }}</span>
                    @else
                        <span class="badge badge-light">نامشخص</span>
                    @endif
                </div>

                <div class="col-md-3 text-center my-1">
                    {{ verta($ticket->updated_at) }}
                </div>
            </div>
        @endforeach
        <div class="row mt-3 justify-content-center">
            {{ $tickets->links() }}
        </div>
    @endif
@endsection
