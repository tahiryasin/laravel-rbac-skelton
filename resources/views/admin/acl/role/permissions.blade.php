@extends('layouts.admin.app')

@section('title', $role->name.' Permissions')

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
        <div class="ibox">
            <div class="ibox-title">
                <div class="ibox-tools">
                    <button type="submit" class="btn btn-primary btn-xs">Apply</button>
                    <button type="button" class="btn btn-primary btn-xs" id="check-all">Check/Un-check All</button>

                </div>
            </div>

            <div class="ibox-content">
                @foreach ($permissions as $controller=>$_permissions)
                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>{{$controller}}</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>

                        <div class="ibox-content">
                            
                            @if(count($_permissions)>1)
                            <div class="checkbox">
                                <label>{{ Form::checkbox($controller, null, null, ['class'=>'check-all']) }} All </label>
                            </div>
                            @endif
                            
                            @foreach($_permissions as $permission=>$details)
                            <div class="checkbox">
                                <label>{{ Form::checkbox('permission['.$details['id'].']', 1, $details['status'], ['class'=>'permission-check permission-'.$controller]) }} {{$permission}} </label>
                            </div>
                            @endforeach
                        </div>

                    </div>
                </div>
                @endforeach
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <button class="btn btn-primary" type="submit">Apply</button>
                        <button class="btn btn-white" type="submit">Cancel</button>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>



        {!! Form::close() !!}
    </div>
</div>
@endsection

@push('scripts')
<script>
    jQuery('#check-all').click(function () {
        var checkBoxes = jQuery(".permission-check");
        checkBoxes.prop("checked", !checkBoxes.prop("checked"));
    });
    
    jQuery('.check-all').click(function () {
        var name= $(this).attr('name');
        var checkBoxes = jQuery(".permission-"+name);
        checkBoxes.prop("checked", $(this).prop("checked"));
    });
</script>
@endpush