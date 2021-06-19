<div class="col-md mt-3 mt-md-0 pt-4 pt-md-1">
    <h4 class="font-16 font-weight-bolder">
        جدید ترین مقالات
    </h4>
    <hr class="w-75">
    <div class="row justify-content-center align-items-center">
        @if($footer_last_articles->count()>0)
            @foreach($footer_last_articles as $last_article)
                <div class="col-12 mt-3">
                    <div class="row">
                        <div class="col-4">
                            <a href="{{ route('blog.show', $last_article->title_en) }}">
                                <img src="{{ asset($last_article->pic) }}"
                                     alt="{{ $last_article->pic_alt }}"
                                     class="img img-fluid rounded"
                                >
                            </a>
                        </div>
                        <div class="col-8">
                            <a href="{{ route('blog.show', $last_article->title_en) }}"
                               class="text-dark font-16 font-weight-bolder"
                            >
                                {{ $last_article->title }}
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <p class="font-16 font-weight-bolder">
                    مقاله ای جهت نمایش وجود ندارد!
                </p>
            </div>
        @endif
    </div>
</div>
