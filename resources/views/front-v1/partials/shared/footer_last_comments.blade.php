<div class="col-md mt-3 mt-md-0 pt-4 pt-md-1">
    <h4 class="font-16 font-weight-bolder">
        نقد کاربران
    </h4>
    <hr class="w-75">
    <div class="row align-items-center justify-content-center">
        @if($footer_last_comments->count() > 0)
            @foreach($footer_last_comments as $last_comment)
                <div class="col-12 mt-3">
                    <div class="row">
                        <div class="col-4">
                            <a href="{{ route('product.show', $last_comment->product->title_en) }}">
                                <img
                                    src="{{ asset($last_comment->product->files()->defaultFile()->link) }}"
                                    alt="{{ $last_comment->product->files()->defaultFile()->title }}"
                                    class="img img-fluid rounded"
                                >
                            </a>
                        </div>
                        <div class="col-8">
                            <a href=" {{ route('product.show', $last_comment->product->title_en)."#comment-". $last_comment->id }}"
                               class="text-dark"
                            >
                                <p class="font-16 font-weight-bolder">
                                    {{ $last_comment->product->title }}
                                </p>
                                <p class="font-weight-bold text-right">
                                    توسط
                                    @if(isset($last_comment->user))
                                        {{ $last_comment->user->full_name }}
                                    @else
                                        کاربر مهمان
                                    @endif
                                </p>
                                <div class="text-right">
                                    {{ Str::words($last_comment->content, 5)  }}
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12 mt-3">
                <p class="font-16 font-weight-bolder">
                    نظری از سمت کاربران جهت نمایش وجود ندارد!
                </p>
            </div>
        @endif
    </div>
</div>
