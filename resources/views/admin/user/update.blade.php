@extends('layouts.admin.app')

@section('title', 'Update User')

@section('content')


<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>User information</h5>
            </div>
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
            <div class="ibox-content">
                <form method="POST" class="form-horizontal" action="">
                    {{ csrf_field() }}
                    <div class="form-group"><label class="col-sm-2 control-label">Username</label>

                        <div class="col-sm-10"><input value="{{$user->username}}" name="username" class="form-control" type="text"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10"><input value="{{$user->email}}" name="email" class="form-control" type="email"> <span class="help-block m-b-none">A block of help text that breaks onto a new line and may extend beyond one line.</span>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Password</label>

                        <div class="col-sm-10"><input class="form-control" name="password" type="password"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Confirm Password</label>

                        <div class="col-sm-10"><input class="form-control" name="password_confirmation" type="password"></div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">User Role<br>
                            <small class="text-navy">All roles assigned to a user</small></label>

                        <div class="col-sm-10">
                            
                            @foreach($roles as $role)
                            <div class="checkbox"><label> {{ Form::checkbox('role[]', $role['slug'], $role['status']) }} {{$role['name']}}</label></div>
                            @endforeach
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">User Status</label>
                        <div class="col-sm-10">
                            <div class="radio">
                                <label>
                                    {{ Form::radio('status', 1, ($user->status == 1)) }}
                                    Active 
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    {{ Form::radio('status', 0, ($user->status == 0)) }}
                                    Inactive 
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-primary" type="submit">Save changes</button>
                            <button class="btn btn-white" type="submit">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection