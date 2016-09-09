@extends('template.generic_admin')

@section('head_content')
@stop
@section('body_content')
<hr>
@if(!$show)
<div class="container-fluid">
    <div class="row">
            <div class="">
                <h1>@if($student->id) Editar @else Crear @endif Estudiante</h1>
                <div class="panel-body">

                    {{-- Mensajes de validaciones del formulario --}}
                    @include ('admin.alert.messages-validations')
                    {{-- Fin Mensajes de validaciones del formulario --}}

                    @if($student->id)
                    {!! Form::model($student, ['id' => 'form_student', 'route' => ['admin.student.update', $student->id], 'method' => 'put', 'role'=>'form', 'class'=>'form-horizontal', 'enctype'=>'multipart/form-data']) !!}
                    @else
                    {!!Form::model($student, ['id' => 'form_student', 'route' => 'admin.student.store', 'role'=>'form', 'class'=>'form-horizontal', 'enctype'=>'multipart/form-data']) !!}
                    @endif

                    {{--Se valida que si lleguen datos correctos--}}
                    @if (!empty($student))

                    {{-- Campos del formulario --}}
                    @include ('admin.student.partials.fields')
                    {{-- Fin Campos del formulario --}}

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            {!! Form::submit('Guardar', array('class' =>'btn btn-primary', 'name'=>'save_button')) !!}
                            <span></span>
                            <a href="{{URL::to('/')}}/admin/student" class="btn btn-info">Cancelar</a>
                        </div>
                    </div>

                    @else
                    <p class="">No existe información para este estudiante</p>
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>
    </div>
</div>
@else
<div class="container-fluid">
    <div class="row">
        <div class="">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Detalles estudiante</h3>
                </div>
                <div class="panel-body">
                    {!! Form::model($student, ['id' => 'form_student',  'role'=>'form', 'class'=>'form-horizontal']) !!}
                    @if (!empty($student))

                    {{-- Campos del formulario --}}
                    @include ('admin.student.partials.fields')
                    {{-- Fin Campos del formulario --}}

                    @else
                    <p class="">No existe información para éste estudiante</p>
                    @endif
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-4">
                            <a href="{{URL::to('/')}}/admin/student" class="btn btn-info">Volver</a>
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
@stop
