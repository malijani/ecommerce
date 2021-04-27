<div class="col-md-6 text-center" id="summary">
    <span class="align-middle"> رتبه : {{ (string)(((float)$model->ratingsAvg() * 100))/5  }}</span>
    @include('front-v1.partials.rating_stars')
</div>

<div class="col-md-6 text-center mt-3">
    <span title="تعداد افراد رای دهنده">
        <span class="badge badge-primary font-16">{{ $model->ratingsCount() }}</span>
        <i class="fal fa-2x fa-user-alt align-middle"></i>
    </span>
</div>

<div class="col-12 text-center mt-5">
    <div class="align-middle text-center font-weight-bold"> شما بین ۱ تا ۵ چه امتیازی میدی؟</div>
    <div class="starrating risingstar d-flex justify-content-center flex-row-reverse">

        <input type="radio" id="star5" name="rating" value="5" {{ ($user_rate && $user_rate == 5) ? 'checked' : ''}} />
        <label for="star5" title="۵ ستاره"></label>

        <input type="radio" id="star4" name="rating" value="4" {{ ($user_rate && $user_rate == 4) ? 'checked' : ''}} />
        <label for="star4" title="۴ ستاره"></label>

        <input type="radio" id="star3" name="rating" value="3" {{ ($user_rate && $user_rate == 3) ? 'checked' : ''}} />
        <label for="star3" title="۳ ستاره"></label>

        <input type="radio" id="star2" name="rating" value="2" {{ ($user_rate && $user_rate == 2) ? 'checked' : ''}} />
        <label for="star2" title="۲ ستاره"></label>

        <input type="radio" id="star1" name="rating" value="1" {{ ($user_rate && $user_rate == 1) ? 'checked' : ''}} />
        <label for="star1" title="۱ ستاره"></label>

    </div>
</div>

<div class="col-12 text-center" id="rate-message">
    <div class="alert alert-info">
        <span class="align-middle" id="rate-message-text"></span>
    </div>
</div>

@push('rating-script')
    <script>
        $(document).ready(function () {
            /*HIDE MESSAGE BY DEFAULT*/
            $("#rate-message").hide();
            /*******/
            let rating = $('input[name="rating"]');
            rating.on('click', function () {
                let rate = $(this).val();
                let rating_address = "{{ route('rating.store') }}";
                $.ajax({
                    url: rating_address,
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'rate': rate,
                        'rateable': '{{ class_basename($model) }}',
                        'rateable_id': '{{ $model->id }}'
                    },
                    success: function (result) {
                        if (result === 'rateable_404') {
                            window.location.href = '{{ route('home') }}';
                        } else {
                            $("#rate-message").show();
                            $("#rate-message-text").html(result);
                        }

                    },
                    error: function () {
                        $("#rate-message").show();
                        $("#rate-message-text").html('' +
                            ' برای ثبت رای خود در وبسایت' +
                            '<a href="{{ route('login') }}"> لاگین </a>' +
                            'کنید.'
                        );
                    }
                });


            });
            /**./RATING**/
        });
    </script>
@endpush

