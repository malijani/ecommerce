<div class="row align-items-center justify-content-center my-3">
    <div class="col-4 mr-auto text-left p-2" title="امتیاز کلی">
            <span class="badge badge-primary font-16">
                {{ (string)((round((float)$model->ratingsAvg() * 100)/5))  }}
            </span>
        <i class="fal fa-2x fa-star align-middle"></i>
    </div>
    <div class="col-4 ml-auto text-right p-2" title="تعداد افراد رای دهنده" id="ratings-count" >
        <span class="badge badge-primary font-16">{{ $model->ratingsCount() }}</span>
        <i class="fal fa-2x fa-user-alt align-middle"></i>
    </div>

</div>
@include('front-v1.partials.rating_stars')
