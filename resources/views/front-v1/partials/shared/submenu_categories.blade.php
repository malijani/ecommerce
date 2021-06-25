<ul class="submenu">
    @foreach($child_categories as $child_category)
        <li>
            <a href="{{ route('category.show', $child_category['title_en']) }}">
                {{ $child_category['title'] }}
                @if(!empty($child_category['children_recursive']))
                    <span class="submenu_icon float-left align-middle">
                        <i class="fa fa-chevron-left"></i>
                    </span>
                @endif
            </a>

            @if(!empty($child_category['children_recursive']))
                @include('front-v1.partials.shared.submenu_categories', ['child_categories' => $child_category['children_recursive']])
            @endif
        </li>

    @endforeach
</ul>

