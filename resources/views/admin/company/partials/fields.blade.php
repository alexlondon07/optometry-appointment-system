<input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
<div class="row">
  <div class="col-lg-6">
    <div class="input-group">
        {!!Form::label('name', 'Nombre', array('class' => 'control-label'))!!}
        {!!Form::text('name',null, array('class' => 'form-control', 'placeholder' => 'Ingrese nombre de la empresa'))!!}
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->


  <div class="col-lg-6">
    <div class="input-group">
        {!!Form::label('file', 'Firma Representante Legal', array('class' => 'control-label'))!!}
        <input type="file" name="file" accept="image/*"/>
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
</div>


<div class="form-group">
    {!!Form::label('name', 'Descripción', array('class' => 'control-label'))!!}
    <div class="col-md-12">
    {!!Form::textarea('description',null, array('class' => 'ckeditor form-control', 'placeholder' => 'Ingrese su información correspondiente'))!!}
    </div>
</div>

  <div class="col-lg-12">
    <div class="input-group"></div>
      @if(count($company->attachment) > 0)
        <div class="wrapper">
            <div id="image_refresh">
                <img src="{!! URL::to('/') . DIRECTORY_SEPARATOR . $company->attachment[0]->upload_path . DIRECTORY_SEPARATOR .  $company->attachment[0]->name !!}" style="max-height: 100px"/><br><br>
            </div>
        </div>
        {!!Form::label('file', 'Firma Representante Legal', array('class' => 'control-label'))!!}
        @endif
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->

<div class="form-group">
    <h3>Roles y Responsabilidades</h3>
</div>

<div class="form-group">
    {!! Form::hidden('details', null, array('id' => 'details')) !!}
    <input type="hidden" name="table_details" id="table_details"/>
    <div id="div_details"></div>
</div>


{{-- Información de las Roles y Responsabilidades ingresadas --}}
{{-- <table class="table table-striped">
<thead>
    <tr>
        <th>Rol</th>
        <th>Resposabilidades</th>
    </tr>
</thead>
    <tbody>
        <tr>
            <td>Prueba</td>
            <td></td>
        </tr>
        <tr>
            <td>gdfg</td>
            <td>gdg</td>
        </tr>
    </tbody>
 </table> --}}

