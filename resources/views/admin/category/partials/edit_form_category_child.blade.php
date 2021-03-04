@foreach($children as $child)
    <option value="{{ $child->id }}"
            @if(!is_null($parent_id) && $child->id == $parent_id)
                selected
            @endif
            @if($child->id == $category_id)
                disabled
            @endif

            @if(in_array($child->id, $this_children))
                disabled
            @endif

{{--            @if($child->parent_id == $last_parent)--}}
{{--                disabled--}}
{{--            @endif--}}

    >{{ str_repeat('--+', $level).'> '.$child->title }}</option>
    @if($child->childrenRecursive->count())
        @include('admin.category.partials.edit_form_category_child',['last_parent'=>$child->id,'parent_id'=>$parent_id ?? null,'category_id'=>$category_id, 'this_children'=>$this_children,'children' => $child->childrenRecursive ,'level' => $level+1])
    @endif
@endforeach
