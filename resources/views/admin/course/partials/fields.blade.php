<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="form-group">
    {!!Form::label('name', 'Nombre', array('class' => 'control-label col-md-4'))!!}
    <div class="col-md-6">
        {!!Form::text('name',null, array('class' => 'form-control', 'placeholder' => 'Ingrese Nombre'))!!}
    </div>
</div>
<div class="form-group">
    {!!Form::label('enable', 'Habilitado', array('class' => 'control-label col-md-4'))!!}
    <div class="col-md-6">
        {!! Form::select('enable',array('si'=>'si','no'=>'no'), null, array('class'=>'form-control')) !!}
    </div>
</div>
