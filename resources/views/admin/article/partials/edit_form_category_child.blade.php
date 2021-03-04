@foreach($children as $child)
    <option value="{{ $child->id }}"
            @if($child->id == $category_id)
                selected
            @endif
    >{{ str_repeat('--+', $level).'> '.$child->title }}</option>
    @if($child->childrenRecursive->count())
        @include('admin.article.partials.edit_form_category_child',['category_id'=>$category_id, 'children' => $child->childrenRecursive ,'level' => $level+1])
    @endif
@endforeach
