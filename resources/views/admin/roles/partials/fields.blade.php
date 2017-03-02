<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="form-group">
    {!!Form::label('rol', 'Rol', array('class' => 'control-label col-md-4'))!!}
    <div class="col-md-6">
        {!!Form::text('rol',null, array('class' => 'form-control', 'placeholder' => 'Ingrese Rol'))!!}
    </div>
</div>
<div class="form-group">
    {!!Form::label('enable', 'Habilitado', array('class' => 'control-label col-md-4'))!!}
    <div class="col-md-6">
        {!! Form::select('enable',array('si'=>'si','no'=>'no'), null, array('class'=>'form-control')) !!}
    </div>
</div>
