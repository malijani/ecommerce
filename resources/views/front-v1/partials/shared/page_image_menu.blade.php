@if(!empty($page_image_menus) && $page_image_menus->count())
    <div class="row mt-5 py-3 rounded align-items-center justify-content-center bg-light">
        @foreach($page_image_menus as $page_image_menu)
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg my-3 my-md-4 text-center">
                <div class="row align-items-center">
                    <div class="col-12">
                        <a href="{{ $page_image_menu->link }}"
                           title="{{ $page_image_menu->title }}"
                        >
                            <img src="{{ asset($page_image_menu->image) }}"
                                 alt="{{ $page_image_menu->title }}"
                                 class="img img-fluid rounded page_img_menu"
                                 loading="lazy"
                            >
                        </a>
                    </div>
                    <div class="col-12 mt-2 ">
                        <a href="{{ $page_image_menu->link }}"
                           class="text-dark"
                        >
                            <span class="font-weight-bolder">{{ $page_image_menu->title }}</span>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
