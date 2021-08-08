<div class="col-12 text-center mb-2 mb-md-0 py-2 py-md-4" id="ratings">
     <span class="fa-stack ml-2">
        <i class="fal fa-star fa-stack-2x align-middle"></i>
        <span class="fa-stack-1x text-center align-middle"></span>
    </span>
    <h3 class="d-inline font-20">
        امتیازات
    </h3>

</div>


<div class="col-12 col-md-6 text-center my-auto">
    <div class="align-middle text-center font-18 font-weight-bold"> شما بین ۱ تا ۵ چه امتیازی میدی؟</div>
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

<div class="col-12 col-md-6 text-center py-3" id="rating_summary">
    @include('front-v1.partials.rating_summary')
</div>

@push('scripts')
    <script>
        $(document).ready(function () {
            /*HIDE MESSAGE BY DEFAULT*/

            /*******/
            let rating = $('input[name="rating"]');
            rating.on('click', function () {
                let rate = $(this).val();
                let rating_address = "{{ route('rating.store') }}";
                let rating_summary = $("#rating_summary");
                $.ajax({
                    url: rating_address,
                    type: 'POST',
                    data: {
                        'rate': rate,
                        'rateable': '{{ class_basename($model) }}',
                        'rateable_id': '{{ $model->id }}'
                    },
                    success: function (data) {
                        rating_summary.html(data.rating_summary);
                        Swal.fire({
                            position: 'top',
                            icon: "success",
                            title: "<h5>" + data.message + "</h5>",
                            showConfirmButton: false,
                            timer: 1500,
                        });
                    },
                    error: function (data) {
                        Swal.fire({
                            position: 'top',
                            icon: "error",
                            title: "<h5>" + data.responseJSON.message + "</h5>",
                            showConfirmButton: false,
                            timer: 1500,
                        });

                    }
                });


            });
            /**./RATING**/
        });
    </script>
@endpush

