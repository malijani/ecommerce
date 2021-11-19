<div class="rating-average ltr" title="میانگین رتبه : {{ (float)$model->ratingsAvg() }}">
    <div class="back-stars">
        <i class="fal fa-star fa-2x align-middle" aria-hidden="true"></i>
        <i class="fal fa-star fa-2x align-middle" aria-hidden="true"></i>
        <i class="fal fa-star fa-2x align-middle" aria-hidden="true"></i>
        <i class="fal fa-star fa-2x align-middle" aria-hidden="true"></i>
        <i class="fal fa-star fa-2x align-middle" aria-hidden="true"></i>
        <div class="front-stars" style="width: {{ (string)(((float)$model->ratingsAvg() * 100))/5 . '%' }}">
            <i class="fal fa-star fa-2x align-middle" aria-hidden="true"></i>
            <i class="fal fa-star fa-2x align-middle" aria-hidden="true"></i>
            <i class="fal fa-star fa-2x align-middle" aria-hidden="true"></i>
            <i class="fal fa-star fa-2x align-middle" aria-hidden="true"></i>
            <i class="fal fa-star fa-2x align-middle" aria-hidden="true"></i>
        </div>
    </div>
</div>
