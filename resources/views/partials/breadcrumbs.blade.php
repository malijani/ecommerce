@unless ($breadcrumbs->isEmpty())

    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-12 mx-auto">
                <ol class="breadcrumb shadow-sm">
                    @foreach ($breadcrumbs as $breadcrumb)

                        @if (!is_null($breadcrumb->url) && !$loop->last)
                            <li class="breadcrumb-item text-dark">
                                <a class="text-dark" href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a>
                                <i class="far fa-slash fa-rotate-270 mx-1 align-middle"></i>
                            </li>
                        @else
                            <li class="breadcrumb-item active">{{ $breadcrumb->title }}</li>
                        @endif

                    @endforeach
                </ol>
            </div>
        </div>
    </div>

@endunless
