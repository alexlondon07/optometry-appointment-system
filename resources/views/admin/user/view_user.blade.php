@extends('template.generic_admin')

@section('head_content')
@stop

@section('body_content')
  <div class="container-fluid">
    <div class="row">
      <div class="main">

        <h2 class="page-header">Usuarios</h2>

        <!--Mensajes-->
        @include('admin.alert.messages-success')
        <!--Fin Mensajes-->

        <div class="controls form-inline">
          <a href="{!! URL::to('/') !!}/admin/user/create" class="btn btn-primary">Crear Usuario</a>
          <div class="table-responsive">

            @if (count($items) > 0)
              <table id="users" class="table table-striped">
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
                              <td><a title="Detalles" href="{!! URL::to('/') !!}/admin/user/{!! $item->slug !!}"><span class="glyphicon glyphicon-eye-open btn btn-default btn-xs"></span></a></td>
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
                        <td>
                          @if(count($item->attachment) > 0)
                            <a href="{!! URL::to('/') . DIRECTORY_SEPARATOR . $item->attachment[0]->upload_path . DIRECTORY_SEPARATOR .  $item->attachment[0]->name !!}" target="_blank" >
                              <img src="{!! URL::to('/') . DIRECTORY_SEPARATOR . $item->attachment[0]->upload_path . DIRECTORY_SEPARATOR .  $item->attachment[0]->name !!}" style="max-height: 50px"/>
                            </a>
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                @endif
              </table>
            @else
            No hay datos!
            @endif
          </div>
        </div>
        
      </div>
    </div>
  @stop

  @section('javascript_content')
    <script type="text/javascript" src="{{ URL::to('/') }}/js/User.js"></script>
  @stop
