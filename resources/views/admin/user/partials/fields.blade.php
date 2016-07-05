                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            {!!Form::label('file', 'Imagen', array('class' => 'control-label col-md-4'))!!}
                                <div class="col-md-6">
                                <input type="file" name="file" accept="image/*"/>
                            </div>
                        </div>
                        <div class="form-group">
                            {!!Form::label('name', 'Nombre', array('class' => 'control-label col-md-4'))!!}
                            <div class="col-md-6">
                                {!!Form::text('name',null, array('class' => 'form-control'))!!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!!Form::label('document', 'Numero de documento', array('class' => 'control-label col-md-4'))!!}
                            <div class="col-md-6">
                                {!!Form::text('document',null, array('class' => 'form-control'))!!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!!Form::label('position', 'Cargo', array('class' => 'control-label col-md-4'))!!}
                            <div class="col-md-6">
                                {!!Form::text('position',null, array('class' => 'form-control'))!!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!!Form::label('profile', 'Perfil', array('class' => 'control-label col-md-4'))!!}
                            <div class="col-md-6">
                                {!!Form::select('profile',array('usuario'=>'Usuario','super_admin'=>'Administrador', 'empleado'=>'Empleado'), null, array('class'=>'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!!Form::label('enable', 'Habilitado', array('class' => 'control-label col-md-4'))!!}
                            <div class="col-md-6">
                                {!! Form::select('enable',array('si'=>'si','no'=>'no'), null, array('class'=>'form-control')) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!!Form::label('email', 'Email', array('class' => 'control-label col-md-4'))!!}
                            <div class="col-md-6">
                                {!!Form::text('email',null, array('class' => 'form-control'))!!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!!Form::label('password', 'Contraseña', array('class' => 'control-label col-md-4'))!!}
                            <div class="col-md-6">
                                    {!!Form::password('password', array('class' => 'form-control'))!!}
                            </div>
                        </div>
