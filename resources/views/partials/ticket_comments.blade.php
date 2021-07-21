@if(isset($ticket->comments)  && $ticket->comments->count()>0)
    @foreach($ticket->comments as $comment)
        @include('partials.ticket_comments', ['ticket'=>$comment, 'type'=>'comment'])
    @endforeach
@endif
<div class="col-12 my-1 border rounded p-4 @if($ticket->user->isAdmin()) bg-grey-50 @endif">
    <div class="row align-items-center m-0 p-0">
        <div class="col-2 col-md-1">
            @if($ticket->user->isAdmin())
                <i class="fal fa-user-crown fa-2x"></i>
            @else
                <i class="fal fa-user fa-2x"></i>
            @endif
        </div>
        <div class="col-10 col-md-3">
            {{ $ticket->user->full_name }}
            @if($ticket->user->isAdmin())
                <span class="badge badge-primary">ادمین</span>
            @endif
        </div>

        @if( $ticket->user->isAdmin())
            <div class="col-12 col-md-5 text-left mt-2 mt-md-0">

                {!!  implode("<br>", $ticket->user->contact_information)  !!}
            </div>
        @endif

    </div>
    <hr>
    <div class="row px-4 py-2">
        <div class="col-12 p-0">
            {!! $ticket->message !!}
        </div>
    </div>

    <div class="row align-items-center px-3 py-1">

        @if(!is_null($ticket->file))
            <div class="col-12 col-md-4">
                <a
                    @if(isset($type) && $type === 'comment')
                    href="{{ route('files.ticket-files', [$ticket->id, 'comment']) }}"
                    @else
                    href="{{ route('files.ticket-files', [$ticket->uuid, 'ticket']) }}"
                    @endif
                    class="btn btn-light"
                >

                    <i class="fa fa-download fa-2x align-middle"></i>
                    دانلود فایل
                </a>
            </div>
        @endif
        <div class="col text-md-left">
                    <span class="text-muted">
                        ثبت شده در :
                        <br>
                    {{ $ticket->created_at }}
                    </span>
        </div>

    </div>
</div>

