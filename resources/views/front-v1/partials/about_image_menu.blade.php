@if(isset($about_image_menus))
    <div class="row my-2 py-3 bg-white rounded">
        @foreach($about_image_menus as $about_image_menu)
            <div class="col-6 col-md my-2 my-md-0 text-center">
                <div class="row">
                    <div class="col-12">
                        <a href="{{ $about_image_menu->link }}"
                           title="{{ $about_image_menu->title }}"
                        >
                            <img src="{{ asset($about_image_menu->image) }}"
                                 alt="{{ $about_image_menu->title }}"
                                 class="img img-fluid"
                            >
                        </a>
                    </div>
                    <div class="col-12 mt-2">
                        <a href="{{ $about_image_menu->link }}"
                           class="text-dark"
                        >
                            <span class="font-weight-bold font-12">{{ $about_image_menu->title }}</span>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
