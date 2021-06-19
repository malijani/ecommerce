<div class="container">
    <div class="row justify-content-center rounded">
        <div class="col-12 text-center">
            <a href="{{ $footer_image->link ?? '#' }}">
                <img src="{{ asset($footer_image->pic ?? 'images/fallback/footer_licenses.png') }}"
                     alt="مجوز های {{ $footer_image->pic_alt ?? config('app.short.name') ?? ' وبسایت' }}"
                     class="img img-fluid rounded"
                >
            </a>
        </div>
    </div>
</div>
