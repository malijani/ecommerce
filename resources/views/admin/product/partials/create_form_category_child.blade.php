@foreach($children as $child)
    <option value="{{ $child->id }}"
        @if(!is_null($old_selected_category) && $old_selected_category == $child->id)
            selected
        @endif
    >{{ str_repeat('--+', $level).'> '.$child->title }}</option>

    @if($child->childrenRecursive->count())
        @include('admin.category.partials.create_form_category_child',['children' => $child->childrenRecursive, 'old_selected_category'=>$old_selected_category ?? null ,'level' => $level+1])
    @endif
@endforeach
