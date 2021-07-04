<div class="col-12 text-center py-md-4 py-2 border-top" id="comments">
    <span class="fa-stack ml-2" title="تعداد نظرات">
        <i class="fal fa-comment-alt fa-stack-2x align-middle"></i>
        <span class="fa-stack-1x text-center align-middle">
            {{ $model->comments->count() }}
        </span>
    </span>
    <h3 class="d-inline font-20">
        نظرات
    </h3>
</div>

<div class="col-12 my-3">
    <div class="row align-items-center">
        @auth
            <div class="col-4 col-md-1 mb-2">
                <img class="img-fluid img-circle"
                     src="{{ asset(Auth::user()->pic??'images/fallback/user.png') }}"
                     alt="پروفایل"
                >
            </div>
            <div class="col-8 col-md-11">
                <h5>{{ Auth::user()->full_name }}</h5>
            </div>
        @else
            <div class="col-4 col-md-1 mb-2">
                <img class="rounded-circle img-fluid"
                     src="{{ asset('images/fallback/user.png') }}"
                     alt="پروفایل"
                >
            </div>
            <div class="col-8 col-md-11">
                <h5>کاربر مهمان</h5>
            </div>
        @endauth

        <div class="col-12">
            <form action="{{ route('comment.store', ['model'=>class_basename($model) , 'id'=>$model->id]) }}"
                  method="POST">
                @csrf
                <input type="hidden" name="parent_id" value="0">
                <div class="form-group row">
                    <div class="col-12">
                                <textarea name="content"
                                          class="comment_textarea form-control @error('content') is-invalid @enderror"
                                          id="content"
                                          cols="20"
                                          rows="5"
                                          placeholder="نظر خود را ثبت کنید!..."
                                          required
                                >{{ old('content') }}</textarea>
                        @include('partials.form_error', ['input'=>'content'])
                    </div>
                    <div class="col-12 mt-3">
                        <button type="submit" class="comment_button form-control ">
                            <i class="far fa-comment-alt ml-2"></i>
                            ثبت نظر
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="col-12">
    @foreach($comments as $comment)
        @include('front-v1.partials.comments', ['comment'=>$comment])
    @endforeach
</div>

