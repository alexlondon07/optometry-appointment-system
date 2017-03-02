@extends('template.generic_admin')

@section('head_content')
@stop
@section('body_content')
<hr>
@if(!$show)
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10">
            <div class="">
                <div class="">
                    <h1>@if($company->id) Editar @else Crear @endif Empresa</h1>
                </div>
                <div class="panel-body">

                    {{-- Mensajes de validaciones del formulario --}}
                    @include ('admin.alert.messages-validations')
                    {{-- Fin Mensajes de validaciones del formulario --}}

                    @if($company->id)
                    {!! Form::model($company, ['id' => 'form_company', 'route' => ['admin.company.update', $company->id], 'method' => 'put', 'role'=>'form', 'class'=>'form-horizontal', 'enctype'=>'multipart/form-data']) !!}
                    @else
                    {!!Form::model($company, ['id' => 'form_company', 'route' => 'admin.company.store', 'role'=>'form', 'class'=>'form-horizontal', 'enctype'=>'multipart/form-data']) !!}
                    @endif

                    {{--Enviamos los parametros ocultos--}}
                    {!! Form::hidden('company_id', $company->id, array('id' => 'company_id')) !!}
                    {!! Form::hidden('deletable', 'true', array('id' => 'deletable')) !!}
                    {!! Form::hidden('editable', 'true', array('id' => 'editable')) !!}
                    
                    {{--Se valida que si lleguen datos correctos--}}
                    @if (!empty($company))

                    {{-- Campos del formulario --}}
                    @include ('admin.company.partials.fields')
                    {{-- Fin Campos del formulario --}}

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            {!! Form::submit('Guardar', array('class' =>'btn btn-primary', 'name'=>'save_button')) !!}
                            <span></span>
                            <a href="{{URL::to('/')}}/admin/company" class="btn btn-info">Cancelar</a>
                        </div>
                    </div>

                    @else
                    <p class="">No existe información para este item</p>
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Detalles</h3>
                </div>
                <div class="panel-body">
                    {!! Form::model($company, ['id' => 'form_company',  'role'=>'form', 'class'=>'form-horizontal']) !!}
                    @if (!empty($company))

                    {{-- Campos del formulario --}}
                    @include ('admin.company.partials.fields')
                    {{-- Fin Campos del formulario --}}

                    @else
                    <p class="">No existe información para ésta empresa</p>
                    @endif
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-4">
                            <a href="{{URL::to('/')}}/admin/company" class="btn btn-info">Volver</a>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@stop
@section('javascript_content')
<script type="text/javascript" src="{{ URL::to('/') }}/js/Company.js"></script>
@stop
