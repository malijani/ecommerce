<!DOCTYPE html>
<html lang="fa">
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
            <div class="row mb-2 justify-content-center">
                <div class="col-sm-10">
                    <h1 class="text-dark">{{ $title ?? '' }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-2 text-left">
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
                <div class="row">
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
</div>
</body>
</html>
