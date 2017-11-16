@extends('layouts.admin.app')

@section('title', 'Update Role')

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
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Role information</h5>
            </div>

            <div class="ibox-content">
                @include('/admin/acl/role/form')
            </div>
        </div>
    </div>
</div>
@endsection