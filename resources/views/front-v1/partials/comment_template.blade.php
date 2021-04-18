<div class="col-12 text-center border-bottom py-2">
    <h3>نظرات</h3>
</div>

<div class="col-12 my-3">
    <div class="row align-items-center">
        @auth
            <div class="col-4 col-md-1 mb-2">
                <img class="rounded-circle img-fluid" src="{{ asset('images/fallback/user.png') }}" alt="">
            </div>
            <div class="col-8 col-md-11">
                <h5>{{ Auth::user()->full_name }}</h5>
            </div>
        @else
            <div class="col-4 col-md-1 mb-2">
                <img class="rounded-circle img-fluid" src="{{ asset('images/fallback/user.png') }}" alt="">
            </div>
            <div class="col-8 col-md-11">
                <h5>کاربر مهمان</h5>
            </div>
        @endauth

        <div class="col-12">
            <form action="{{ route('comment.store', ['model'=>$model , 'id'=>$model_id]) }}" method="POST">
                @csrf
                <input type="hidden" name="parent_id" value="0">
                <div class="form-group row">
                    <div class="col-12">
                                <textarea name="content"
                                          class="form-control @error('content') is-invalid @enderror"
                                          id="content"
                                          cols="20"
                                          rows="5"
                                          placeholder="نظر خود را ثبت کنید!..."
                                          required
                                >{{ old('content') }}</textarea>
                        @include('partials.form_error', ['input'=>'content'])
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="form-control btn btn-outline-success">
                        <i class="far fa-comment-alt"></i>
                        ثبت دیدگاه
                    </button>
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

