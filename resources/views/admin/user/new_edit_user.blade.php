@extends('template.generic_admin')

@section('head_content')
@stop
@section('body_content')
<hr>
@if(!$show)
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">@if($user->id) Editar @else Crear @endif</h3>
                </div>
                <div class="panel-body">

                    {{-- Mensajes de validaciones del formulario --}}
                    @include ('admin.alert.messages-validations')
                    {{-- Fin Mensajes de validaciones del formulario --}}

                    @if($user->id)
                    {!! Form::model($user, ['id' => 'form_user', 'route' => ['admin.user.update', $user->id], 'method' => 'put', 'role'=>'form', 'class'=>'form-horizontal', 'enctype'=>'multipart/form-data']) !!}
                    {!! Form::hidden('email_old', $user->email, array('id'=>'email_old'))!!}
                    @else
                    {!!Form::model($user, ['id' => 'form_user', 'route' => 'admin.user.store', 'role'=>'form', 'class'=>'form-horizontal', 'enctype'=>'multipart/form-data']) !!}
                    @endif

                    {{--Se valida que si lleguen datos correctos--}}
                    @if (!empty($user))

                    {{-- Campos del formulario --}}
                    @include ('admin.user.partials.fields')
                    {{-- Fin Campos del formulario --}}

                    <div class="form-group">
                      <div class="col-md-6 col-md-offset-4">
                            {!! Form::submit('Guardar', array('class' =>'btn btn-primary', 'id'=>'save_button')) !!}
                            <span></span>
                            <a href="{{URL::to('/')}}/admin/user" class="btn btn-info">Cancelar</a>
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
                    {!! Form::model($user, ['id' => 'form_user',  'role'=>'form', 'class'=>'form-horizontal']) !!}
                    @if (!empty($user))

                    {{-- Campos del formulario --}}
                    @include ('admin.user.partials.fields')
                    {{-- Fin Campos del formulario --}}

                    @else
                    <p class="">No existe información para éste usuario</p>
                    @endif
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-4">
                            <a href="{{URL::to('/')}}/admin/user" class="btn btn-info">Volver</a>
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
