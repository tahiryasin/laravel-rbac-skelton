@extends('layouts.admin.app')

@section('title', 'Create Permission')

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
        
        {!! Form::open([]) !!}
        
        @foreach ($controllers as $controller=>$permissions)
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{$controller}} Permissions</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>

            <div class="ibox-content">
                @foreach($permissions as $permission)
                <div class="checkbox">
                    <label>{{ Form::checkbox('permission['.$controller.']['.$permission.']', true, true) }} {{$permission}} </label>
                </div>
                @endforeach
            </div>

        </div>
        
        @endforeach
        <div class="form-group">
            <div class="col-sm-4 col-sm-offset-2">
                <button class="btn btn-primary" type="submit">Generate</button>
                <button class="btn btn-white" type="submit">Cancel</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection