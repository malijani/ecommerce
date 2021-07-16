<div class="col-12">

    <article class="postcard light @if($loop->even) blue @else green @endif">
        <a class="postcard__img_link"
           href="{{ route('blog.show', $article->title_en) }}">
            <img class="postcard__img"
                 src="{{ asset($article->pic ?? 'images/fallback/article.png') }}"
                 alt="{{$article->pic_alt ?? $article->title_en}}"
            >
        </a>

        <div class="postcard__text t-dark">
            <h1 class="postcard__title blue">
                <a href="{{ route('blog.show', $article->title_en) }}">
                    {{$article->title}}
                </a>
            </h1>
            <div class="postcard__subtitle small">
                <time datetime="{{ verta($article->created_at) }}">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    {{ verta($article->created_at)->formatDifference() }}
                </time>
            </div>
            <div class="postcard__bar"></div>
            <div class="postcard__preview-txt">
                {!! $article->short_text ?? $article->long_text_limited !!}
            </div>
            <ul class="postcard__tagbox d-flex align-items-center">
                <li class="tag__item">
                    <i class="fal fa-tag ml-2 align-middle"></i>
                    {{ $article->category->title }}
                </li>
                <li class="tag__item">
                    <i class="fal fa-clock ml-2 align-middle"></i>
                    {{ $article->period }} دقیقه
                </li>
                <li class="tag__item">
                    <i class="fal fa-eye ml-2 align-middle"></i>
                    {{ $article->visit }} بازدید
                </li>

                <li class="tag__item">
                    <a href="{{ route('blog.show', $article->title_en) }}"
                       class="font-18"
                    >
                        <i class="fal fa-book-reader align-middle"></i>
                        ادامه مطلب...
                    </a>
                </li>
            </ul>

        </div>
    </article>

</div>
