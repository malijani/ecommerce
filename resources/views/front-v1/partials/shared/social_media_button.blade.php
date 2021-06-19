@if(isset($float_social_media_button))
    <a id="social-media-button"
       href="{{ $float_social_media_button->link }}"
       class="social-media-button border"
    >
        <img src="{{ asset($float_social_media_button->image) }}"
             alt="{{ $float_social_media_button->title }}"
             class="img img-fluid"
        >
    </a>
@endif
