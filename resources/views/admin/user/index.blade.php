@extends('layouts.admin.app')

@section('title', 'User List')

@section('content')


<div class="row">
    <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="ibox-tools">
                        <a href="{{Route("admin.user.create")}}" class="btn btn-primary btn-xs">Create new user</a>
                    </div>
                </div>
                <div class="flash-message">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                  @if(Session::has($msg))

                  <div class="alert alert-{{ $msg }}">{{ Session::get($msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>
                  @endif
                @endforeach
              </div> <!-- end .flash-message -->
                <div class="ibox-content">
<!--                                        <div class="row m-b-sm m-t-sm">
                                            <div class="col-md-1">
                                                <button type="button" id="loading-example-btn" class="btn btn-white btn-sm"><i class="fa fa-refresh"></i> Refresh</button>
                                            </div>
                                            <div class="col-md-11">
                                                <div class="input-group"><input placeholder="Search" class="input-sm form-control" type="text"> <span class="input-group-btn">
                                                        <button type="button" class="btn btn-sm btn-primary"> Go!</button> </span></div>
                                            </div>
                                        </div>-->
                    <table class="table table-hover table-bordered" id="users-table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(function () {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('admin.user.data') !!}',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'username', name: 'username'},
                {data: 'email', name: 'email'},
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "dom": 'T<"clear">lfrtip',
            "tableTools": {
                "sSwfPath": "/js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
            },
            buttons: ['csv','excel','pdf','print'] 
        });
    });
</script>
@endpush

@push('styles')
<style>
    body.DTTT_Print {
        background: #fff;

    }
    .DTTT_Print #page-wrapper {
        margin: 0;
        background:#fff;
    }

    button.DTTT_button, div.DTTT_button, a.DTTT_button {
        border: 1px solid #e7eaec;
        background: #fff;
        color: #676a6c;
        box-shadow: none;
        padding: 6px 8px;
    }
    button.DTTT_button:hover, div.DTTT_button:hover, a.DTTT_button:hover {
        border: 1px solid #d2d2d2;
        background: #fff;
        color: #676a6c;
        box-shadow: none;
        padding: 6px 8px;
    }

    .dataTables_filter label {
        margin-right: 5px;

    }
</style>
@endpush