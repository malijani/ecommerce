@foreach($children as $child)
    <option value="{{ $child->id }}">{{ str_repeat('--+', $level).'> '.$child->title }}</option>
    @if($child->childrenRecursive->count())
        @include('admin.category.partials.create_form_category_child',['children' => $child->childrenRecursive ,'level' => $level+1])
    @endif
@endforeach
