@foreach($child_categories as $child_category)
    <li>
        <a href="{{ route('category.show', $child_category['title_en']) }}">
            {{ $child_category['title'] }}
        </a>
    </li>
    @if(!empty($child_category['children_recursive']))
        @include('front-v1.partials.shared.submenu_categories', ['child_categories' => $child_category['children_recursive']])
    @endif

@endforeach


