@if(!empty($about_image_menus) && $about_image_menus->count())
    <div class="row align-items-center mt-3 py-3 rounded  bg-light">
        @foreach($about_image_menus as $about_image_menu)
            <div class="col-12 col-sm-6 col-md my-2 my-md-0 py-3 text-center">
                <div class="row">
                    <div class="col-12">
                        <a href="{{ $about_image_menu->link }}"
                           title="{{ $about_image_menu->title }}"
                        >
                            <img src="{{ asset($about_image_menu->image) }}"
                                 alt="{{ $about_image_menu->title }}"
                                 class="img img-fluid"
                                 loading="lazy"
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
