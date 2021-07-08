<div class="col-12 text-center py-md-4 py-2 border-top" id="comments">
    <span class="fa-stack ml-2" title="تعداد نظرات">
        <i class="fal fa-comment-alt fa-stack-2x align-middle"></i>
        <span class="fa-stack-1x text-center align-middle">
            {{ $model->activeComments->count() }}
        </span>
    </span>
    <h3 class="d-inline font-20">
        نظرات
    </h3>
</div>

<div class="col-12 my-3">
    <div class="row align-items-center">
        @auth
            <div class="col-4 col-lg-1 mb-2">
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
                  method="POST"
                  class="comment_form"
            >
                @csrf
                <input type="hidden" name="parent_id" value="0">
                <div class="form-group row">
                    <div class="col-12">
                                <textarea name="content"
                                          class="comment_textarea form-control @error('content') is-invalid @enderror"
                                          id="content"
                                          cols="20"
                                          rows="5"
                                          minlength="4"
                                          placeholder="نظر خود را ثبت کنید!..."
                                          required
                                >{{ old('content') }}</textarea>
                        @include('partials.form_error', ['input'=>'content'])
                    </div>
                    <div class="col-12 mt-2 comment_captcha">
                        @include('front-v1.partials.comment_captcha')
                    </div>
                    <div class="col-12 mt-3">
                        <button type="submit" class="comment_button btn btn-custom form-control ">
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

@push('scripts')
    <script>
        $(document).ready(function () {

            /*INITIALIZE CAPTCHA*/
            function refreshCaptcha() {
                $('.comment_captcha_img').attr('src', "{{ captcha_src('default') }}");
            }
            let refresh_comment_captcha_btn = $(".refresh_comment_captcha")
            refresh_comment_captcha_btn.on('click', function (e) {
                e.preventDefault();
                refreshCaptcha();
                $(".comment_captcha_input").val('');
            });
            refresh_comment_captcha_btn.click();


            $(".comment_form").unbind('submit').on('submit',function (e) {
                e.preventDefault();
                let comment_form = $(this);
                let url = comment_form.attr('action');
                let comment_content = comment_form.find('.comment_textarea')
                $.ajax({
                    type: "POST",
                    url: url,
                    data: comment_form.serialize(),
                    success: function (data) {
                        comment_content.val('');
                        Swal.fire({
                            position: 'top',
                            icon: "success",
                            title: "<h5>" + data.message + "</h5>",
                            showConfirmButton: false,
                            timer: 1500,
                        }).then(() => {
                            refresh_comment_captcha_btn.click();
                        });
                    },
                    error: function (data) {
                        let error = $.parseJSON(data.responseJSON.message);
                        let info = [];
                        $.each(error, function (key, val) {
                            info.push('<li>' + val + '</li>');
                        });
                        Swal.fire({
                            position: 'top',
                            icon: "error",
                            title: "<h6>" + info.join("") + "</h6>",
                            showConfirmButton: false,
                            timer: 1500,
                        }).then(() => {
                            refresh_comment_captcha_btn.click();
                        });
                    },
                });
            });


        });
    </script>
@endpush

