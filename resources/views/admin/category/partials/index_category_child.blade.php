<ul>
@foreach($children as $child)
    <li data="jstree-data{{$child->id}}">
        <a onclick="cat({{ $child->id }})">{{$child->title }}</a>
        @if($child->childrenRecursive->count())
            @include('admin.category.partials.index_category_child',['children' => $child->childrenRecursive])
        @endif
    </li>
@endforeach
</ul>
