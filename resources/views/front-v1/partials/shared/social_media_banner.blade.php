{{--SHOW SOCIAL MEDIA BANNER IMAGES--}}
@if(!empty($social_medias) && $social_medias->count())
    <div class="row my-5">
        @foreach($social_medias as $social_media)
            <div class="d-block d-lg-none col-12">
                <img src="{{ asset($social_media->banner_image)  }}"
                     alt="{{ $social_media->title }}"
                     class="img img-fluid w-100 rounded social_media_banner_img"
                >
            </div>
        @endforeach
    </div>
@endif
{{--./SHOW SOCIAL MEDIA BANNER IMAGES--}}
