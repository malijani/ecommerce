<div class="col-md mt-3 mt-md-0 pt-4 pt-md-1">
    <h4 class="font-16 font-weight-bolder">
        تاییدیه و مجوز ها
    </h4>
    <hr class="w-75">
    <div class="row justify-content-center align-items-center">
        @if($footer_licenses->count()>0)

            @foreach($footer_licenses->links as $footer_license_link)
                <div class="col-12 mt-3">
                    <a href="{{ $footer_license_link->link }}"
                       class="text-dark font-weight-bolder font-14"
                    >
                        {{ $footer_license_link->title }}
                    </a>
                </div>

            @endforeach

        @else
            <div class="col-12">
                <p class="font-16 font-weight-bolder">
                    مجوز یا تاییدیه ای جهت نمایش وجود ندارد!
                </p>
            </div>
        @endif
    </div>
</div>
