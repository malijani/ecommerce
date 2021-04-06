@extends('layouts.app_admin')

@section('page-styles')
    <link rel="stylesheet" href="{{ asset('adminrc/plugins/datatables/dataTables.bootstrap4.css')}}">
@endsection


@section('content')
    <div class="col-md-12">
        <!-- DETAILS box -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">{{ $title }}
                    <a href="{{ url()->previous() }}" role="button" class="pull-left text-white">
                        برگشت
                        <i class="fa fa-arrow-left"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="table-content">

                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr class="text-center">
                            {{--THEAD--}}
                        </tr>
                        </thead>

                        <tbody>
                        {{--TBODY--}}
                        {{--TODO : COMPLETE USER DETAILS SHOW--}}
                        </tbody>

                        <tfoot>
                        <tr class="text-center">
                            {{--TFOOT--}}
                        </tr>
                        </tfoot>

                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>



@endsection

@section('page-scripts')
    <script type="text/javascript"
            src="{{ asset('adminrc/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('adminrc/plugins/datatables/dataTables.bootstrap4.js') }}"></script>

    <script type="text/javascript">

        $(document).ready(function () {


        });


    </script>
@endsection
