<div
    class="card mt-2 mb-3 pl-1 pr-md-3 pr-1 border-left-0 border-bottom-0 comment_show
        @if(isset($comment->user) && $comment->user->isAdmin()) bg-light @else bg-white @endif"
    id="comment-{{ $comment->id }}"
>
    <div class="col-12 mt-2 p-1  ">
        <div class="row align-items-center mt-2">
            <div class="d-none d-md-block col-md-2">
                <img class="img-fluid img-circle img-bordered-sm img-circle"
                     src="{{ asset($comment->user->pic ?? 'images/fallback/user.png') }}"
                     alt="{{ $comment->user->full_name ?? 'کاربر مهمان' }}"
                >
            </div>
            <div class="col-12 col-md-10">
                <div class="comment_header row pb-2 pr-2">
                    <div class="col-12 col-md-4 text-right mt-1">
                        <h5 class="d-inline">{{ $comment->user->full_name ?? 'کاربر مهمان' }}</h5>
                        @if(isset($comment->user) && $comment->user->isAdmin())
                            <span class="badge badge-primary mr-2 align-middle">ادمین</span>
                        @endif
                    </div>
                    <div class="col-12 col-md-4 text-right mt-1 text-muted">
                        {{ verta($comment->created_at)->formatDifference() }}
                    </div>
                    <div class="col-12 col-md-4 text-right mt-1">
                        <button
                            class="comment_button btn btn-custom btn-reply form-control"
                            id="reply-comment-{{ $comment->id }}"
                            type="button"
                            data-toggle="collapse"
                            data-target="#f-reply-comment-{{ $comment->id }}"
                            aria-expanded="false"
                            aria-controls="f-reply-comment-{{$comment->id}}"
                        >
                            <i class="fal fa-reply"></i>
                            پاسخ
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 my-3 rounded p-3">
                        {{ $comment->content }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 border-top-0 mb-2 mt-2">
        <div class="row">

            <div class="col-12 mt-2">
                <div class="f-reply collapse" id="f-reply-comment-{{$comment->id}}">
                    <form action="{{ route('comment.store', ['model'=>class_basename($model) , 'id'=>$model->id]) }}"
                          method="POST"
                          class="comment_form"
                    >
                        @csrf
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                        <div class="form-group row">
                            <div class="col-12">
                                <textarea name="content"
                                          class="comment_textarea form-control @error('content') is-invalid @enderror"
                                          id="content-{{$comment->id}}"
                                          cols="30"
                                          rows="5"
                                          minlength="4"
                                          required
                                          placeholder="پاسخ خود را ثبت کنید"
                                ></textarea>
                                @include('partials.form_error', ['input'=>'content'])
                            </div>

                            <div class="col-12 mt-2 comment_captcha">
                                @include('front-v1.partials.comment_captcha')
                            </div>

                            <div class="col-12 mt-2">
                                <button type="submit" class="comment_button form-control">
                                    <i class="far fa-paper-plane"></i>
                                    ثبت پاسخ
                                </button>
                            </div>
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



