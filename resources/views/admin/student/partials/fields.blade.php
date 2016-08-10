<div class="col-sm-6">
  <div class="form-horizontal">

    <div>
      <h3 style=''>Información de general</h3>
    </div>
    <!-- Text input-->
    <div class="form-group">
      {!!Form::label('name', 'Nombre', array('class' => 'col-md-4 control-label'))!!}
      <div class="col-md-5">
        {!!Form::text('name',null, array('class' => 'form-control input-md', 'placeholder' => 'Ingrese Nombre'))!!}
      </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
      {!!Form::label('first_surname', 'Primer apellido', array('class' => 'col-md-4 control-label'))!!}
      <div class="col-md-5">
        {!!Form::text('first_surname',null, array('class' => 'form-control input-md', 'placeholder' => 'Ingrese primer apellido'))!!}
      </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
      {!!Form::label('second_surname', 'Segundo Apellido', array('class' => 'col-md-4 control-label'))!!}
      <div class="col-md-5">
        {!!Form::text('second_surname',null, array('class' => 'form-control input-md', 'placeholder' => 'Ingrese segundo apellido'))!!}
      </div>
    </div>

    <!-- Select Basic -->
    <div class="form-group">
      <label class="col-md-4 control-label" for="document_type">Tipo de documento</label>
      <div class="col-md-5">
        {!! Form::select('document_type',array('CC'=>'Cédula','CE'=>'Cédula de extranjería','TI'=>'Tarjeta de Identidad','NIT'=>'Nit'), null, array('class'=>'form-control')) !!}
      </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
      {!!Form::label('document_of_identity', 'Número de Identifcación', array('class' => 'col-md-4 control-label'))!!}
      <div class="col-md-5">
        {!!Form::text('document_of_identity',null, array('class' => 'form-control input-md', 'placeholder' => 'Ingrese # de documento'))!!}
      </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
      {!!Form::label('date_of_birth', 'Fecha de nacimiento', array('class' => 'col-md-4 control-label'))!!}
      <div class="col-md-5">
        {!!Form::text('date_of_birth',null, array('class' => 'form-control input-md', 'placeholder' => ''))!!}
      </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
      {!!Form::label('age', 'Edad', array('class' => 'col-md-4 control-label'))!!}
      <div class="col-md-5">
        {!!Form::text('age',null, array('class' => 'form-control input-md', 'placeholder' => 'Ingrese edad'))!!}
      </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
      {!!Form::label('gender', 'Genero', array('class' => 'col-md-4 control-label'))!!}
      <div class="col-md-5">
        {!! Form::select('gender',array('seleccione'=>'Seleccione...','M'=>'M','F'=>'F'), null, array('class'=>'form-control')) !!}
      </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
      {!!Form::label('address', 'Dirección', array('class' => 'col-md-4 control-label'))!!}
      <div class="col-md-5">
        {!!Form::text('address',null, array('class' => 'form-control input-md', 'placeholder' => 'Ingrese dirección'))!!}
      </div>
    </div>

  </div>
</div>

<div class="col-sm-6">
  <div class="form-horizontal">
    <div>
      <h3 style=''>Informacion de contacto</h3>
    </div>
    <!-- Text input-->
    <div class="form-group">
      {!!Form::label('contact_name', 'Nombre de contacto', array('class' => 'col-md-4 control-label'))!!}
      <div class="col-md-5">
        {!!Form::text('contact_name',null, array('class' => 'form-control input-md', 'placeholder' => 'Ingrese nombre de contacto'))!!}
      </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
      {!!Form::label('one_contact_phone', 'Teléfono 1 de contacto', array('class' => 'col-md-4 control-label'))!!}
      <div class="col-md-5">
        {!!Form::text('one_contact_phone',null, array('class' => 'form-control input-md', 'placeholder' => 'Ingrese Teléfono 1 de contacto'))!!}
      </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
      {!!Form::label('two_contact_phone', 'Teléfono 2 de contacto', array('class' => 'col-md-4 control-label'))!!}
      <div class="col-md-5">
        {!!Form::text('two_contact_phone',null, array('class' => 'form-control input-md', 'placeholder' => 'Ingrese Teléfono 2 de contacto'))!!}
      </div>
    </div>

    <div>
      <h3 style=''>Informacion de credenciales</h3>
    </div>
    <!-- Text input-->
    <div class="form-group">
      {!!Form::label('email', 'Usuario', array('class' => 'col-md-4 control-label'))!!}
      <div class="col-md-5">
        {!!Form::email('email',null, array('class' => 'form-control input-md', 'placeholder' => 'Ingrese email'))!!}
      </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
      {!!Form::label('password', 'Contraseña', array('class' => 'col-md-4 control-label'))!!}
      <div class="col-md-5">
        {!!Form::password('password', array('class' => 'form-control input-md', 'placeholder' => 'Ingrese password'))!!}
      </div>
    </div>

    <div class="form-group">
      {!!Form::label('enable', 'Habilitado', array('class' => 'col-md-4 control-label'))!!}
      <div class="col-md-5">
        {!! Form::select('enable',array('si'=>'si','no'=>'no'), null, array('class'=>'form-control')) !!}
      </div>
    </div>

  </div>
</div>
