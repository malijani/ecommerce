<div
    class="card mt-2 mb-3
        @if(isset($comment->user) && $comment->user->isAdmin()) bg-lightgrey @else bg-white @endif
        border px-3"
    id="comment-{{ $comment->id }}"
>
    <div class="col-12 mt-2 p-1  ">
        <div class="row align-items-center mt-2">
            <div class="col-4 col-md-1">
                <img class="rounded-circle img-fluid img-bordered-sm" src="{{ asset('images/fallback/user.png') }}" alt="">
            </div>
            <div class="col-8 col-md-11">
                <div class="row">
                    <div class="col-12">
                    <h5 class="d-inline">{{ $comment->user->full_name ?? 'کاربر مهمان' }}</h5>
                    @if(isset($comment->user) && $comment->user->isAdmin())
                        <span class="badge badge-primary mr-2">ادمین</span>
                    @endif
                    </div>
                    <div class="col-12 my-3 rounded p-3">
                        {{ $comment->content }}
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="col-12 border-top-0 mb-2 mt-2 mr-4">
        <div class="row">
            {{--REPLY BUTTON--}}
            <div class="col-12 mx-auto">
                <button
                    class="btn-reply btn btn-outline-info"
                    id="reply-comment-{{ $comment->id }}"
                >
                    <i class="fal fa-reply"></i>
                    پاسخ
                </button>
            </div>

            <div class="col-12 mt-2">
                <div class="f-reply" id="f-reply-comment-{{$comment->id}}">
                    <form action="{{ route('comment.store', ['model'=>class_basename($model) , 'id'=>$model->id]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                        <div class="form-group row">
                            <div class="col-12">
                                <textarea name="content"
                                          class="form-control @error('content') is-invalid @enderror"
                                          id="content-{{$comment->id}}"
                                          cols="30"
                                          rows="5"
                                          required
                                ></textarea>
                                @include('partials.form_error', ['input'=>'content'])
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-outline-success">
                                <i class="far fa-paper-plane"></i>
                                ثبت پاسخ


                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    @foreach($comment->childrenRecursive as $child_comment)
        @include('front-v1.partials.comments', ['comment'=>$child_comment])
    @endforeach
</div>

@push('comment-script')
    <script>
        $(document).ready(function () {
            $('.f-reply').hide();
            $('.btn-reply').on('click', function () {
                $('.f-reply').hide();
                let service = $(this).attr('id');
                let service_id = "#f-" + service;
                $(service_id).show('slow');
            });
        });
    </script>
@endpush





