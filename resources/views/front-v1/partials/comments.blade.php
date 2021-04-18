<div class="card mt-2 mb-3 bg-white border-left-0 border-top-0 px-3">
    <div class="card-header bg-white p-0 border-0">
        <div class="row align-items-center mt-2">
            <div class="col-4 col-md-1">
                <img class="rounded-circle img-fluid" src="{{ asset('images/fallback/user.png') }}" alt="">
            </div>
            <div class="col-8 col-md-11">
                <h5>{{ $comment->user->full_name ?? 'کاربر مهمان' }}</h5>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="row align-items-start">
            <div class="col-12">
                <div class="card-text">
                    {{ $comment->content }}
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer mb-2">
        <div class="row">
            {{--REPLY BUTTON--}}
            <div class="col-12">
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
                    <form action="{{ route('comment.store', ['model'=>$model , 'id'=>$model_id]) }}" method="POST">
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
    @foreach($comment->children as $child_comment)
        @include('front-v1.partials.comments', ['comment'=>$child_comment])
    @endforeach
</div>




