<div class="col-md-4 mt-5 mt-md-1" id="social_medias">
    <h5>
        شبکه های اجتماعی
    </h5>
    <hr class="w-50">
    <div>
        @if(isset($social_medias) && $social_medias->count() > 1)
            @foreach($social_medias as $social_media)
                <a target="_blank"
                   href="{{ $social_media->link }}"
                   title="{{ $social_media->title }}"
                   class="text-dark mx-1"
                >
                    <i class="fab fa-{{ $social_media->icon }} fa-2x align-middle"></i>
                </a>
            @endforeach
        @endif
    </div>
</div>
