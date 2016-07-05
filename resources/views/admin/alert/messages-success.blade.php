<!--Se muestra mensajes-->
@if(Session::has('success_message'))
  <div class="alert alert-success" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>NOTA: </strong>{{ Session::get('success_message') }}
  </div>
@endif
