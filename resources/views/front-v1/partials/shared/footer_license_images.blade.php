@if(isset($footer_license_images))
    <div class="col text-center">
        <div class="row">
            @foreach($footer_license_images as $footer_license_image)
                <div class="col-md-12 col p-md-3">
                    <a href="{{ $footer_license_image->link }}"
                       title="{{ $footer_license_image->title }}"
                    >
                        <img src="{{ asset($footer_license_image->image) }}"
                             alt="{{ $footer_license_image->title }}">
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endif
