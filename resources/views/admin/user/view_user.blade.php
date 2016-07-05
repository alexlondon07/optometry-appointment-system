@extends('template.generic_admin')

@section('head_content')
@stop

@section('body_content')
<div class="container">
    <div class="row">
        <div class="main">
            <h2 class="page-header">Usuarios</h2>
            <h4>{!!$items->total()!!} resultados </h4>
            <div class="controls form-inline">
                <a href="{!! URL::to('/') !!}/admin/user/create" class="btn btn-primary pull-right">Crear Usuario</a>
                <div class="input-group">
                    {!! Form::open(array('url' => 'admin/users/search', 'id' => 'search_form', 'method'=>'GET', 'class'=>'control-group')) !!}
                    <div class="form-group">
                        <input id="search"  name="search"  type="text" required="true" class="form-control" placeholder="Buscar..." value="@if(isset($search)){!! $search !!}@endif" >
                    </div>
                    <button class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                    <a href="{!!URL::to('/')!!}/admin/user" title="Refrescar"class="btn btn-default"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></a>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="table-responsive">
                @if (count($items) > 0)

                <!--Mensajes-->
                @include('admin.alert.messages-success')
                <!--Fin Mensajes-->

                <table class="table table-striped">
                    @if($items->isEmpty())
                    <div class="well text-center">No se encontraron registros</div>
                    @else
                    <thead>
                        <tr>
                            <th>Acciones</th>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Usuario</th>
                            <th>Prefil</th>
                            <th>Habilitado</th>
                            <th>Imagen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr>
                            <td style="width: 150px !important">
                                <table>
                                    <tr>
                                        <td><a title="Detalles" href="{!! URL::to('/') !!}/admin/user/{!! $item->id !!}"><span class="glyphicon glyphicon-eye-open btn btn-default btn-xs"></span></a></td>
                                        <td><a title="Editar" href="{!! URL::to('/') !!}/admin/user/{!! $item->id !!}/edit"><span class="glyphicon glyphicon-pencil btn btn-default btn-xs"></span></a></td>
                                        <td>{!! Form::open(['action' => ['UserController@destroy', $item->id], 'method' => 'delete', 'style' => 'display: inline;']) !!}
                                            <button title="Eliminar" type="submit" onclick="return Util.confirmDelete(this);" class="glyphicon glyphicon-trash btn btn-default btn-xs"></button>
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td>{!! $item->id !!}</td>
                            <td>{!! $item->name !!}</td>
                             <td>{!! $item->email !!}</td>
                            <td>{!! $item->profile !!}</td>
                            <td>{!! $item->enable !!}</td>
                            <td>{!! ($item->attachment) !!}</td>
{{--                             <td>
                                @if(count($item->attachment) > 0)
                                <a href="{{AttachmentController::getAttachmentURL($item->attachment[0]->id, 'download')}}" target="_blank" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-download-alt "></span>&nbsp;&nbsp;
                                    <!--{{ $item->attachment[0]->name }}-->Descargar
                                </a><br>
                                <a href="{{AttachmentController::getAttachmentURL($item->attachment[0]->id)}}" target="_blank" >
                                    <img src="{{AttachmentController::getAttachmentURL($item->attachment[0]->id)}}" style="max-height: 50px"/>
                                </a>
                                @endif
                            </td> --}}
                            <td>
                        </tr>
                        @endforeach
                    </tbody>
                    @endif
                </table>
                {!! $items->render() !!}
                @else
                No hay datos!
                @endif
            </div>
        </div>
    </div>
</div>
@stop



