<div class="menu__main_wrapper">
    <nav class="menu__navbar">

        <div class="menu__brand_and_icon">
            <a href="{{ route('home') }}"
               title="رفتن به صفحه اصلی {{config('app.short.name')}}"
               class="menu__navbar_brand"
            >
                <img
                    src="{{asset('images/asset/logos/logo.png')}}"
                    alt="{{$logo->pic_alt??config('app.short.name')}}"
                    width="107" height="24"
                    data-retina="{{asset('images/asset/logos/logo-min.png')}}"
                    data-width="107" data-height="24"
                    loading="lazy"
                >
            </a>


            <button type="button"
                    class="menu__navbar_toggle"
            >
                <i class="fal fa-bars"></i>
            </button>
        </div>

        <div class="menu__navbar_collapse">
            <ul class="menu__navbar_nav text-right">
                <li>
                    <a href="#">home</a>
                </li>

                <li class="">
                    <a href="#" class="menu__menu_link">
                        electronics
                        <span class="menu__drop_icon">
                            <i class="fas fa-chevron-down"></i>
                        </span>
                    </a>
                    <div class="menu__sub_menu">
                        <!-- item -->
                        <div class="menu__sub_menu_item">
                            <h4>top categories</h4>
                            <ul>
                                <li><a href="#">cell phones & accessories</a></li>
                                <li><a href="#">smart tv</a></li>
                                <li><a href="#">computer & laptops</a></li>
                                <li><a href="#">digital cameras</a></li>
                                <li><a href="#">video games & accessories</a></li>
                            </ul>
                        </div>
                        <!-- end of item -->
                        <!-- item -->
                        <div class="menu__sub_menu_item">
                            <h4>other categories</h4>
                            <ul>
                                <li><a href="#">iphones</a></li>
                                <li><a href="#">speakers</a></li>
                                <li><a href="#">samsung devices</a></li>
                                <li><a href="#">audio & headphones</a></li>
                                <li><a href="#">vehicles electronics & GPS</a></li>
                            </ul>
                        </div>
                        <!-- end of item -->
                        <!-- item -->
                        <div class="menu__sub_menu_item">
                            <h2>all essential devices and tools for home</h2>
                            <button type="button" class="btn">shop here</button>
                        </div>
                        <!-- end of item -->
                        <!-- item -->
                        <div class="menu__sub_menu_item">
                            <img src="images/car.png" alt="product image">
                        </div>
                        <!-- end of item -->
                    </div>
                </li>

                <li>
                    <a href="#" class="menu__menu_link">
                        fashion
                        <span class="menu__drop_icon">
                  <i class="fas fa-chevron-down"></i>
                </span>
                    </a>
                    <div class="menu__sub_menu">
                        <!-- item -->
                        <div class="menu__sub_menu_item">
                            <h4>top categories</h4>
                            <ul>
                                <li><a href="#">men's clothing</a></li>
                                <li><a href="#">women's clothing</a></li>
                                <li><a href="#">men's shoes</a></li>
                                <li><a href="#">women's shoes</a></li>
                                <li><a href="#">clothing deals</a></li>
                            </ul>
                        </div>
                        <!-- end of item -->
                        <!-- item -->
                        <div class="menu__sub_menu_item">
                            <h4>other categories</h4>
                            <ul>
                                <li><a href="#">fine jewelry</a></li>
                                <li><a href="#">fashion jewelry</a></li>
                                <li><a href="#">men's accessories</a></li>
                                <li><a href="#">handbags & bags</a></li>
                                <li><a href="#">kid's clothing</a></li>
                            </ul>
                        </div>
                        <!-- end of item -->
                        <!-- item -->
                        <div class="menu__sub_menu_item">
                            <h2>stylish and modern fashion clothing</h2>
                            <button type="button" class="btn">shop here</button>
                        </div>
                        <!-- end of item -->
                        <!-- item -->
                        <div class="menu__sub_menu_item">
                            <img src="images/cloth.png" alt="product image">
                        </div>
                        <!-- end of item -->
                    </div>
                </li>

                <li>
                    <a href="#" class="menu__menu_link">
                        health & beauty
                        <span class="menu__drop_icon">
                  <i class="fas fa-chevron-down"></i>
                </span>
                    </a>
                    <div class="menu__sub_menu">
                        <!-- item -->
                        <div class="menu__sub_menu_item">
                            <h4>top categories</h4>
                            <ul>
                                <li><a href="#">makeup</a></li>
                                <li><a href="#">health care</a></li>
                                <li><a href="#">fragrance</a></li>
                                <li><a href="#">hair care & stylings</a></li>
                                <li><a href="#">manicure & pedicure</a></li>
                            </ul>
                        </div>
                        <!-- end of item -->
                        <!-- item -->
                        <div class="menu__sub_menu_item">
                            <h4>other categories</h4>
                            <ul>
                                <li><a href="#">skin care</a></li>
                                <li><a href="#">vitamins</a></li>
                                <li><a href="#">vision care</a></li>
                                <li><a href="#">oral care</a></li>
                                <li><a href="#">shaving & hair removal</a></li>
                            </ul>
                        </div>
                        <!-- end of item -->
                        <!-- item -->
                        <div class="menu__sub_menu_item">
                            <h2>the latest product is here</h2>
                            <button type="button" class="btn">shop here</button>
                        </div>
                        <!-- end of item -->
                        <!-- item -->
                        <div class="menu__sub_menu_item">
                            <img src="images/gymn.png" alt="product image">
                        </div>
                        <!-- end of item -->
                    </div>
                </li>

                <li>
                    <a href="#" class="menu__menu_link">
                        sports
                        <span class="menu__drop_icon">
                  <i class="fas fa-chevron-down"></i>
                </span>
                    </a>
                    <div class="menu__sub_menu">
                        <!-- item -->
                        <div class="menu__sub_menu_item">
                            <h4>top categories</h4>
                            <ul>
                                <li><a href="#">cycling</a></li>
                                <li><a href="#">outdoor sports</a></li>
                                <li><a href="#">hunting</a></li>
                                <li><a href="#">fishing</a></li>
                                <li><a href="#">fitness & yoga</a></li>
                            </ul>
                        </div>
                        <!-- end of item -->
                        <!-- item -->
                        <div class="menu__sub_menu_item">
                            <h4>other categories</h4>
                            <ul>
                                <li><a href="#">tennis</a></li>
                                <li><a href="#">swimming</a></li>
                                <li><a href="#">winter sports</a></li>
                                <li><a href="#">fitness technology</a></li>
                                <li><a href="#">sports wear</a></li>
                            </ul>
                        </div>
                        <!-- end of item -->
                        <!-- item -->
                        <div class="menu__sub_menu_item">
                            <h2>gear up for sports & adventures</h2>
                            <button type="button" class="btn">shop here</button>
                        </div>
                        <!-- end of item -->
                        <!-- item -->
                        <div class="menu__sub_menu_item">
                            <img src="images/helmet.png" alt="product image">
                        </div>
                        <!-- end of item -->
                    </div>
                </li>

                <li>
                    <a href="#">deals</a>
                </li>
            </ul>
        </div>
    </nav>
</div>
