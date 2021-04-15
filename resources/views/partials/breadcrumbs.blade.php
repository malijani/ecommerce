@unless ($breadcrumbs->isEmpty())

    <div class="container py-3">
        <div class="row">
            <div class="col-12 px-0">
                <ol class="breadcrumb shadow-sm">
                    @foreach ($breadcrumbs as $breadcrumb)

                        @if (!is_null($breadcrumb->url) && !$loop->last)
                            <li class="breadcrumb-item">
                                <a class="text-dark" href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a>
                                <i class="far fa-chevron-left mx-1 align-middle"></i>
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
