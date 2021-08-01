@section('page-metas')

    @if(!empty($title))
        <meta name="twitter:title" content="{{ $title }}">
        <meta property="og:title" content="{{ $title }}"/>
    @endif
    @if(!empty($page_header))
        <meta name="robots" content="{{ $page_header->robots ?? 'index , follow'}}">

        @if(!empty($page_header->description))
            <meta name="twitter:description" content="{{ $page_header->description }}">
            <meta name="description" content="{{ $page_header->description }}">
            <meta property="og:description" content="{{ $page_header->description }}"/>
        @endif
        @if(!empty($page_header->keywords))
            <meta name="keywords" content="{{ $page_header->keywords }}">
        @endif
        @if(!empty($page_header->user->full_name))
            <meta name="author" content="{{$page_header->user->full_name}}">
            <meta name="twitter:creator" content="{{ $page_header->user->full_name }}">
        @endif
        @if(!empty($page_header->author))
            <meta name="author" content="{{$page_header->author}}">
            <meta name="twitter:creator" content="{{ $page_header->author }}">
        @endif
        @if(!empty($page_header->url))
            <meta property="og:url" content="{{ $page_header->url }}"/>
            <meta name="twitter:url" content="{{ $page_header->url }}">
        @endif
        @if(!empty($page_header->image))
            <meta property="og:image" content="{{ $page_header->image }}"/>
            <meta name="twitter:image" content="{{ $page_header->image }}">
        @endif
        @if(!empty($page_header->type))
            <meta property="og:type" content="{{ $page_header->type }}"/>
        @endif
    @endif
@endsection

