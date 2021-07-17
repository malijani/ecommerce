{{--SHOW SOCIAL MEDIA SIDE IMAGES--}}
<div class="row">
    @if(!empty($social_medias) && $social_medias->count())
        @foreach($social_medias as $social_media)
            <div class="col-12 py-2">
                <a href="{{ $social_media->link }}"
                   title="{{ $social_media->title }}"
                >
                    <img src="{{ asset($social_media->side_image) }}"
                         alt="{{ $social_media->title }}"
                         class="img img-fluid w-100 rounded"
                    >
                </a>
            </div>
        @endforeach
    @endif
</div>
{{--./SHOW SOCIAL MEDIA SIDE IMAGES--}}
