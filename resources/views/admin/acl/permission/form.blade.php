
{!! Form::open(['class'=>"form-horizontal"]) !!}
{{ csrf_field() }}
<div class="form-group"><label class="col-sm-2 control-label">Name</label>
    <div class="col-sm-10">
        <input name="name" required="true" class="form-control" type="text" value='{{ old('name', $permission->name) }}'>
               <span class="help-block m-b-none">Example: create.user</span>
    </div>

</div>
<div class="hr-line-dashed"></div>
<div class="form-group"><label class="col-sm-2 control-label">Description</label>

    <div class="col-sm-10"><textarea class="form-control" name="description" >{{ old('description', $permission->description)}}</textarea></div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group">
    <div class="col-sm-4 col-sm-offset-2">
        <button class="btn btn-primary" type="submit">Save changes</button>
        <button class="btn btn-white" type="submit">Cancel</button>
    </div>
</div>
{!! Form::close() !!}
