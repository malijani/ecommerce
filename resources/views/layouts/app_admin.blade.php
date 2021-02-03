<!DOCTYPE html>
<html>
<head>
    @include('admin.partials.metas')
    <title>{{ $title ?? config('app.name') }}</title>
    @include('admin.partials.styles')
    @yield('page-styles')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

@include('admin.partials.navbar')

@include('admin.partials.aside')
<!-- Main content -->
{{--       CONTENT HEADER--}}
<!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2 justify-content-first">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ $title ?? '' }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6 text-left">
                    @yield('nav-buttons')
                </div>
                {{--                   <div class="col-sm-6">--}}
                {{--                       <ol class="breadcrumb float-sm-left">--}}
                {{--                           <li class="breadcrumb-item"><a href="#">خانه</a></li>--}}
                {{--                           <li class="breadcrumb-item active">داشبورد ورژن 2</li>--}}
                {{--                       </ol>--}}
                {{--                   </div><!-- /.col -->--}}
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    {{--       CONTENT BODY--}}
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                @include('partials.flashes')
                <div class="row justify-content-center">
                    @yield('content')
                </div>
            </div>
        </section>
    </div>

@include('admin.partials.footer')

@include('admin.partials.control-aside')

<!-- ./wrapper -->
@include('admin.partials.scripts')
@yield('page-scripts')
</body>
</html>
