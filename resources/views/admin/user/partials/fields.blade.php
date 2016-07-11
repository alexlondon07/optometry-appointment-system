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
                                {!!Form::text('name',null, array('class' => 'form-control', 'placeholder' => 'Ingrese Nombre'))!!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!!Form::label('first_surname', 'Primero Apellido', array('class' => 'control-label col-md-4'))!!}
                            <div class="col-md-6">
                                {!!Form::text('first_surname',null, array('class' => 'form-control', 'placeholder' => 'Ingrese primero Apellido'))!!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!!Form::label('second_surname', 'Segundo Apellido', array('class' => 'control-label col-md-4'))!!}
                            <div class="col-md-6">
                                {!!Form::text('second_surname',null, array('class' => 'form-control', 'placeholder' => 'Ingrese segundo Apellido'))!!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!!Form::label('document', 'Numero de documento', array('class' => 'control-label col-md-4'))!!}
                            <div class="col-md-6">
                                {!!Form::text('document',null, array('class' => 'form-control', 'placeholder' => 'Ingrese número de documento'))!!}
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
                                {!!Form::select('profile',array('usuario'=>'Usuario','super_admin'=>'Administrador', 'asesor'=>'Asesor(a)', 'profesor'=>'Profesor(a)'), null, array('class'=>'form-control')) !!}
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
                                {!!Form::text('email',null, array('class' => 'form-control', 'placeholder' => 'Ingrese email'))!!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!!Form::label('password', 'Contraseña', array('class' => 'control-label col-md-4'))!!}
                            <div class="col-md-6">
                                    {!!Form::password('password', array('class' => 'form-control', 'placeholder' => 'Ingrese password'))!!}
                            </div>
                        </div>
