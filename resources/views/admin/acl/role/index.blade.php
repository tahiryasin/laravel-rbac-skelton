@extends('layouts.admin.app')

@section('title', 'Roles List')

@section('content')


<div class="row">
    <div class="col-lg-12">
        <div class="flash-message">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has($msg))

            <div class="alert alert-{{ $msg }}">{{ Session::get($msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>
            @endif
            @endforeach
        </div> <!-- end .flash-message -->
        <div class="ibox">
            <div class="ibox-title">
                <div class="ibox-tools">
                    <a href="{{Route("admin.acl.role.create")}}" class="btn btn-primary btn-xs">Create new role</a>
                </div>
            </div>

            <div class="ibox-content">
                <table class="table table-hover table-bordered" id="roles-table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Description</th>
                            
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
        $('#roles-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('admin.acl.role.data') !!}',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'slug', name: 'slug'},
                {data: 'description', name: 'description'},
//                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "dom": 'T<"clear">lfrtip',
            "tableTools": {
                "sSwfPath": "/js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
            },
            buttons: ['csv', 'excel', 'pdf', 'print']
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