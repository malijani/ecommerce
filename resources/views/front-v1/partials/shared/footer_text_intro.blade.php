@if(isset($footer_text_intro))
    <div
        class="@if(isset($footer_license_images)) col-md-6 offset-md-2 @else col-md-8 mx-auto @endif text-center text-md-right p-3 mt-3 mt-md-0">
        <h4 class="mb-2">{{ $footer_text_intro->title }}</h4>
        {!! $footer_text_intro->content !!}
    </div>
@endif
